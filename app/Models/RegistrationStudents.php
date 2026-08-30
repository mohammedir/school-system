<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationStudents extends Model
{
    use HasFactory;
    protected $table = 'registrations_students';

    protected $fillable = [
        'student_id_number',
        'student_full_name',
        'birth_date',
        'address',
        'age_group_id',
        'class_id',
        'guardian_name',
        'guardian_id_number',
        'phone_number',
        'transfer_notice',
        'additional_notes',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // العلاقات
    public function ageGroup()
    {
        return $this->belongsTo(Lookups::class, 'age_group_id');
    }

    public function class()
    {
        return $this->belongsTo(Lookups::class, 'class_id');
    }

    // دوال مساعدة
    public function getStatusNameAttribute()
    {
        $statuses = [
            'pending' => 'قيد الانتظار',
            'approved' => 'مقبول',
            'rejected' => 'مرفوض',
            'completed' => 'مكتمل',
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'completed' => 'info',
        ];
        return $colors[$this->status] ?? 'secondary';
    }
}
