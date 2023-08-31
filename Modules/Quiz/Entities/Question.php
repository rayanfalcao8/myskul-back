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

    public function theme() {
        return $this->belongsTo(Theme::class);
    }

    public function answers() {
        return $this->belongsToMany(Proposition::class, 'proposition_questions', 'question_id', 'proposition_id')
            ->withPivot('isCorrect');
    }
}
