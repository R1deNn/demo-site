{{--
    Шапка сайта. Изолированный компонент — не знает о layout-е вокруг себя.

    Аналог: components/layout/Header.tsx в Next.js
    Используется только в layouts/app.blade.php — как импорт в корневом layout.

    Нет пропсов — данные берутся из глобального конфига (config(), url()).
    В React это называется "stateless presentational component".
--}}
<header class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Логотип / бренд --}}
            <div class="flex items-center gap-8">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-gray-900 hover:text-indigo-600 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="font-semibold text-lg tracking-tight">
                        {{-- config('app.name') = APP_NAME из .env --}}
                        {{ config('app.name') }}
                    </span>
                </a>

                {{--
                    Навигация — скрыта на мобильных (hidden sm:flex).
                    В React это обычно <nav> внутри <Header> с условным рендером для mobile menu.
                --}}
                <nav class="hidden sm:flex items-center gap-1">
                    {{--
                        request()->is('/') — проверяет текущий URL.
                        Аналог usePathname() в Next.js:
                            const pathname = usePathname()
                            const isActive = pathname === '/'
                    --}}
                    <a href="{{ url('/') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition-colors
                              {{ request()->is('/') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        Каталог
                    </a>
                </nav>
            </div>

            {{-- Правая часть шапки — иконки действий --}}
            <div class="flex items-center gap-2">
                <button type="button"
                        class="relative p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors"
                        aria-label="Корзина">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    {{-- Бейдж с количеством — декоративный --}}
                    <span class="absolute -top-0.5 -right-0.5 h-4 w-4 rounded-full bg-indigo-600 text-white text-[10px] font-bold flex items-center justify-center">
                        0
                    </span>
                </button>
            </div>

        </div>
    </div>
</header>
