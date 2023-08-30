<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'country',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\SchoolFactory::new();
    }
}
