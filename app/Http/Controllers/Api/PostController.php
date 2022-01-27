<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Comment;

class PostController extends Controller
{
    //用於生成 JSON 字串
    private function makeJson($status, $data, $msg)
    {
        //轉 JSON 時確保中文不會變成 Unicode
        return response()->json(['status' => $status, 'data' => $data, 'message' => $msg])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::get();
        $comments = Comment::get();

        if(isset($posts) && count($posts) > 0 && isset($comments) && count($comments) > 0){
            $data = ['posts' => $posts ,'comments' => $comments];
            return $this->makeJson(1,$data,null);
        }else{
            return $this->makeJson(0,null,'找不到任何文章');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = ['title' => $request->title , 'content' => $request->content];
        
        $post = Post::create($input);
        $posts_id = $post->posts_id;
        $com_input = ['posts_id' => $posts_id,'messages' => $request->messages];
        

        $comments = new Post();
        $comments->posts()->create($com_input);


        if(isset($post)){
            $data = ['post' => $post , 'comments' => $comments];
            return $this->makeJson(1,$data,'新增文章成功');
        }else{
            return $this->makeJson(0,null,'新增文章失敗');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        $comments = Comment::where('posts_id', $id);

        if(isset($post)){
            $data = ['post' => $post, 'comments'=> $comments];
            return $this->makeJson(1,$data,null);
        }else{
            return $this->makeJson(0,null,'找不到該文章');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            $post = Post::findOrFail($id);
            $post->title = $request->title;
            $post->content = $request->content;
            $post->save();
            $comments = Comment::where('posts_id', $id);
            $comments->messages = $request->messages;
            $comments->save();
            $data = ['post' => $post ,'comments'=> $comments];
        } catch (Throwable $e) {
            //更新失敗
            return $this->makeJson(0,null,'更新文章失敗');
        }

        
        return $this->makeJson(1,$data,'更新文章成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $post = Post::findOrFail($id);
            $post->delete();
            $comments = Comment::where('posts_id', $id);
            $comments->delete();
        } catch (Throwable $e) {
            //刪除失敗
            return $this->makeJson(0,null,'刪除文章失敗');
        }
        return $this->makeJson(1,null,'刪除文章成功');
    }
}
