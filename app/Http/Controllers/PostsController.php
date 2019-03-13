<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::all(); 
        // $posts = DB::select('SELECT * FROM posts'); --> doesn't work
        // $posts = Post::orderBy('title', 'desc')->take(2)->get(); //allow a set number
        // $posts = Post::orderBy('title', 'desc')->get(); //descending order
        
        $posts = Post::orderBy('created_at', 'desc')->paginate(10); //descending order
        return view('posts/index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation 
        $this->validate($request, [
            'title' => 'required', //must have a title to submit
            'body' => 'required'   //must have a body to submit
        ]);

        //create post
        $post = new Post;  //create new post var
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $p = Post::find($id);
        return view('posts/show')->with('p', $p);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $p = Post::find($id);
        return view('posts/edit')->with('p', $p);
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
        //validation 
        $this->validate($request, [
            'title' => 'required', //must have a title to submit
            'body' => 'required'   //must have a body to submit
        ]);

        //update post
        $post = Post::find($id); //since updating, just search
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $p = Post::find($id);
        $p->delete();

        return redirect('/posts')->with('success', 'Post Removed');
    }
}
