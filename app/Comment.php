<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table = 'comments';
    protected $primaryKey = "comments_id";

    public function comments()
    {
        return $this->hasOne('App\Post','posts_id');
    }
}
