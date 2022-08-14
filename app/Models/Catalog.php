<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\CatalogIcon;

class Catalog extends Model
{
    use HasFactory;
    /**
     * Таблица БД, ассоциированная с моделью.
     *
     * @var string
     */
    protected $table = 'mod_020_cats';
    /**
     * Следует ли обрабатывать временные метки модели.
     *
     * @var bool
     */
    public $timestamps = false;

    //  protected $appends = ['id', 'head' , 'a_id' , 'a_parentid' ]; // доп значения возвращаемые в JSON


    /**
     * Атрибуты, для которых НЕ разрешено массовое присвоение значений.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * Получить телефон, связанный с пользователем.
     */
    public function icon()
    {
        return $this->hasOne(CatalogIcon::class, 'id_cat', 'a_id')->where('status', 'show');
    }
}
