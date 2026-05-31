@extends('admin.layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4">CKEditor 3: {{ $page->name }}</h2>

    <form method="POST" action="/admin/pages/{{ $page->id }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Название</label>
            <input name="name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" value="{{ old('name', $page->name) }}" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
            <input name="opis" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" value="{{ old('opis', $page->opis) }}" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Содержимое</label>
            <textarea name="html" id="editor" rows="20" class="w-full border border-gray-300 rounded px-3 py-2 text-sm font-mono">{{ $page->html }}</textarea>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2 rounded transition">Сохранить</button>
            <a href="/admin/pages" class="text-gray-600 hover:text-gray-800 text-sm px-3 py-2 rounded transition">Назад к списку</a>
        </div>
    </form>
@endsection

@push('scripts')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        CKEDITOR.replace('editor', {
            height: 500,
            filebrowserUploadUrl: '/admin/upload-image',
            filebrowserUploadMethod: 'form'
        });
    });
</script>
@endpush
