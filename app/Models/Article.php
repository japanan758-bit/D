<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'title',
        'content',
        'excerpt',
        'meta_description'
    ];

    protected $fillable = [
        'title',
        'content',
        'excerpt',
        'meta_description',
        'featured_image',
        'is_published',
        'is_featured',
        'author',
        'published_at',
        'reading_time',
        'category',
        'tags',
        'slug'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'reading_time' => 'integer',
        'tags' => 'array'
    ];



    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                    ->where('is_published', true);
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

    public function getExcerptTextAttribute()
    {
        return strip_tags($this->excerpt);
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200);
        return $minutes;
    }
}