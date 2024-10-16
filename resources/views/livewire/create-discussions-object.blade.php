<div 
    class="space-y-1"
    x-data="CreateDiscussionsObject"
    x-on:hermes:create-discussions-create-on-project-change.window="_createOnProject = $event.detail.createOnProject"
    x-effect="initSelect2(_createOnProject)"
>
    <x-input-label x-text="discussionObjectType">{{ __('Opportunity') }}</x-input-label>
    <select 
        class="block w-full" 
        x-ref="discussionObject"
    ></select>    
</div>
