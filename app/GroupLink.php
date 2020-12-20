<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupLink extends Model
{
    protected $fillable = [
        'phone', 'short_url','user_id'
    ];

    protected $table = "group_links";
}
