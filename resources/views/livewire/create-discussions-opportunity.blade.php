<div class="space-y-1">
    <x-input-label value="{{ __('Opportunity') }}" class="!text-xs" />
    <select 
        class="block w-full" 
        x-data="CreateDiscussionsOpportunity"
        x-on:hermes:create-discussions-create-on-project-change.window="console.log($event)"
    ></select>    
</div>
