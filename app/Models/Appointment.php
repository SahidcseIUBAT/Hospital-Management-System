<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'patient_id',
        'doctor_id',
        'scheduled_at',
        'status',
        'reason',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];
    

    // relationships
    public function patient()
{
    return $this->belongsTo(\App\Models\Patient::class);
}

public function doctor()
{
    return $this->belongsTo(Doctor::class);
}
public function consultation()
{
    return $this->hasOne(\App\Models\Consultation::class);
}
public function payment()
{
    return $this->hasOne(Payment::class);
}

}
