<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function pages()
    {
        $pages = Page::all();
        return view('admin.pages', compact('pages'));
    }

    public function pageEdit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.page-edit', compact('page'));
    }

    public function pageUpdate(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $page->name = $request->input('name', $page->name);
        $page->opis = $request->input('opis', $page->opis);
        $page->html = $request->input('html', $page->html);
        $page->save();

        return redirect('/admin/pages')
            ->with('success', 'Страница «' . $page->name . '» сохранена!');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $file = $request->file('upload');
        $name = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $name, 'public');

        return response()->json([
            'uploaded' => 1,
            'fileName' => $name,
            'url' => '/storage/' . $path,
        ]);
    }
}
