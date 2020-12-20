<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupLinkPretext extends Model
{
    protected $fillable = [
        'short_url', 'pretext_chat'
    ];

    protected $table = "group_links_pretext";
}
