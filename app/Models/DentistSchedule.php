<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentistSchedule extends Model
{
    use HasFactory;


    protected $table = 'dentist_schedules';
    protected $primaryKey = 'dentist_schedule_id';


    protected $fillable = ['user_id', 'from', 'to',
        'mon', 'tue', 'wed', 'thur', 'fri', 'sat', 'sun'
    ];


    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

}
