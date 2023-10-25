<?php

namespace Modules\User\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Modules\Notification\Entities\Notification;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\UserProduct;
use Modules\Quiz\Entities\Question;
use Modules\Quiz\Entities\Theme;
use Modules\Quiz\Entities\UserTheme;
use Modules\Subscription\Entities\UserAbonnement;
use Modules\User\Traits\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,
        HasFactory,
        HasRoles,
        HasProfilePhoto,
        Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $fillable = [
        'name',
        'gender',
        'email',
        'password',
        'birthdate',
        'phoneNumber',
        'timezone',
        'language',
        'last_login_ip',
        'last_login_at',
        'status',
        'town',
        'avatarURL',
        'level_id',
        'speciality_id',
        'school_id',
        'phone_number_verified_at',
        'fcm_token',
        'new_password'
    ];

    public static function boot()
    {
        parent::boot();
        // Will fire everytime an User is created
        static::created(function (User $user) {
            $user->forceFill(['username' => Str::slug($user->name)])->save();
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_number_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function level() {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function speciality() {
        return $this->belongsTo(Speciality::class);
    }

    public function school() {
        return $this->belongsTo(School::class);
    }

    public function domains() {
        return $this->belongsToMany(Domain::class, 'user_abonnements', 'user_id', 'domain_id');
    }

    public function quizzes() {
        return $this->hasMany(UserTheme::class);
    }

    public function themes() {
        return $this->belongsToMany(Theme::class, 'user_themes', 'user_id', 'theme_id');
    }

    public function subscriptions() {
        return $this->hasMany(UserAbonnement::class);
    }

    public function notifications() {
        return $this->hasMany(Notification::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'user_products', 'user_id', 'product_id');
    }

    public function answers() {
        return $this->belongsToMany(Question::class, 'user_answers', 'user_id', 'question_id')
            ->withPivot(['ok', 'created_at', 'updated_at']);
    }

    public function score($theme_id = null, $period = null): int {
        $score = 0;
        if($period !== null) {
            switch ($period) {
                case 'day': {
                    $this->answers->each(function ($answer) use (&$score) {
                        if($answer->pivot->updated_at != null && date_format($answer->pivot->updated_at, 'Y-m-d') == today()->format('Y-m-d') && $answer->pivot->ok == 1){
                            $score += $answer->points;
                        }
                    });
                    return $score;
                }
                case 'month': {
                    $this->answers->each(function ($answer) use (&$score) {
                        if($answer->pivot->updated_at != null && date_format($answer->pivot->updated_at, 'Y-m') == today()->format('Y-m') && $answer->pivot->ok == 1){
                            $score += $answer->points;
                        }
                    });
                    return $score;
                }
                default : {
                    $this->answers->each(function ($answer) use (&$score) {
                        if($answer->pivot->ok == 1){
                            $score += $answer->points;
                        }
                    });
                    return $score;
                }
            }
        }
        if($theme_id !== null) {
            if(!$this->answers->contains('theme_id', $theme_id)){
                return $score;
            }
            $this->answers->where('theme_id', $theme_id)->each(function ($answer) use (&$score) {
                if($answer->pivot->ok == 1){
                    $score += $answer->points;
                }
            });
            return $score;
        }
        $this->answers->each(function ($answer) use (&$score) {
            if($answer->pivot->ok == 1){
                $score += $answer->points;
            }
        });
        return $score;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->acceptsFile(function (string $mimeType): bool {
                return in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg'], true);
            });
    }

    public function userRoles(): array
    {
        $roles = array();
        foreach ($this->roles as $role) {
            $roles[] = $role->name;
        }
        return $roles;
    }

    public function userPermissions(): array
    {
        $permissions = array();
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission->name;
            }
        }
        return $permissions;
    }
}
