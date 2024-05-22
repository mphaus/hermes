@props(['mappings'])

<div {{ $attributes->merge(['class' => 'overflow-x-auto']) }}>
    <table class="w-full text-sm border table-auto border-slate-500">
        <thead>
            <tr class="bg-gray-300">
                <th class="w-1/6 p-1 border border-slate-500">{{ __('Discussion title') }}</th>
                <th class="w-1/6 p-1 border border-slate-500">{{ __('Discussion participants') }}</th>
                <th class="w-4/6 p-1 border border-slate-500">{{ __('Initial message') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mappings as $mapping)
                <tr>
                    <td class="p-3 border border-slate-500">{{ $mapping['title'] }}</td>
                    <td class="p-3 space-y-1 border border-slate-500">
                        @if ($mapping['include_opportunity_owner_as_participant'])
                            <p x-text="owner"></p>
                        @endif
                        @if (empty($mapping['participants']) === false)
                            @foreach ($mapping['participants'] as $participant)
                                <p>{{ $participant['full_name'] }}</p>
                            @endforeach
                        @endif
                    </td>
                    <td class="p-3 space-y-2 border border-slate-500">{!! $mapping['first_message'] !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
