<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    protected $primaryKey = 'appointment_id';

    protected $fillable = ['user_id', 'service_id', 'qr_code', 'appoint_date', 'appoint_time', 'dentist_id', 'appoint_status', 'is_notify'];

}
