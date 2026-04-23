{{--
    Страница каталога товаров.

    <x-layout> — использование компонента-лэйаута как обёртки.
    В Next.js App Router это как экспорт metadata и обёртка в layout.tsx.
    В React Pages Router — как <Layout>...</Layout> в _app.js.

    $products — экземпляр LengthAwarePaginator, пришедший из ProductController::index().
    compact('products') в контроллере превращается в переменную $products во вью.

    В React аналог был бы:
        const { data: products, total, currentPage } = useProducts()
--}}

<x-layout>

    {{-- Заголовок страницы --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Каталог товаров</h1>

        {{--
            $products->total() — общее кол-во записей в БД (не только на текущей странице).
            Аналог: response.total в pagination-ответе REST API.
        --}}
        <p class="mt-2 text-gray-500">
            Найдено товаров: {{ $products->total() }}
        </p>
    </div>

    {{--
        @if($products->isNotEmpty()) — проверка наличия данных.
        Аналог в React: {products.length > 0 ? <Grid> : <EmptyState>}
    --}}
    @if($products->isNotEmpty())

        {{--
            CSS Grid — адаптивная сетка:
            - mobile:    1 колонка
            - sm (640px): 2 колонки
            - lg (1024px): 3 колонки

            Аналог в React + Tailwind — те же самые классы.
        --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{--
                @foreach — цикл по элементам пагинатора (только текущая страница, 6 шт).
                Аналог: products.map(product => <ProductCard key={product.id} product={product} />)
            --}}
            @foreach($products as $product)
                {{--
                    :product="$product" — передача PHP-объекта как пропса.
                    Двоеточие перед именем атрибута = PHP-выражение (не строка).
                    Аналог в JSX: product={product}  (без кавычек)
                --}}
                <x-product-card :product="$product" />
            @endforeach
        </div>

    @else

        {{-- Пустое состояние — аналог EmptyState-компонента в React --}}
        <div class="text-center py-16">
            <p class="text-gray-400 text-lg">Товары не найдены.</p>
        </div>

    @endif

    {{--
        Пагинация.
        $products->hasPages() — true если страниц больше одной (не рендерим пустой nav).
        $products->withQueryString() — сохраняет GET-параметры (?search=...) при переходе.
        ->links() — рендерит HTML-навигацию со стилями Tailwind.

        В React аналог — компонент вида:
            <Pagination
                page={currentPage}
                total={total}
                perPage={6}
                onChange={setPage}
            />
    --}}
    @if($products->hasPages())
        <div class="mt-8">
            {{ $products->withQueryString()->links() }}
        </div>
    @endif

</x-layout>
