<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class LegalPartner extends User
{
    protected $table = 'users'; // 👈 اجبره يستخدم جدول users
    protected $guarded='';
    protected static function booted()
    {
        static::addGlobalScope('legal', function ($query) {
            $query->where('user_type', 'legal');
        });

        static::creating(function ($model) {
            $model->user_type = 'legal';
        });
    }
}
