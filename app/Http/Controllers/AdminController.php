<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function pageEditCkeditor($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.page-edit-ckeditor', compact('page'));
    }

    public function pageUpdate(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $page->name = $request->input('name', $page->name);
        $page->opis = $request->input('opis', $page->opis);
        $page->html = $request->input('html', $page->html);
        $page->save();

        // save blade view file
        $dir = resource_path('views/pages');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = Str::slug($page->module) . '.blade.php';
        $content = $page->html;
        file_put_contents($dir . '/' . $filename, $content);

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
        $url = '/storage/' . $path;

        if ($request->has('CKEditorFuncNum')) {
            $funcNum = $request->input('CKEditorFuncNum');
            return '<script>window.parent.CKEDITOR.tools.callFunction(' . $funcNum . ', "' . $url . '");</script>';
        }

        return response()->json([
            'uploaded' => 1,
            'fileName' => $name,
            'url' => $url,
        ]);
    }
}
