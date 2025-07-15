<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dedication extends Model
{
    protected $fillable = [
        'song_title',
        'song_link',
        'message',
        'sender',
        'recipient',
    ];
}
