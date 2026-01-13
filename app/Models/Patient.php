<?php

// app/Models/Patient.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['user_id','patient_id','dob','gender','phone','address','medical_history'];

    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

public function appointments()
{
    return $this->hasMany(\App\Models\Appointment::class);
}
}
