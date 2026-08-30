<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investors extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'investors';

    protected $guarded= [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const STATUS_NEW = 'new';
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_REJECTED = 'rejected';
    const STATUS_UPDATED = 'updated';
    const STATUS_BlOCKED = 'blocked';

    const PROFILE_STATUS_HIDDEN = 'hidden';
    const PROFILE_STATUS_PRIVATE = 'private';
    const PROFILE_STATUS_PUBLIC = 'public';


    protected static function booted()
    {

        static::creating(function ($model) {
            $model->markAsNew();
        });
    }

    public function province()
    {
        return $this->belongsTo(Lookups::class, 'province_cd', 'id');
    }
    public function city()
    {
        return $this->belongsTo(Lookups::class, 'city_cd', 'id');
    }
    public function district()
    {
        return $this->belongsTo(Lookups::class, 'district_cd', 'id');
    }

    public function statusLookup()
    {
        return $this->belongsTo(Lookups::class, 'status_cd', 'id')
                   ->where('master_key', 'investor_status');
    }

    public function profileStatusLookup()
    {
        return $this->belongsTo(Lookups::class, 'investor_profile_status_cd', 'id')
                   ->where('master_key', 'investor_profile_status');
    }

    public function setStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'investor_status')
                       ->where('item_key', $statusKey)
                       ->firstOrFail();

        $this->status_cd = $status->id;
        return $this;
    }

     public function setProfileStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'investor_profile_status')
                       ->where('item_key', $statusKey)
                       ->firstOrFail();

        $this->investor_profile_status_cd = $status->id;
        return $this;
    }

    public function getStatusKey(): ?string
    {
        return optional($this->statusLookup)->item_key;
    }

    public function getProfileStatusKey(): ?string
    {
        return optional($this->profileStatusLookup)->item_key;
    }

    // Convenience methods
    public function markAsNew() { return $this->setStatus(self::STATUS_NEW); }
    public function markAsPending() { return $this->setStatus(self::STATUS_PENDING); }
    public function markAsActive() { return $this->setStatus(self::STATUS_ACTIVE); }
    public function markAsRejected() { return $this->setStatus(self::STATUS_REJECTED); }
    public function markAsUpdated() { return $this->setStatus(self::STATUS_UPDATED); }
    public function markAsBlocked() { return $this->setStatus(self::STATUS_BlOCKED); }

    public function markAsHidden() { return $this->setProfileStatus(self::PROFILE_STATUS_HIDDEN); }
    public function markAsPrivate() { return $this->setProfileStatus(self::PROFILE_STATUS_PRIVATE); }
    public function markAsPublic() { return $this->setProfileStatus(self::PROFILE_STATUS_PUBLIC); }

    // Status check methods
    public function isNew(): bool { return $this->getStatusKey() === self::STATUS_NEW; }
    public function isPending(): bool { return $this->getStatusKey() === self::STATUS_PENDING; }
    public function isActive(): bool { return $this->getStatusKey() === self::STATUS_ACTIVE; }
    public function isRejected(): bool { return $this->getStatusKey() === self::STATUS_REJECTED; }
    public function isUpdated(): bool { return $this->getStatusKey() === self::STATUS_UPDATED; }
    public function isBlocked(): bool { return $this->getStatusKey() === self::STATUS_BlOCKED; }


    public function isHidden(): bool { return $this->getProfileStatusKey() === self::PROFILE_STATUS_HIDDEN; }
    public function isPrivate(): bool { return $this->getProfileStatusKey() === self::PROFILE_STATUS_PRIVATE; }
    public function isPublic(): bool { return $this->getProfileStatusKey() === self::PROFILE_STATUS_PUBLIC; }
    public function isApproved(): bool { return $this->getStatusKey() === self::STATUS_ACTIVE; }


    public function transactionsLog()
    {
        return $this->hasMany(Transactions::class, 'user_id', 'id')->where('user_type', 'investor');

    }

    public function getTotalDepositsAttribute()
    {
        return $this->transactionsLog()
            ->whereHas('statusLookup', function ($query) {
                $query->where('extra_3', 1);
            })
            ->sum('amount');
    }
    public function getTotalExpensesAttribute()
    {
        return $this->transactionsLog()
            ->whereHas('statusLookup', function ($query) {
                $query->where('extra_3', 2);
            })
            ->sum('amount');
    }
}
