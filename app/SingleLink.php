<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SingleLink extends Model
{
    protected $fillable = [
        'short_url','phone','pretext','user_id'
    ];

    protected $table = "single_links";
}
