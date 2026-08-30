<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositRequests extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'deposit_requests';

    protected $guarded= [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';


    protected static function booted()
    {

        static::creating(function ($model) {
            $model->markAsPending();
        });
    }
    public function setStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'deposit_request_status_cd')
            ->where('item_key', $statusKey)
            ->firstOrFail();

        $this->deposit_request_status_cd = $status->id;
        return $this;
    }
    public function statusLookup()
    {
        return $this->belongsTo(Lookups::class, 'payment_method_cd', 'id')
            ->where('master_key', 'payment_method_cd');
    }
    public function depositRequestStatusLookup()
    {
        return $this->belongsTo(Lookups::class, 'deposit_request_status_cd', 'id')
            ->where('master_key', 'deposit_request_status_cd');
    }
    public function markAsPending() { return $this->setStatus(self::STATUS_PENDING); }
    public function markAsApproved() { return $this->setStatus(self::STATUS_APPROVED); }
    public function markAsRejected() { return $this->setStatus(self::STATUS_REJECTED); }


}
