<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbonnementType extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'timeUnit',
        'duration'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Subscription\Database\factories\AbonnementTypeFactory::new();
    }
}
