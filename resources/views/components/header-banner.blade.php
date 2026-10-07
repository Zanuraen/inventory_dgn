@props(['title', 'description' => null])

<div class="mx-4 mt-4 flex flex-col gap-3 rounded-lg bg-primary px-6 py-5 text-white sm:mx-6 sm:mt-6 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-lg font-bold">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1 text-sm text-blue-200">{{ $description }}</p>
        @endif
    </div>

    @isset($action)
        <div class="shrink-0">{{ $action }}</div>
    @endisset
</div>