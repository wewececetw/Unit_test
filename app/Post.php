<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'posts';
    protected $primaryKey = "posts_id";
    protected $fillable = ['title','content'];

    public function posts()
    {
        return $this->hasOne(Comment::class);
    }
}
