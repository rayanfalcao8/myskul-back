<?php

namespace Modules\Quiz\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropositionQuestion extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Quiz\Database\factories\PropositionQuestionFactory::new();
    }
}
