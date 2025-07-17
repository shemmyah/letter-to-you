<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    protected $fillable = [
        'caption',
        'base64_image',
    ];
}
