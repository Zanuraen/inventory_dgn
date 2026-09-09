@props(['status' => 'neutral'])

@php
    $map = [
        'success' => 'bg-success-bg text-success-text',
        'danger'  => 'bg-danger-bg text-danger-text',
        'warning' => 'bg-warning-bg text-warning-text',
        'info'    => 'bg-info-bg text-info-text',
        'neutral' => 'bg-neutral-bg text-neutral-text',
    ];

    $classes = $map[$status] ?? $map['neutral'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium $classes"]) }}>
    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
    {{ $slot }}
</span>
