{{--
    Карточка товара. Feature-компонент (не UI-примитив).

    Аналог: components/product/ProductCard.tsx
    Принимает единственный пропс — объект $product (Eloquent-модель).

    В TypeScript это выглядело бы так:
        interface Product {
            id: number
            name: string
            description: string
            price: number      // копейки
            in_stock: boolean
        }
        function ProductCard({ product }: { product: Product }) { ... }
--}}

@props(['product'])

<article class="group bg-white rounded-2xl border border-gray-200 overflow-hidden flex flex-col
                shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">

    {{-- ─── Обложка ──────────────────────────────────────────────────────────── --}}
    <div class="relative h-52 bg-gradient-to-br from-slate-100 to-indigo-50 overflow-hidden">

        {{-- Декоративный паттерн поверх градиента --}}
        <div class="absolute inset-0 opacity-30"
             style="background-image: radial-gradient(circle at 2px 2px, #c7d2fe 1px, transparent 0); background-size: 24px 24px;"></div>

        {{-- Иконка-плейсхолдер --}}
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-20 h-20 rounded-2xl bg-white/80 backdrop-blur-sm shadow-sm flex items-center justify-center
                        group-hover:scale-105 transition-transform duration-200">
                <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
        </div>

        {{--
            Бейдж наличия — позиционируется абсолютно в углу карточки.
            Аналог position: absolute + top/right в CSS-in-JS.

            @if / @else — это условный рендеринг.
            Эквивалент в JSX:
                {product.in_stock
                    ? <Badge variant="success">В наличии</Badge>
                    : <Badge variant="muted">Нет в наличии</Badge>}
        --}}
        @if($product->in_stock)
            <span class="absolute top-3 right-3 inline-flex items-center gap-1 px-2 py-1 rounded-full
                         text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                В наличии
            </span>
        @else
            <span class="absolute top-3 right-3 inline-flex items-center gap-1 px-2 py-1 rounded-full
                         text-xs font-medium bg-gray-100 text-gray-500 ring-1 ring-gray-200">
                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                Нет в наличии
            </span>
        @endif

    </div>

    {{-- ─── Контент карточки ─────────────────────────────────────────────────── --}}
    <div class="flex flex-col flex-1 p-5">

        {{--
            {{ $product->name }} — вывод с автоэкранированием (защита от XSS).
            Аналог {product.name} в JSX.
            Blade обёртывает в htmlspecialchars() — как React escapes строки.
        --}}
        <h2 class="text-sm font-semibold text-gray-900 leading-snug line-clamp-2 mb-1.5">
            {{ $product->name }}
        </h2>

        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 flex-1 mb-4">
            {{ $product->description }}
        </p>

        {{-- ─── Футер карточки: цена + кнопка ─────────────────────────────── --}}
        <div class="flex items-center justify-between pt-4 border-t border-gray-100">

            <div class="flex flex-col">
                <span class="text-xs text-gray-400 leading-none mb-0.5">Цена</span>
                {{--
                    number_format(value, decimals, decimal_sep, thousands_sep)
                    899900 / 100 = 8999.00 → "8 999,00 ₽"

                    JS-аналог:
                        (product.price / 100).toLocaleString('ru-RU', {
                            style: 'currency', currency: 'RUB'
                        })
                --}}
                <span class="text-lg font-bold text-gray-900 leading-tight">
                    {{ number_format($product->price / 100, 2, ',', ' ') }} ₽
                </span>
            </div>

            {{--
                <x-ui.button> — компонент из ui/ директории.
                Blade резолвит имя компонента по точкам в путь:
                    ui.button  →  components/ui/button.blade.php

                :disabled="!$product->in_stock" — двоеточие = PHP-выражение.
                Аналог disabled={!product.in_stock} в JSX.
            --}}
            <x-ui.button
                :variant="$product->in_stock ? 'primary' : 'secondary'"
                :disabled="!$product->in_stock"
                size="sm"
            >
                @if($product->in_stock)
                    Купить
                @else
                    Недоступно
                @endif
            </x-ui.button>

        </div>
    </div>

</article>
