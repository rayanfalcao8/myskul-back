<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'sendAt',
        'user_id',
        'speciality_id',
        'level_id',
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\MessageFactory::new();
    }
}
