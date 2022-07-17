<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syslog extends Model
{
    use HasFactory;

    protected $table = 'syslogs';
    protected $primaryKey = 'id';

    protected $fillable = ['syslog', 'username', 'action_type'];


}
