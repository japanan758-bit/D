<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'settings';

    public $translatable = [
        'clinic_name',
        'description',
        'address',
        'working_hours',
        'about_us',
        'mission',
        'vision',
        'values',
        'meta_title',
        'meta_description',
        'keywords'
    ];

    protected $fillable = [
        'key',
        'clinic_name',
        'description',
        'address',
        'phone',
        'whatsapp_number',
        'email',
        'working_hours',
        'about_us',
        'mission',
        'vision',
        'values',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'google_maps_url',
        'consultation_fee',
        'emergency_contact',
        'meta_title',
        'meta_description',
        'keywords',
        'enable_booking',
        'enable_payment',
        'enable_registration',
    ];

    protected $casts = [
        'consultation_fee' => 'decimal:2',
        'enable_booking' => 'boolean',
        'enable_payment' => 'boolean',
        'enable_registration' => 'boolean',
    ];



    // Singleton pattern - only one settings record should exist
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($setting) {
            // Ensure only one settings record exists
            static::where('id', '!=', $setting->id)->delete();
        });
    }

    /**
     * Helper to get the singleton settings instance.
     */
    public static function getSettings()
    {
        return static::firstOrCreate([], ['clinic_name' => 'Default Clinic']);
    }

    public function getLogoUrlAttribute()
    {
        return $this->getFirstMediaUrl('logo');
    }

    public function getHeroImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('hero_image');
    }

    public function getWorkingHoursArrayAttribute()
    {
        return json_decode($this->working_hours, true) ?? [];
    }
}