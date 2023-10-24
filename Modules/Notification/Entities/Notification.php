<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'content',
        'image',
        'isRead',
        'createdAt',
        'user_id'
    ];
    public function user() {
        $this->belongsTo(User::class, 'user_id', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\Notification\Database\factories\NotificationFactory::new();
    }
}
