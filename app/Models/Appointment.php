<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'patient_phone',
        'patient_email',
        'service_id',
        'appointment_date',
        'appointment_time',
        'notes',
        'status',
        'is_confirmed',
        'whatsapp_sent',
        'confirmation_code'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'is_confirmed' => 'boolean',
        'whatsapp_sent' => 'boolean'
    ];

    protected $hidden = [
        'confirmation_code'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
                    ->where('status', '!=', self::STATUS_CANCELLED);
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('appointment_date', $date);
    }

    public function getFormattedDateAttribute()
    {
        return $this->appointment_date->format('d/m/Y');
    }

    public function getFormattedTimeAttribute()
    {
        return $this->appointment_time->format('h:i A');
    }

    public function getWhatsAppMessageAttribute()
    {
        $message = "مرحباً، أود تأكيد حجز موعد للعيادة:\n\n";
        $message .= "اسم المريض: " . $this->patient_name . "\n";
        $message .= "رقم الهاتف: " . $this->patient_phone . "\n";
        $message .= "الخدمة: " . $this->service->name_ar . "\n";
        $message .= "التاريخ: " . $this->formatted_date . "\n";
        $message .= "الوقت: " . $this->formatted_time . "\n";
        $message .= "رقم التأكيد: " . $this->confirmation_code . "\n\n";
        $message .= "شكراً لاختياركم عيادة د. عبدالناصر الأخرس";

        return urlencode($message);
    }

    public function getWhatsAppUrlAttribute()
    {
        return "https://wa.me/201055558199?text={$this->whatsapp_message}";
    }
}