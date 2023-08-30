<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServicePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sigle',
        'service',
        'description',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Payment\Database\factories\ServicePaymentFactory::new();
    }
}
