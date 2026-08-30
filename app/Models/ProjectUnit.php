<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUnit extends Model
{
    protected $fillable = [
    'project_id',
    'description',
    'parent_id',
    'unit_type_cd',
    'area',
    'rooms',
    'bathrooms',
    'finishing_details',
    ];

    public function children()
    {
        return $this->hasMany(ProjectUnit::class, 'parent_id');
    }

    // ربط الموديل مع الأسهم
    public function shares()
    {
        return $this->hasMany(Shares::class, 'unit_id');
    }
    // دالة لإرجاع عدد الأسهم المتاحة
    public function getAvailableSharesAttribute()
    {
        $totalQuantityUnitShares = $this->shares()->sum('quantity');
        return $this->total_shares - $totalQuantityUnitShares;
    }
}
