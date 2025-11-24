<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'name',
        'description',
        'duration',
        'preparation'
    ];

    protected $fillable = [
        'name',
        'description',
        'content',
        'price',
        'duration',
        'preparation',
        'aftercare',
        'features',
        'requirements',
        'is_featured',
        'is_active',
        'order',
        'category',
        'consultation_fee',
        'follow_up_fee'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'consultation_fee' => 'decimal:2',
        'follow_up_fee' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'duration' => 'integer',
        'features' => 'array',
        'requirements' => 'array'
    ];



    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function getImageUrlAttribute()
    {
        // Temporary implementation - can be enhanced with media library later
        return null;
    }
}