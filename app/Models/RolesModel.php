<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

date_default_timezone_set('Asia/Jakarta');

class RolesModel extends Model
{
    protected $table = 'tb_roles';

    protected $fillable = ['name'];
}
