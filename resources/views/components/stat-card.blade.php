@props(['label', 'value', 'iconBg' => 'bg-info-bg', 'iconColor' => 'text-primary'])

<div class="flex items-start gap-4 rounded-card border border-border-subtle bg-bg-surface p-5 shadow-card">
    @isset($icon)
        <div class="{{ $iconBg }} {{ $iconColor }} flex h-10 w-10 shrink-0 items-center justify-center rounded-lg">
            {{ $icon }}
        </div>
    @endisset

    <div class="min-w-0">
        <p class="truncate text-xs font-semibold uppercase tracking-wide text-text-secondary">{{ $label }}</p>
        <p class="mt-1 text-2xl font-bold text-text-primary lg:text-3xl">{{ $value }}</p>
    </div>
</div>
