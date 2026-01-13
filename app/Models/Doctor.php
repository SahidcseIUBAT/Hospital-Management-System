<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DoctorSchedule;
use App\Models\DoctorLeave;

class Doctor extends Model
{
    protected $fillable = [
    'user_id',
    'name',
    'email',
    'specialty',
    'fee',
    'phone',
    'is_active',
   ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function consultations()
{
    return $this->hasMany(\App\Models\Consultation::class);
}
public function schedules()
{
    return $this->hasMany(DoctorSchedule::class);
}


public function leaves()
{
    return $this->hasMany(DoctorLeave::class);
}

}
