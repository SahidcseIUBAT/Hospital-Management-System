<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = ['consultation_id','doctor_id','patient_id','advice','follow_up_at'];

    protected $casts = ['follow_up_at' => 'datetime'];

    public function consultation() { return $this->belongsTo(Consultation::class); }
    public function items() { return $this->hasMany(PrescriptionItem::class); }
}
