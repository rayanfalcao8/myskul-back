<?php

namespace Modules\Quiz\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Category;
use Modules\User\Entities\Level;
use Modules\User\Entities\Speciality;
use Modules\User\Entities\User;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'free',
        'category_id',
        'level_id',
        'speciality_id',
    ];

    protected $casts = [
        'free' => 'boolean',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function level() {
        return $this->belongsTo(Level::class);
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function speciality() {
        return $this->belongsTo(Speciality::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_themes', 'theme_id', 'user_id');
    }

    public function quiz() {
        return $this->hasMany(UserTheme::class);
    }

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\ThemeFactory::new();
    }
}
