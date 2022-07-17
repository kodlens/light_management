<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dentist extends Model
{
    use HasFactory;

    protected $table = 'dentists';
    protected $primaryKey = 'dentist_id';


    protected $fillable = ['lname', 'fname', 'mname', 'suffix', 'sex', 'contact_no', 'email', 'address'];

}
