@php $current = request()->path(); @endphp
<nav class="flex items-center justify-between px-4 py-2 bg-white border-b border-gray-200">
    <div class="flex items-center gap-2">
        <a href="/admin/pages"
           class="text-sm font-medium px-3 py-1.5 rounded transition {{ str_contains($current, 'admin/pages') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Страницы
        </a>
        @if (Auth::check() && Auth::user()->role === 'owner')
            <a href="/admin/roles"
               class="text-sm font-medium px-3 py-1.5 rounded transition {{ str_contains($current, 'admin/roles') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Роли
            </a>
        @endif
    </div>
    <div class="flex items-center gap-2 text-sm">
        @if (Auth::check())
            <span class="text-green-500">●</span>
            <span class="font-semibold">{{ Auth::user()->name }}</span>
            @if (Auth::user()->role === 'owner')
                <span class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-0.5 rounded">хозяин</span>
            @else
                <span class="bg-gray-200 text-gray-600 text-xs font-semibold px-2 py-0.5 rounded">турист</span>
            @endif
            <a href="/admin/logout"
               class="text-red-600 hover:text-red-800 hover:bg-red-50 px-2 py-1 rounded transition">Выйти</a>
        @else
            <span class="text-red-500">●</span>
            <span class="text-gray-400">не авторизован</span>
            <a href="/admin/login"
               class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded transition">Войти</a>
        @endif
    </div>
</nav>
