<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

class Contractors extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,MustVerifyEmailTrait;
    protected $table = 'contractors';

    protected $guarded='';

    protected $hidden = [
        'password',
        'remember_token',
    ];
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';


    protected $fillable = [
        'company_name',
        'mobile',
        'province_cd',
        'city_cd',
        'district_cd',
        'address',
        'experience_years',
        'commercial_registration_number',
        'specializations',
        'email',
        'logo',
        'status_cd',
        'password',
    ];


}
