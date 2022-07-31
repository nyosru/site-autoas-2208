<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Catalog;
use App\Models\GoodAnalog;

class Good extends Model
{
    use HasFactory;
    /**
     * Таблица БД, ассоциированная с моделью.
     *
     * @var string
     */
    protected $table = 'mod_021_items';
    /**
     * Следует ли обрабатывать временные метки модели.
     *
     * @var bool
     */
     public $timestamps = false;

    //  protected $appends = ['id', 'head' , 'a_id' , 'a_parentid' ]; // доп значения возвращаемые в JSON

     /**
     * Получить каталог
     */
    public function catalog()
    {
        return $this->belongsTo(Catalog::class,'a_id','a_categoryid');
    }

     /**
     * Получить аналоги
     */
    public function analog()
    {
        // return $this->hasMany(GoodAnalog::class,'a_id','a_categoryid');
        return $this->hasManyThrough(
            Good::class,
            GoodAnalog::class,
            'art_analog', // Внешний ключ в таблице `environments` goodanalog ...
            'a_catnumber', // Внешний ключ в таблице `deployments` good ...
            'a_catnumber', // Локальный ключ в таблице `projects` good ...
            'art_origin' // Локальный ключ в таблице `environments` goodanalog ...
        );
    }

}
