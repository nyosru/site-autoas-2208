@extends('admin.layouts.app')

@section('title', 'Управление страницами')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Управление страницами</h2>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b text-left">
                    <th class="px-4 py-3 font-semibold text-gray-600">ID</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Модуль</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Название</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Описание</th>
                    <th class="px-4 py-3 font-semibold text-gray-600"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($pages as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        @if (Auth::user()->role === 'owner'){{ $p->id }}@endif
                    </td>
                    <td class="px-4 py-3">{{ $p->module }}</td>
                    <td class="px-4 py-3 font-medium">{{ $p->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $p->opis }}</td>
                    <td class="px-4 py-3">
                        @if (Auth::user()->role === 'owner')
{{--                            <a href="/admin/pages/{{ $p->id }}/edit"--}}
{{--                               class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded transition">--}}
{{--                                Редактировать--}}
{{--                            </a>--}}
                            <a href="/admin/pages/{{ $p->id }}/edit-ck"
                               class="inline-block bg-purple-600 hover:bg-purple-700 text-white text-xs font-medium px-3 py-1.5 rounded transition ml-1">
                                CK Editor 3
                            </a>
                        @else
{{--                            <span class="text-gray-400 text-xs bg-gray-100 px-2 py-1 rounded">нет доступа</span>--}}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
