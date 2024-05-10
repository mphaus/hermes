<x-slot name="title">{{ __('Edit default Discussions') }}</x-slot>
<x-slot name="heading">{{ __('Edit default Discussions') }}</x-slot>
<div class="flow">
    <x-card class="text-sm flow">
        <p>{!! __('Admin users can use this tool to download the <a href=":url" title=":title" target="_blank">JSON file</a> that has metadata about each Discussion. Admins can make edits in a text editor, upload the JSON file for the new defaults to take effect.', ['url' => 'https://en.wikipedia.org/wiki/JSON', 'title' => __('JSON file')]) !!}</p>  
        <p>{{ __('Edits can include;') }}</p>
        <ul class="pl-10 list-disc">
            <li>{{ __('Changing which default users are assigned to which Discussions') }}</li>
            <li>{{ __('The order of Discussions') }}</li>
            <li>{{ __('The Subject of Discussions') }}</li>
            <li>{{ __('Adding / removing Discussions') }}</li>
            <li>{{ __('Editing the default first-comment text') }}</li>
        </ul>
        <x-button 
            type="button" 
            variant="primary" 
            class="inline-flex mt-8"
            title="{{ __('Download current JSON config file') }}"
        >
            <span>{{ __('Current JSON config file') }}</span>
            <x-icon-download class="w-4 h-4 fill-current" />
        </x-button>
        <p>{{ __('Once downloaded, this file can be edited in a Text Editor (not Microsoft Word!). Windows Notepad is ideal, or code-editing tools like Notepad++, Brackets, or similar. .json files may not be associated with a text editor by default, but they are just text files.  ') }}</p>
        <p>{!! __('Be sure to follow the existing formatting exactly and refer to the <a href=":url" title=":title" target="_blank">Discussions Creator section of the Hermes Guide</a>. It is recommended to copy and paste people\'s names from CurrentRMS.', ['url' => 'https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/_layouts/15/Doc.aspx?sourcedoc=%7B9d7fb799-bfce-4bd7-964a-9dbceff1b470%7D&action=editnew', 'title' => __('Discussions Creator section of the Hermes Guide')]) !!}</p>
    </x-card>
    <x-card>
        <form>
            <p class="font-semibold">{{ __('Upload JSON file') }}</p>
            <x-input 
                type="file" 
                class="mt-6" 
                id=""
                name=""
                accept=""
            />
        </form>
    </x-card>   
</div>
