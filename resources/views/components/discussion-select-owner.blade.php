<div x-data="DiscussionSelectOwner">
    <template hidden x-if="fetching">
        <div class="h-10 bg-gray-200 rounded-lg animate-pulse"></div>
    </template>
    <template hidden x-if="hasFetched && members">
        <select
            class="w-full"
            {{ $attributes }}
        >
            <template hidden x-for="member in members" x-bind:key="member.id">
                <option x-bind:value="member.id" x-text="member.name"></option>
            </template>
        </select>
    </template>
</div>
