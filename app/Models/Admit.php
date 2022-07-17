<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admit extends Model
{
    use HasFactory;


    protected $table = 'admits';
    protected $primaryKey = 'admit_id';


    protected $fillable = ['appointment_id', 'patient_id', 'service_id', 'qr_code', 'dentist_id'];

}
