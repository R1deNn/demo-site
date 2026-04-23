{{--
    Страница каталога товаров. Аналог pages/index.tsx или app/page.tsx в Next.js.

    <x-layouts.app> — корневой layout (HTML-оболочка + шапка + подвал).
    Blade резолвит имя: layouts.app → components/layouts/app.blade.php
    Аналог: export default function Page() { return <AppLayout>...</AppLayout> }

    $products — LengthAwarePaginator из ProductController::index().
    Передан через compact('products') → переменная $products во вью.

    В React-мире это был бы пропс или результат хука:
        const { data: products, total } = useProducts({ page })
--}}

<x-layouts.app>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- ─── Заголовок страницы ──────────────────────────────────────────── --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Каталог товаров
                </h1>
                {{--
                    $products->total() — общее кол-во записей в БД (не только текущей страницы).
                    Аналог: response.pagination.total в REST API-ответе.
                --}}
                <p class="mt-1 text-sm text-gray-500">
                    {{ $products->total() }} {{ trans_choice('товар|товара|товаров', $products->total()) }}
                </p>
            </div>

            {{-- Информация о текущей странице --}}
            @if($products->hasPages())
                <p class="text-sm text-gray-400 shrink-0">
                    Страница {{ $products->currentPage() }} из {{ $products->lastPage() }}
                </p>
            @endif
        </div>

        {{-- ─── Сетка товаров ───────────────────────────────────────────────── --}}
        {{--
            @if($products->isNotEmpty()) — проверка наличия данных.
            Аналог в React: {products.length > 0 ? <Grid /> : <EmptyState />}
        --}}
        @if($products->isNotEmpty())

            {{--
                Адаптивный CSS Grid:
                    1 колонка  → mobile  (<640px)
                    2 колонки  → sm      (≥640px)
                    3 колонки  → lg      (≥1024px)

                Те же Tailwind-классы работают в React-компонентах — синтаксис идентичен.
            --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                {{--
                    @foreach — итерация по текущей странице пагинатора (6 элементов).
                    Аналог: products.map(product => ...)

                    :product="$product" — передача объекта как пропса.
                    Двоеточие = PHP-выражение (не строка).
                    Аналог product={product} в JSX.
                --}}
                @foreach($products as $product)
                    <x-product.card :product="$product" />
                @endforeach
            </div>

        @else

            {{-- ─── Пустое состояние ─────────────────────────────────────── --}}
            {{-- Аналог компонента <EmptyState /> в React --}}
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">Товары не найдены</p>
                <p class="text-gray-400 text-sm mt-1">Попробуйте позже</p>
            </div>

        @endif

        {{-- ─── Пагинация ───────────────────────────────────────────────────── --}}
        {{--
            $products->hasPages() — true если страниц больше одной.
            Без этой проверки links() рендерит пустой <nav>, что нарушает семантику.

            ->withQueryString() сохраняет GET-параметры (?search=..., ?sort=...)
            при переходе между страницами. Аналог router.push({ query: {...currentQuery, page} })
            в Next.js.

            ->links() рендерит HTML через шаблон pagination/tailwind.blade.php из Laravel.
            Paginator::useTailwind() в AppServiceProvider говорит Laravel использовать
            именно этот шаблон.
        --}}
        @if($products->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $products->withQueryString()->links() }}
            </div>
        @endif

    </div>

</x-layouts.app>
