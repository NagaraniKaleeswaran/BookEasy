<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'reminder_date',
        'reminder_type',
        'status',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
