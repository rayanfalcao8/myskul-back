<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transactionID',
        'transactionType',
        'phoneNumber',
        'montant',
        'service_sigle',
        'user_id',
        'createdAt',
        'status',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Payment\Database\factories\PaymentFactory::new();
    }
}
