<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    use Notifiable;

        protected $table = 'transactions';

    protected $guarded= [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const STATUS_DEPOSIT = 'deposit';
    const STATUS_WITHDRAWAL = 'withdrawal';
    const STATUS_PURCHASE = 'purchase';
    const STATUS_CREATE_PROJECT = 'create_project';
    const STATUS_RETURN_PROJECT = 'return_project';
    const STATUS_REFUND = 'refund';


    public function statusLookup()
    {
        return $this->belongsTo(Lookups::class, 'transaction_type_cd', 'id')
            ->where('master_key', 'transaction_type_cd');
    }

    public function setStatus(string $statusKey)
    {
        $status = Lookups::where('master_key', 'transaction_type_cd')
            ->where('item_key', $statusKey)
            ->firstOrFail();

        $this->transaction_type_cd = $status->id;
        return $this;
    }
    public function getStatus(): ?string
    {
        return optional($this->statusLookup)->item_key;
    }

    public function markAsDeposit() { return $this->setStatus(self::STATUS_DEPOSIT); }
    public function markAsWithdrawal() { return $this->setStatus(self::STATUS_WITHDRAWAL); }
    public function markAsPurchase() { return $this->setStatus(self::STATUS_PURCHASE); }
    public function markAsCreate_Project() { return $this->setStatus(self::STATUS_CREATE_PROJECT); }
    public function markAsReturn_Project() { return $this->setStatus(self::STATUS_RETURN_PROJECT); }
    public function markAsRefund() { return $this->setStatus(self::STATUS_REFUND); }


    public function IsDeposit(): bool { return $this->getStatus() === self::STATUS_DEPOSIT; }



}
