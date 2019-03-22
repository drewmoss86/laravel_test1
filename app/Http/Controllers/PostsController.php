<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;

class PostsController extends Controller
{
    /**
     * Prevents guests from accessing posts
     * Exception applied to index and show
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show'] ]);
    }

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
            'body' => 'required',   //must have a body to submit
            'cover_image' => 'image|nullable|max:1999' //set max of 2MB (apache server default size 2MB)
        ]);

        //Handle file upload
        if($request->hasFile('cover_image')) {
            //Get filename w/ extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get filename only
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get ext only
            $ext = $request->file('cover_image')->getClientOriginalExtension();

            //Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$ext;  //prevents override of img with same name as previous img
            //Upload img
            $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        //create post
        $p = new Post;  //create new post var
        $p->title = $request->input('title');
        $p->body = $request->input('body');
        $p->user_id = auth()->user()->id;
        $p->cover_image = $fileNameToStore;
        $p->save();

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

        //check for correct user so you cannot manually add edit to url
        if(auth()->user()->id !== $p->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }


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
            'body' => 'required',   //must have a body to submit
            'cover_image' => 'image|nullable|max:1999'
        ]);
        
        //Handle file upload
        if($request->hasFile('cover_image')) {
            //Get filename w/ extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get filename only
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get ext only
            $ext = $request->file('cover_image')->getClientOriginalExtension();

            //Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$ext;  //prevents override of img with same name as previous img
            //Upload img
            $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
        } 

        //update post
        $post = Post::find($id); //since updating, just search
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->cover_image = $fileNameToStore;
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

        //check for correct user so you cannot manually add edit to url
        if(auth()->user()->id != $p->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        
        //ck if there is an img to delete
        if($p->cover_image != 'noimage.jpg') {
            //Delete img
            Storage::delete('public/cover_image/'.$p->cover_image);
        }

        $p->delete();
        return redirect('/posts')->with('success', 'Post Removed');
    }
}
