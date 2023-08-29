<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'free',
        'category_id',
        'level_id',
        'speciality_id',
    ];

    protected $casts = [
        'free' => 'boolean',
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\ThemeFactory::new();
    }
}
