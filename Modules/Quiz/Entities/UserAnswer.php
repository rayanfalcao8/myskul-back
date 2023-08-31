<?php

namespace Modules\Quiz\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'ok',
        'user_id',
        'question_id',
    ];

    protected $casts = [
        'ok' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }

    protected static function newFactory()
    {
        return \Modules\Quiz\Database\factories\UserAnswerFactory::new();
    }
}
