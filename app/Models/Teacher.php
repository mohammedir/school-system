<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'teacher_name',
        'email',
        'password',
        'phone_number',
        'national_id',
        'birth_date',
        'gender',
        'address',
        'province_id',
        'city_id',
        'district_id',
        'age_group_id',
        'specializations',
        'experience_years',
        'qualifications',
        'certificates',
        'previous_experience',
        'profile_image',
        'cv_file',
        'certificates_file',
        'id_photo',
        'status',
        'availability',
        'notes',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
    ];


    // الـ Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
