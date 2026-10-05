@props(['title', 'description' => null])

<div class="flex flex-col gap-2 bg-primary px-4 py-6 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-10">
    <div>
        <h1 class="text-lg font-bold text-white lg:text-xl">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1 text-sm text-white/80">{{ $description }}</p>
        @endif
    </div>

    @isset($action)
        <div class="shrink-0">{{ $action }}</div>
    @endisset
</div>