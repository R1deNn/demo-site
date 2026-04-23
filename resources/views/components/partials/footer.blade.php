{{--
    Подвал сайта. Аналог components/layout/Footer.tsx.

    Изолированный компонент без пропсов.
    Используется только в layouts/app.blade.php.
--}}
<footer class="bg-white border-t border-gray-200 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">

            <p class="text-sm text-gray-400">
                {{-- date('Y') = new Date().getFullYear() в JS --}}
                &copy; {{ date('Y') }} {{ config('app.name') }}. Учебный проект Laravel 13.
            </p>

            <div class="flex items-center gap-4 text-sm text-gray-400">
                <span>PHP {{ PHP_MAJOR_VERSION }}.{{ PHP_MINOR_VERSION }}</span>
                <span>&middot;</span>
                <span>Laravel {{ app()->version() }}</span>
                <span>&middot;</span>
                <span>Tailwind CSS 4</span>
            </div>

        </div>
    </div>
</footer>
