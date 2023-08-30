<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAbonnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'abonnementType_id',
        'transactionID',
        'buyerPhoneNumber',
        'level_id',
        'speciality_id',
        'createdAt',
        'expiresAt'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Subscription\Database\factories\UserAbonnementFactory::new();
    }
}
