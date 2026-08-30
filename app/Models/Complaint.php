<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'complainant_name',
        'phone_number',
        'type',
        'details',
        'status',
        'admin_reply',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => 'string',
        'status' => 'string',
    ];

    // دالة مساعدة للحصول على نوع الشكوى بالعربي
    public function getTypeNameAttribute(): string
    {
        return match ($this->type) {
            'complaint' => 'شكوى',
            'suggestion' => 'اقتراح',
            'inquiry' => 'استفسار',
            default => $this->type,
        };
    }

    // دالة مساعدة للحصول على حالة الشكوى بالعربي
    public function getStatusNameAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'قيد الانتظار',
            'in_progress' => 'قيد المعالجة',
            'resolved' => 'تم الحل',
            'rejected' => 'مرفوض',
            default => $this->status,
        };
    }
}
