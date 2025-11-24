<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Testimonial extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'patient_name',
        'patient_location',
        'content',
        'treatment_details'
    ];

    protected $fillable = [
        'patient_name',
        'patient_location',
        'content',
        'treatment_details',
        'rating',
        'service_name',
        'treatment_date',
        'is_featured',
        'is_approved',
        'order',
        'age_group',
        'gender'
    ];

    protected $casts = [
        'rating' => 'integer',
        'treatment_date' => 'date',
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'order' => 'integer'
    ];



    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                    ->where('is_approved', true)
                    ->orderBy('order');
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function getPatientPhotoUrlAttribute()
    {
        // Temporary implementation - can be enhanced with media library later
        return null;
    }

    public function getFormattedDateAttribute()
    {
        return $this->treatment_date->format('M Y');
    }

    public function getStarsAttribute()
    {
        return str_repeat('⭐', $this->rating);
    }

    public function getExcerptAttribute()
    {
        return Str::limit($this->content, 150);
    }
}