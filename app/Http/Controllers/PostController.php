<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use Session;
use Illuminate\Support\Facades\Input;
use DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $posts = Post::all();

        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post_type = DB::table('post_category')
        ->join('post_subcategory','post_category.id', '=', 'post_subcategory.category_id')
        ->select('category_name', 'subcategory_name')
        ->orderby('category_name')->get();
        return view('posts.create')->with('post_type', $post_type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'post_type' => 'required|max:20',
            'body' => 'required|max:250',
            'contacts' => 'required',
            'image' => 'mimes:jpeg,bmp,png',
        ));

        $post = new Post;

        $post->post_type = $request->post_type;
        $post->body = $request->body;
        $post->contacts = $request->contacts;

        if (Input::hasFile('image')) {
          $file = Input::file('image');
          $fileRealName = $file->getClientOriginalName();
          $fileName = rand(11111,99999) . '_' .$fileRealName;
          $file->move('post_pictures', $fileName);
          $post->image_src = $fileName;
        }

       $post->save();

       Session::flash('success', 'The blog post was successfully save!');

       return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
