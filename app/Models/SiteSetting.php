<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $table = 'site_settings';

    protected $fillable = [
        'site_logo',
        'site_name',
        'hero_title',
        'hero_subtitle',
        'school_vision',
        'school_mission',
        'principal_name',
        'principal_image',
        'principal_speech',
        'section_kindergarten',
        'section_primary',
        'section_secondary',
        'section_center',
        'contact_phone',
        'contact_whatsapp',
        'contact_email',
        'contact_address',
        'social_facebook',
        'social_instagram',
    ];
}
