{{--
    Примитив кнопки из UI-слоя. Аналог ui/button.tsx (shadcn/ui, Radix и т.д.)

    Принимает:
        variant — 'primary' | 'secondary' | 'ghost'  (дефолт: 'primary')
        size    — 'sm' | 'md' | 'lg'                  (дефолт: 'md')
        disabled — boolean                             (дефолт: false)

    @props — объявляет "именованные пропсы".
    Всё, что не объявлено в @props, остаётся в $attributes и передаётся
    через merge() на HTML-элемент. Это как ...rest в JSX:

        function Button({ variant, size, disabled, ...rest }) {
            return <button {...rest} className={cn(base, variants[variant])} />
        }
--}}

@props([
    'variant'  => 'primary',
    'size'     => 'md',
    'disabled' => false,
])

@php
    $sizes = [
        'sm' => 'h-8  px-3   text-xs  gap-1.5',
        'md' => 'h-9  px-4   text-sm  gap-2',
        'lg' => 'h-11 px-6   text-base gap-2',
    ];

    $variants = [
        'primary'   => 'bg-indigo-600 text-white shadow-sm hover:bg-indigo-700 focus-visible:ring-indigo-500',
        'secondary' => 'bg-white text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:ring-gray-400',
        'ghost'     => 'text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus-visible:ring-gray-400',
    ];

    $base = 'inline-flex items-center justify-center rounded-md font-medium whitespace-nowrap transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50';

    $classes = implode(' ', [
        $base,
        $sizes[$size]    ?? $sizes['md'],
        $variants[$variant] ?? $variants['primary'],
    ]);
@endphp

<button
    {{ $attributes->merge(['class' => $classes]) }}
    @if($disabled) disabled aria-disabled="true" @endif
>
    {{-- $slot = children в React --}}
    {{ $slot }}
</button>
