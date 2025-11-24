<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Faq extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'question',
        'answer',
        'category'
    ];

    protected $fillable = [
        'question',
        'answer',
        'category',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->answer), 150);
    }

    public static function getCategories()
    {
        return [
            'general' => 'أسئلة عامة',
            'appointments' => 'المواعيد',
            'treatment' => 'العلاج',
            'costs' => 'التكاليف',
            'technology' => 'التكنولوجيا',
            'insurance' => 'التأمين',
            'emergency' => 'الحالات الطارئة'
        ];
    }
}