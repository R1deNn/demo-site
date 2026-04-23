{{--
    Карточка товара.

    @props(['product']) — объявляем, что компонент принимает объект $product.

    В React аналог:
        function ProductCard({ product }: { product: Product }) { ... }

    $product — это Eloquent-модель (PHP-объект). Обращение к полям:
        $product->name       // как product.name в JS
        $product->price      // integer, хранится в копейках
        $product->in_stock   // boolean (автоматически приведён через casts())
--}}

@props(['product'])

<article class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition-shadow duration-200">

    {{-- Цветной плейсхолдер вместо реального изображения --}}
    <div class="h-48 bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
        <svg class="w-16 h-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
    </div>

    <div class="p-5 flex flex-col flex-1">

        {{--
            {{ $product->name }} — Blade выводит данные с HTML-экранированием (XSS-защита).
            Аналог {product.name} в JSX — React тоже экранирует строки по умолчанию.
            Если нужен сырой HTML: {!! $product->name !!} (используй осторожно!)
        --}}
        <h2 class="text-base font-semibold text-gray-900 mb-1 line-clamp-2">
            {{ $product->name }}
        </h2>

        <p class="text-sm text-gray-500 mb-4 flex-1 line-clamp-3">
            {{ $product->description }}
        </p>

        <div class="flex items-center justify-between mt-auto">

            {{--
                Цена хранится в копейках (integer).
                number_format(значение, знаки_после_запятой, разделитель_дроби, разделитель_тысяч)

                Пример: 899900 / 100 = 8999.00 → "8 999,00 ₽"

                Аналог в JavaScript:
                    (product.price / 100).toLocaleString('ru-RU', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + ' ₽'
            --}}
            <span class="text-lg font-bold text-gray-900">
                {{ number_format($product->price / 100, 2, ',', ' ') }} ₽
            </span>

            {{--
                Условный рендеринг через @if — аналог тернарного оператора в JSX:
                    {product.in_stock
                        ? <Button variant="primary">Купить</Button>
                        : <Button variant="secondary" disabled>Нет в наличии</Button>}

                :disabled="true" — двоеточие означает PHP-выражение (не строка).
                Аналог disabled={true} в JSX.
            --}}
            @if($product->in_stock)
                <x-button variant="primary">
                    Купить
                </x-button>
            @else
                <x-button variant="secondary" :disabled="true">
                    Нет в наличии
                </x-button>
            @endif

        </div>

    </div>
</article>
