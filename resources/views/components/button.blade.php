{{--
    Переиспользуемый компонент кнопки.

    @props — объявляет «именованные пропсы» компонента.
    После этого они доступны как переменные ($variant, $disabled),
    а не как HTML-атрибуты в $attributes.

    В React/TypeScript аналог:
        interface ButtonProps {
            variant?: 'primary' | 'secondary';
            disabled?: boolean;
            children: React.ReactNode;
        }
--}}

@props([
    'variant'  => 'primary',
    'disabled' => false,
])

@php
    // Базовые классы — всегда применяются независимо от варианта
    $base = 'inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    // Варианты — как объект стилей в CSS-in-JS или variants в CVA (class-variance-authority)
    $variants = [
        'primary'   => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500',
        'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-400',
    ];

    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

{{--
    $attributes->merge() — передаёт любые HTML-атрибуты, переданные снаружи компонента,
    объединяя их с нашими классами.

    Аналог в React — spread оператор:
        <button className={cn(baseClasses, variantClasses)} {...props}>

    Пример использования:
        <x-button variant="primary" type="submit" @click="handleClick()">
            Сохранить
        </x-button>
--}}
<button
    {{ $attributes->merge(['class' => $classes]) }}
    @if($disabled) disabled aria-disabled="true" @endif
>
    {{--
        $slot — содержимое между тегами <x-button>...</x-button>.
        В React это props.children:
            <Button>Купить</Button>  →  children = "Купить"
    --}}
    {{ $slot }}
</button>
