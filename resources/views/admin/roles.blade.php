@extends('admin.layouts.app')

@section('title', 'Управление ролями')
@section('container-class', 'max-w-4xl')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Управление ролями</h2>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b text-left">
                    <th class="px-4 py-3 font-semibold text-gray-600">ID</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Имя</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Email</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Роль</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Изменить</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $u)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $u->id }}</td>
                    <td class="px-4 py-3 font-medium">{{ $u->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $u->email }}</td>
                    <td class="px-4 py-3">
                        @if ($u->role === 'owner')
                            <span class="inline-block bg-red-100 text-red-700 text-xs font-semibold px-2 py-0.5 rounded">хозяин</span>
                        @else
                            <span class="inline-block bg-gray-200 text-gray-600 text-xs font-semibold px-2 py-0.5 rounded">турист</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if (Auth::user()->id !== $u->id)
                            <form method="POST" action="/admin/roles/{{ $u->id }}" class="flex gap-2 items-center">
                                @csrf
                                @method('PUT')
                                <select name="role" class="text-sm border rounded px-2 py-1">
                                    <option value="owner" {{ $u->role === 'owner' ? 'selected' : '' }}>хозяин</option>
                                    <option value="tourist" {{ $u->role === 'tourist' ? 'selected' : '' }}>турист</option>
                                </select>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded transition">Сохранить</button>
                            </form>
                        @else
                            <span class="text-gray-400 text-sm">это вы</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
