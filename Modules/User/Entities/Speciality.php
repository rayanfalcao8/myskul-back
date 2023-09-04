<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Speciality extends Model
{
    use HasFactory;

    protected $fillable = [
        'sigle',
        'speciality',
        'type'
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\SpecialityFactory::new();
    }
}
