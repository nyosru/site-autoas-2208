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

    protected $fillable = [
        // 'id',
        'head',
        'a_id',
        'a_categoryid',
        'a_catnumber',
        'catnumber_search',
        'a_price',
        'a_in_stock',
        'a_arrayimage',
        'country',
        'manufacturer',
        'comment',
    ];

    /**
     * Атрибуты, для которых НЕ разрешено массовое присвоение значений.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Получить каталог
     */
    public function catalog()
    {
        return $this->belongsTo(Catalog::class, 'a_id', 'a_categoryid');
    }

    /**
     * Получить аналоги
     */
    public function analog()
    {

        // return $this->hasMany(Comment::class, 'foreign_key', 'local_key');
        // return $this->hasMany(GoodAnalog::class, 'art_origin', 'catnumber_search');

//         return $this->hasMany(GoodAnalog::class, 'catnumber_search', 'a_catnumber');
        return $this->hasMany(GoodAnalog::class, 'art_origin', 'a_catnumber');
//        // return $this->hasMany(GoodAnalog::class,'a_id','a_categoryid');
//        return $this->hasManyThrough(
//
//            Good::class,
//            GoodAnalog::class,
//
//            'art_analog', // Внешний ключ в таблице `environments` goodanalog ...
//             'a_catnumber', // Внешний ключ в таблице `deployments` good ...
////            'a_catnumber_search', // Внешний ключ в таблице `deployments` good ...
//
//            'a_catnumber', // Локальный ключ в таблице `projects` good ...
////            'a_catnumber_search', // Локальный ключ в таблице `projects` good ...
//            'art_origin' // Локальный ключ в таблице `environments` goodanalog ...
//
//        );

    // projects
    //     id - integer
    //     name - string

    // environments
    //     id - integer
    //     project_id - integer
    //     name - string

    // deployments
    //     id - integer
    //     environment_id - integer
    //     commit_hash - string

    }
}
