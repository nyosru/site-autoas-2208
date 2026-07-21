<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VkSentMessage extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';

    protected $table = 'vk_sent_messages';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'vk_id',
        'message',
        'status',
        'channel',
        'provider_message_id',
        'response',
        'error',
        'sent_at',
        'failed_at',
    ];

    protected function casts(): array
    {
        return [
            'vk_id' => 'integer',
            'response' => 'array',
            'error' => 'array',
            'sent_at' => 'datetime',
            'failed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->id)) {
                $model->id = (string) Str::ulid();
            }
        });
    }
}
