<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Appraiser extends User
{
    protected $table = 'users'; // 👈 اجبره يستخدم جدول users
    protected $guarded='';
    protected static function booted()
    {
        static::addGlobalScope('appraiser', function ($query) {
            $query->where('user_type', 'appraiser');
        });

        static::creating(function ($model) {
            $model->user_type = 'appraiser';
        });
    }
}
