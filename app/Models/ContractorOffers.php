<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorOffers extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $guarded='';

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractors::class, 'contractor_id');
    }

    // ***** Status get/set functions  ***** //
    protected static function booted()
    {

        static::creating(function ($model) {
            $model->markAsPending();
        });
    }

    public function statusLookup()
    {
        return $this->belongsTo(Lookups::class, 'status_cd', 'id')
                   ->where('master_key', 'contractor_offer_status');
    }

    public function setStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'contractor_offer_status')
                       ->where('item_key', $statusKey)
                       ->firstOrFail();

        $this->status_cd = $status->id;
        return $this;
    }

    public function getStatusKey(): ?string
    {
        return optional($this->statusLookup)->item_key;
    }

    // Convenience methods
    public function markAsPending() { return $this->setStatus(self::STATUS_PENDING); }
    public function markAsApproved() { return $this->setStatus(self::STATUS_APPROVED); }
    public function markAsRejected() { return $this->setStatus(self::STATUS_REJECTED); }

    // Status check methods
    public function isPending(): bool { return $this->getStatusKey() === self::STATUS_PENDING; }
    public function isApproved(): bool { return $this->getStatusKey() === self::STATUS_APPROVED; }
    public function isRejected(): bool { return $this->getStatusKey() === self::STATUS_REJECTED; }


}
