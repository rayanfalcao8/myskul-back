<?php

namespace Modules\Quiz\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'justification',
        'points',
        'next_id',
        'theme_id',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Quiz\Database\factories\QuestionFactory::new();
    }
}
