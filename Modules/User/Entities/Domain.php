<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name'
    ];

    protected $table = 'domaines';

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\DomainFactory::new();
    }
}
