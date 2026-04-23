{{--
    Корневой лэйаут приложения.

    Аналог в Next.js App Router — файл app/layout.tsx
    Аналог в Next.js Pages Router — файл pages/_app.js или pages/_document.js

    Всё, что обёрнуто в <x-layout>...</x-layout> во вью,
    попадёт сюда через {{ $slot }}.
--}}
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- config('app.name') читает APP_NAME из .env — аналог process.env.NEXT_PUBLIC_APP_NAME --}}
    <title>{{ config('app.name') }} — Каталог товаров</title>

    {{--
        @vite() подключает CSS и JS, скомпилированные Vite.
        При dev-сервере: подключает HMR-сокет (горячая перезагрузка).
        При prod-сборке: подставляет хэшированные пути из public/build/manifest.json.
        Аналог: автоматический <link> и <script> тег в Next.js при импорте стилей.
    --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 flex flex-col">

    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            {{-- route('/') генерирует URL до маршрута / — как href="/" в Next.js <Link> --}}
            <a href="{{ url('/') }}" class="text-xl font-bold text-indigo-600 hover:text-indigo-500 transition-colors">
                {{ config('app.name') }}
            </a>
            <nav class="text-sm text-gray-500">Каталог товаров</nav>
        </div>
    </header>

    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        {{--
            $slot — основное содержимое, переданное между тегами <x-layout>...</x-layout>.
            В React это props.children — всё, что вы пишете внутри компонента-обёртки:

            // React
            export default function Layout({ children }) {
                return <main>{children}</main>
            }
        --}}
        {{ $slot }}
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center text-sm text-gray-400">
            {{-- date('Y') — текущий год, аналог new Date().getFullYear() в JS --}}
            &copy; {{ date('Y') }} {{ config('app.name') }}. Учебный проект на Laravel 13.
        </div>
    </footer>

</body>
</html>
