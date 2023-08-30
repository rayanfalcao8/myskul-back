<?php

namespace Modules\Quiz\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'done',
        'score',
        'theme_id',
        'user_id',
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\UserThemeFactory::new();
    }
}
