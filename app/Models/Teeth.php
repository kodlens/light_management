<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teeth extends Model
{
    use HasFactory;

    protected $table = 'teeth';
    protected $primaryKey = 'tooth_id';


    protected $fillable = ['tooth_name'];



}
