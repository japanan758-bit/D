<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'amount',
        'paid_amount',
        'status',
        'notes',
        'items'
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'items' => 'array',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
