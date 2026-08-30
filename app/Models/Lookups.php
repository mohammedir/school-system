<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lookups extends Model
{
    use HasFactory, SoftDeletes;
        protected $table = "lookups";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(Lookups::class, "parent_id", "id")->where("status",1);
    }

    public function getStatusTextAttribute()
    {
        return $this->status == 1 ? __('admin.Active') : __('admin.Inactive');
    }
    public function getStatusBadgeClassAttribute()
    {
        return $this->status == 1 ? 'success' : 'danger';
    }
    public function parent()
    {
        return $this->belongsTo(Lookups::class, 'parent_id');
    }
    public static function getStatusId(string $statusKey): ?int
    {
        return self::where('master_key', 'project_status_cd')
            ->where('item_key', $statusKey)
            ->value('id');
    }
    public static function getEngineeringOfferStatusId(string $statusKey): ?int
    {
        return self::where('master_key', 'engineering_offer_status')
            ->where('item_key', $statusKey)
            ->value('id');
    }

    public static function getContractorOfferStatusId(string $statusKey): ?int
    {
        return self::where('master_key', 'contractor_offer_status')
            ->where('item_key', $statusKey)
            ->value('id');
    }
}
