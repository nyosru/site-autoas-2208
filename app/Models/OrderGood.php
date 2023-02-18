<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderGood extends Model
{
    use HasFactory;
    protected $fillable = [
        'good_id',
        'order_id',
        'goodOrigin',
        'price',
        'kolvo'
    ];
    // protected $fillable = ['good_id'];

    /**
     * Получить запись, указанного заказа
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
