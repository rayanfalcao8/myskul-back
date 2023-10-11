<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\Domain;
use Modules\User\Entities\Level;
use Modules\User\Entities\Speciality;

class UserAbonnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'abonnementType_id',
        'transactionID',
        'buyerPhoneNumber',
        'level_id',
        'domain_id',
        'speciality_id',
        'createdAt',
        'expireAt'
    ];

    public function level() {
        return $this->belongsTo(Level::class);
    }

    public function speciality() {
        return $this->belongsTo(Speciality::class);
    }

    public function domain() {
        return $this->belongsTo(Domain::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\Subscription\Database\factories\UserAbonnementFactory::new();
    }
}
