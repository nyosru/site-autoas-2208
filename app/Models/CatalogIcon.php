<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Catalog;

class CatalogIcon extends Model
{
    use HasFactory;
    /**
     * Таблица БД, ассоциированная с моделью.
     *
     * @var string
     */
    protected $table = 'mod_020_cats_icon';
    /**
     * Следует ли обрабатывать временные метки модели.
     *
     * @var bool
     */
    public $timestamps = false;

    public function catalog()
    {
        return $this->belongsTo(Catalog::class,'a_id','id_cat');
    }
}
