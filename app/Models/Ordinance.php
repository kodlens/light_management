<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordinance extends Model
{
    use HasFactory;

    protected $table = 'ordinances';
    protected $primaryKey = 'ordinance_id';

    protected $fillable = ['ordinance_name', 'ordinance_img_path'];

}
