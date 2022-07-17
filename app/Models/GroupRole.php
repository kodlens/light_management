<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupRole extends Model
{
    use HasFactory;


    protected $table = 'group_roles';
    protected $primaryKey = 'group_role_id';

    protected $fillable = ['group_role_name'];

}
