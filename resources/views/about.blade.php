{{--
    Страница "О нас".

    Аналог в Next.js App Router: app/about/page.tsx
    Аналог в Next.js Pages Router: pages/about.tsx

    <x-layouts.app> — оборачивает содержимое в общий layout (html, head, header, footer).
    Всё внутри тега становится $slot в layouts/app.blade.php.
    Аналог: export default function About() { return <Layout>...</Layout> }
--}}
<x-layouts.app>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="max-w-2xl">

            <h1 class="text-3xl font-bold text-gray-900 mb-4">О нас</h1>

            <p class="text-gray-600 mb-8">
                Это пример страницы в Laravel Blade. Контент здесь — статический,
                но контроллер может передать любые данные из базы.
            </p>

            {{--
                Данные из контроллера приходят как переменные.
                Бэкендер подготовит их — фронтендер только выводит.

                Например, если контроллер сделает:
                    return view('about', ['title' => 'О компании']);
                то здесь можно писать:
                    {{ $title }}

                @if, @foreach — аналоги тернарника и .map() в JSX.
            --}}

            {{-- route() генерирует URL по имени маршрута из routes/web.php --}}
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                Перейти на страницу контактов
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>

        </div>

    </div>

</x-layouts.app>
