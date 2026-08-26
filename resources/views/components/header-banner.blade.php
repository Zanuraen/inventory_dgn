@props(['title', 'description' => null])

<div class="flex flex-col gap-4 bg-primary px-4 py-8 sm:px-6 lg:min-h-[100px] lg:flex-row lg:items-center lg:justify-between lg:px-10">
    <div>
        <h1 class="text-2xl font-bold text-white lg:text-3xl">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1 text-sm text-white/80 lg:text-base">{{ $description }}</p>
        @endif
    </div>

    @isset($action)
        <div class="shrink-0">{{ $action }}</div>
    @endisset
</div>
