<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Good;

class GoodAnalog extends Model
{
    use HasFactory;
    /**
     * Таблица БД, ассоциированная с моделью.
     *
     * @var string
     */
    protected $table = 'mod_021_items_analogs';
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
     * Получить товар
     */
    public function good()
    {
//        return $this->belongsTo(Good::class, 'a_id', 'art_origin');
        return $this->belongsTo(Good::class, 'a_catnumber', 'art_origin');
    }

    public function angood()
    {
//        return $this->belongsTo(Good::class, 'a_id', 'art_origin');
        return $this->belongsTo(Good::class, 'art_analog', 'a_catnumber');
    }

    public function analog2()
    {
        return $this->belongsTo(Good::class, 'catnumber_search', 'art_analog');
    }

    public function analogi2()
    {
        return $this->belongsTo(Good::class, 'a_id', 'art_analog');
    }
}
