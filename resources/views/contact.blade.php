{{--
    Страница "Контакты".

    Маршрут объявлен в routes/web.php:
        Route::view('/contact', 'contact')->name('contact');

    Route::view() — сокращение: Laravel сам рендерит вьюшку без контроллера.
    Когда понадобится логика (форма, валидация) — контроллер добавляется отдельно,
    вьюшка при этом не меняется.
--}}
<x-layouts.app>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="max-w-2xl">

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Контакты</h1>

            <p class="text-gray-600 mb-8">
                Это пример второй страницы. Она использует тот же layout и те же компоненты,
                что и остальные страницы сайта.
            </p>

            {{--
                route('about') — генерирует URL по имени маршрута.
                Безопаснее, чем href="/about": если URL изменится в web.php,
                ссылки обновятся автоматически по всему проекту.

                Blade-компоненты можно вызвать и здесь: <x-ui.button>,
                но компонент рендерит <button>, а не <a>.
                Для ссылок используй обычный тег — это стандартная практика.
            --}}
            <a href="{{ route('about') }}"
               class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
                Вернуться на страницу «О нас»
            </a>

        </div>

    </div>

</x-layouts.app>
