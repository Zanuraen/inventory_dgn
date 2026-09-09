@props(['variant' => 'primary', 'href' => null, 'type' => 'button'])

@php
    $variants = [
        'primary'       => 'bg-accent text-white hover:bg-accent-bright',
        'secondary'     => 'border border-border-subtle bg-bg-surface text-text-primary hover:bg-bg-page',
        'ghost-onteal'  => 'border border-white/30 bg-white/10 text-white hover:bg-white/20',
        'danger'        => 'bg-danger-text text-white hover:opacity-90',
    ];

    $base = 'inline-flex items-center justify-center gap-2 rounded-button px-4 py-2.5 text-sm font-semibold '
          . 'transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 '
          . 'disabled:cursor-not-allowed disabled:opacity-50';

    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
