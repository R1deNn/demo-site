{{--
    HTML-оболочка приложения. Отвечает только за <html>, <head>, <body>.

    Аналог в Next.js Pages Router: pages/_document.tsx
    Аналог в Next.js App Router: app/layout.tsx (корневой)

    Не содержит UI — только подключает ассеты и вставляет партиалы.
    Всё содержимое страницы приходит через $slot.
--}}
<!DOCTYPE html>
<html lang="ru" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- config() читает .env через конфиг-файл — безопаснее, чем env() напрямую во вью --}}
    <title>{{ config('app.name') }}</title>

    {{--
        @vite() — единственная точка подключения CSS и JS.

        В dev-режиме (npm run dev): подключает HMR через WebSocket,
        стили применяются мгновенно без перезагрузки страницы.

        В prod-режиме (npm run build): подставляет хэшированные пути из
        public/build/manifest.json — как cache-busting в Webpack/Vite.

        React-аналог: в Next.js это происходит автоматически при импорте
        import '@/styles/globals.css' в _app.tsx.
    --}}
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>
<body class="h-full bg-gray-50 text-gray-900 antialiased">

    <div class="min-h-full flex flex-col">

        {{--
            <x-partials.header /> — подключение дочернего компонента по имени файла.
            Blade автоматически ищет: resources/views/components/partials/header.blade.php
            Аналог: import Header from '@/components/partials/Header'  →  <Header />
        --}}
        <x-partials.header />

        {{--
            $slot — основной контент страницы.
            В React это props.children:
                export default function Layout({ children }) {
                    return <div>{children}</div>
                }
        --}}
        <main class="flex-1">
            {{ $slot }}
        </main>

        <x-partials.footer />

    </div>

</body>
</html>
