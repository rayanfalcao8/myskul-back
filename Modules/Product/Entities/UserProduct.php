<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'contactedPhoneNumber',
        'createdAt',
    ];


    
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\UserProductFactory::new();
    }
}
