<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status'
    ];


    /**
     * Получить каталог
     */
    public function user()
    {
        // return $this->belongsTo(User::class, 'id', 'a_categoryid');
        return $this->belongsTo(User::class);
    }

    /**
     * Получить товары к заказу
     */
    public function goods()
    {
        return $this->hasMany(OrderGood::class, 'good_id');
    }
}
