<?php

namespace Modules\Quiz\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Quiz\Database\factories\PropositionFactory::new();
    }
}
