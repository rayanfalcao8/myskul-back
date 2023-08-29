<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'level'
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\LevelFactory::new();
    }
}
