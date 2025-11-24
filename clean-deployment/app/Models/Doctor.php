<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'name',
        'specialty',
        'bio',
        'qualifications',
        'experience',
        'certificates'
    ];

    protected $fillable = [
        'name',
        'specialty',
        'bio',
        'qualifications',
        'experience',
        'certificates',
        'years_of_experience',
        'consultation_fee',
        'is_active',
        'email',
        'phone'
    ];

    protected $casts = [
        'years_of_experience' => 'integer',
        'consultation_fee' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function getPhotoUrlAttribute()
    {
        // Temporary implementation - can be enhanced with media library later
        return null;
    }

    public function getCertificatesAttribute()
    {
        // Temporary implementation - can be enhanced with media library later
        return collect();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}