<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'is_read',
        'replied_at',
        'reply_message'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'replied_at' => 'datetime'
    ];

    protected $dates = [
        'replied_at'
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeBySubject($query, $subject)
    {
        return $query->where('subject', $subject);
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    public function markAsReplied($reply)
    {
        $this->update([
            'is_read' => true,
            'replied_at' => now(),
            'reply_message' => $reply
        ]);
    }

    public function getExcerptAttribute()
    {
        return Str::limit($this->message, 100);
    }

    public static function getSubjects()
    {
        return [
            'general' => 'استفسار عام',
            'appointment' => 'حجز موعد',
            'treatment' => 'استفسار عن العلاج',
            'costs' => 'الاستفسار عن التكاليف',
            'complaint' => 'شكوى',
            'suggestion' => 'اقتراح',
            'technical' => 'مشكلة تقنية'
        ];
    }
}