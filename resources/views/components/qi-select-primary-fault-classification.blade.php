<select
    class="w-full"
    x-data="QiSelectPrimaryFaultClassification"
    x-modelable="value"
    x-effect="checkValue(value)"
    {{ $attributes }}
>
    <option value=""></option>
    @foreach ($getClassification() as $classification)
        <option value="{{ $classification['text'] }}" data-example="{{ $classification['example'] }}">{{ $classification['text'] }}</option>
    @endforeach
</select>
