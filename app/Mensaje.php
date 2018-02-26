<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = "mensaje";
    protected $fillable = ['file_name'];
}
