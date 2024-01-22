@props(['opportunities'])

<div class="space-y-4">
    @foreach ($opportunities as $opportunity)
        <x-jobs.item :opportunity="$opportunity" />
    @endforeach
</div>
