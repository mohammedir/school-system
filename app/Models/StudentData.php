<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
 use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
class StudentData extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,MustVerifyEmailTrait;

    protected $table = 'students_data';

    protected $fillable = [
        'student_id',
        'first_name',
        'father_name',
        'grandfather_name',
        'last_name',
        'gender',
        'birth_date',
        'health_status',
        'parent_id',
        'parent_name',
        'mobile',
        'alternate_mobile',
        'address',
        'notes'
    ];

    protected $guarded='';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_BlOCKED = 'blocked';
    const STATUS_REJECTED = 'rejected';

    const PROFILE_STATUS_HIDDEN = 'hidden';
    const PROFILE_STATUS_PRIVATE = 'private';
    const PROFILE_STATUS_PUBLIC = 'public';


    public function profileStatusLookup()
    {
        return $this->belongsTo(Lookups::class, 'investor_profile_status_cd', 'id')
            ->where('master_key', 'investor_profile_status');
    }
    public function getProfileStatusKey(): ?string
    {
        return optional($this->profileStatusLookup)->item_key;
    }

    public function isApproved(): bool { return $this->getProfileStatusKey() === self::PROFILE_STATUS_PUBLIC; }
    public function isRejected(): bool { return $this->getProfileStatusKey() === self::PROFILE_STATUS_PUBLIC; }
    public function isPending(): bool { return $this->getProfileStatusKey() === self::PROFILE_STATUS_PUBLIC; }


}
