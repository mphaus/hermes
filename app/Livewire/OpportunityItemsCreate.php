<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class OpportunityItemsCreate extends Component
{
    use WithFileUploads;

    #[Validate('file', message: 'This field must be a file.')]
    #[Validate('max:1024', message: 'The :attribute field must not be greater than :max kilobytes.')]
    #[Validate('mimes:csv', message: 'The file must be a file of type: :values.')]
    public $csvfile;

    #[Locked]
    public array $job = [];

    #[Locked]
    public int $opportunityId = 0;

    public function mount(array $job): void
    {
        $this->job = $job;
        $this->opportunityId = App::environment(['local', 'staging']) ? config('app.mph_test_opportunity_id') : $this->job['id'];
    }

    public function save(): mixed
    {
        $filename = Arr::join([
            $this->job['id'],
            now()->setTimezone(config('app.timezone'))->getTimestamp(),
            str()->slug($this->job['subject']),
        ], '-', '-') . '.csv';

        $this->csvfile->storeAs(path: 'csv_files', name: $filename);

        $items = [];
        $headings = null;
        $requiredHeadings = ['id', 'quantity', 'group_name'];

        if (($handle = fopen(base_path() . '/storage/app/csv_files/' . $filename, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($headings === null) {
                    $headings = $row;

                    // VALIDATE HEADINGS
                    $diff = array_diff($requiredHeadings, $headings);

                    if (count($diff) > 0) {
                        fclose($handle);
                        $missingHeadings = Arr::join($diff, ', ', ' and ');
                        throw ValidationException::withMessages(['csvfile' => __('The uploaded csv file does not contain the valid headings required to identify the items. Missing headings: :missing_headings.', ['missing_headings' => $missingHeadings])]);
                    }

                    continue;
                }

                $items[] = array_combine($headings, $row);
            }
            fclose($handle);
        }

        // EXTRACT EXISTING GROUPS
        $existingGroups = array_values(
            array_map(
                fn ($group) => ['id' => $group['id'], 'name' => $group['name']],
                array_filter(
                    $this->job['opportunity_items'],
                    fn ($item) => $item['opportunity_item_type_name'] === 'Group'
                )
            )
        );

        // EXTRACT GROUPS SENT OVER THE FILE IN A DISTINCT WAY
        $groups = array_unique(
            array_map(
                fn ($item) => $item['group_name'],
                $items
            )
        );

        // CHECK IF GROUPS SENT OVER THE FILE ARE PRESENT IN THE EXISTING GROUPS FROM THE JOB
        $groupDiff = array_diff(
            $groups,
            array_map(fn ($group) => $group['name'], $existingGroups),
        );

        // CREATE NEW GROUPS USING THE API IF NEEDED
        if (count($groupDiff) > 0) {
            $responses = $this->createGroups($groupDiff);

            foreach ($responses as $response) {
                if ($response['state'] !== 'fulfilled') {
                    continue;
                }

                $newGroup = json_decode($response['value']->getBody()->getContents(), true);
                $existingGroups[] = [
                    'id' => $newGroup['opportunity_item']['id'],
                    'name' => $newGroup['opportunity_item']['name'],
                ];
            }
        }

        // CREATE OPPORTUNITY ITEMS
        $this->storeItems($items, $existingGroups);

        dd('Success');
    }

    protected function createGroups(array $groups): array
    {
        $opportunityId = $this->opportunityId;
        $client = new Client(['base_uri' => config('app.current_rms.host')]);
        $promises = array_map(function ($group) use ($client, $opportunityId) {
            $headers = [
                'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
                'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
            ];

            $query = [
                'opportunity_item' => [
                    'opportunity_id' => $opportunityId,
                    'opportunity_item_type_name' => 'Group',
                    'name' => $group,
                    'opportunity_item_type' => 0,
                ],
            ];

            return $client->postAsync("opportunities/{$opportunityId}/opportunity_items", [
                'headers' => $headers,
                'query' => $query,
            ]);
        }, $groups);

        $responses = Promise\Utils::settle($promises)->wait();

        return $responses;
    }

    protected function storeItems(array $items, array $groups = [])
    {
        $opportunityId = $this->opportunityId;
        ['opportunity_items' => $opportunityItems] = $this->job;
        $client = new Client(['base_uri' => config('app.current_rms.host')]);
        $promises = [];

        $promises = array_map(function ($item) use ($client, $opportunityId, $opportunityItems, $groups) {
            // PREPARE ITEM DATA
            [
                'id' => $id,
                'quantity' => $quantity,
                'group_name' => $groupName,
            ] = $item;

            $id = intval($id);
            $quantity = intval($quantity);

            $headers = [
                'X-AUTH-TOKEN' => config('app.current_rms.auth_token'),
                'X-SUBDOMAIN' => config('app.current_rms.subdomain'),
            ];

            // CHECK IF ITEM ALREADY EXISTS IN JOB
            $itemIds = array_column($opportunityItems, 'item_id');
            $index = array_search($id, $itemIds);

            dd($index, $opportunityItems[$index]);

            if ($quantity <= 0) {
                return $client->deleteAsync("opportunities/{$opportunityId}/opportunity_items/{$id}", ['headers' => $headers]);
            }

            $query = [
                'opportunity_item' => [
                    'opportunity_id' => $opportunityId,
                    'item_id' => $id,
                    'quantity' => $quantity,
                    'price' => 0,
                ],
            ];

            // GET GROUP ID TO BE ADDED TO
            $groupIds = array_values(array_map(function ($group) {
                return $group['id'];
            }, array_filter($groups, function ($group) use ($groupName) {
                return $group['name'] === $groupName;
            })));

            if (count($groupIds) > 0) {
                [$groupId] = $groupIds;
                $query['opportunity_item']['parent_opportunity_item_id'] = $groupId;
            }

            return $client->postAsync("opportunities/{$opportunityId}/opportunity_items", [
                'headers' => $headers,
                'query' => $query,
            ]);
        }, $items);

        $responses = Promise\Utils::settle($promises)->wait();

        return $responses;
    }

    public function render(): View
    {
        return view('livewire.opportunity-items-create');
    }
}
