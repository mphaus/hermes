<?php

namespace App\Http\Requests;

use App\Traits\WithHttpCurrentError;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

class TechnicalSupervisorRequest extends FormRequest
{
    use WithHttpCurrentError;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return usercan('crud-technical-supervisors');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|alpha_dash',
            'last_name' => 'required|alpha_dash',
        ];
    }

    public function store(int $id = 0): void
    {
        $technical_supervisors_list_id = config('app.mph.technical_supervisor_list_id');

        $response = Http::current()->get("list_names/{$technical_supervisors_list_id}");

        if ($response->failed()) {
            throw new HttpResponseException(
                response()->json([
                    'message' => $this->errorMessage(
                        __('An error occurred while attempting to save the data. Please refresh the page and try again.'),
                        $response->json()
                    ),
                ], 400)
            );
        }

        ['list_name' => ['list_values' => $list_values]] = $response->json();

        ['first_name' => $first_name, 'last_name' => $last_name] = $this->validated();

        /**
         * @var string $first_name
         * @var string $last_name
         */

        if ($id > 0) {
            $column = array_column($list_values, 'id');
            $i = array_search($id, $column);
            $list_values[$i]['name'] = "{$first_name} {$last_name}";
            $data = [...$list_values];
        } else {
            $data = [
                ...$list_values,
                [
                    'list_name_id' => intval($technical_supervisors_list_id),
                    'name' => "{$first_name} {$last_name}",
                ],
            ];
        }

        $response = Http::current()->put("list_names/{$technical_supervisors_list_id}", [
            'list_name' => [
                'list_values' => $data,
            ],
        ]);

        if ($response->failed()) {
            throw new HttpResponseException(
                response()->json([
                    'message' => $this->errorMessage(
                        __('An error occurred while attempting to save the data. Please refresh the page and try again.'),
                        $response->json()
                    ),
                ], 400)
            );
        }
    }
}
