<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'posts';
    protected $primaryKey = "posts_id";

    public function posts()
    {
        return $this->hasOne('App\Comment','posts_id');
    }
}
