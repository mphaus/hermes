<x-input 
    type="text"
    placeholder="Ex: A-26"
    x-data="QiIntakeLocation"
    x-modelable="value"
    x-on:input="applyMask"
    x-on:keydown="removeValue"
    {{ $attributes }}
/>
