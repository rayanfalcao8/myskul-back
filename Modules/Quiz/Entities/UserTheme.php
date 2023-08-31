<?php

namespace Modules\Quiz\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class UserTheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'done',
        'score',
        'theme_id',
        'user_id',
    ];

    protected $casts = [
        'done' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function theme() {
        return $this->belongsTo(Theme::class);
    }

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\UserThemeFactory::new();
    }
}
