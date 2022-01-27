<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Comment;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\Post::class, 50)->create()->each(function ($u) {
            $u->posts()->save(factory(\App\Comment::class)->make());
        });
    }
}
