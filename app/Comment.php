<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table = 'comments';
    protected $primaryKey = "comments_id";
    protected $fillable = ['messages'];
    
    public function comments()
    {
        return $this->belongsTo(Post::class);
    }
}
