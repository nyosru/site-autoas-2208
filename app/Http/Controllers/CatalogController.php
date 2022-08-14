<?php

namespace App\Http\Controllers;

use App\Http\Resources\CatalogCollection;

use App\Models\Catalog;

class CatalogController extends Controller
{
    /**
     * список всех каталогов
     */
    public function index()
    {
        return new CatalogCollection(Catalog::
            // remember(60)->
            with('icon')->where('status', 'show')->orderBy('sort')->get());;
            sss
    }

    /**
     * показ одного каталога
     */
    public function show(string $id)
    {
        return new CatalogCollection(Catalog::where('id', $id)->where('status', 'show')->get());
    }
}
