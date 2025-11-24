<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FAQ extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_ar',
        'question_en',
        'answer_ar', 
        'answer_en',
        'is_active',
        'order',
        'category',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the question in Arabic
     */
    public function getQuestionAttribute()
    {
        return $this->question_ar;
    }

    /**
     * Get the answer in Arabic
     */
    public function getAnswerAttribute()
    {
        return $this->answer_ar;
    }

    /**
     * Get the question in the current locale
     */
    public function getQuestionLocaleAttribute()
    {
        $locale = app()->getLocale();
        $field = "question_" . $locale;
        
        return $this->$field ?? $this->question_ar;
    }

    /**
     * Get the answer in the current locale
     */
    public function getAnswerLocaleAttribute()
    {
        $locale = app()->getLocale();
        $field = "answer_" . $locale;
        
        return $this->$field ?? $this->answer_ar;
    }

    /**
     * Scope a query to only include active FAQs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by position.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get the FAQ category name in Arabic
     */
    public function getCategoryNameAttribute()
    {
        $categories = [
            'general' => 'عام',
            'appointments' => 'المواعيد',
            'services' => 'الخدمات',
            'pricing' => 'الأسعار',
            'insurance' => 'التأمين',
            'location' => 'الموقع',
        ];

        return $categories[$this->category] ?? $this->category;
    }

    /**
     * Boot method to set default values
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($faq) {
            if (is_null($faq->order)) {
                $maxOrder = static::max('order');
                $faq->order = $maxOrder ? $maxOrder + 1 : 1;
            }
        });
    }
}
