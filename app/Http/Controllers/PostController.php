<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CreatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['validateAuthor'])->only('edit','update','destroy','trash');
        $this->middleware(['verifyCategoriesCount'])->only('create','store');

    }

    public function index()
    {
        if(auth()->user()->isAdmin()) {
            $posts = Post::paginate(3);
        } else {
            $posts = Post::where('user_id', auth()->id())->paginate(10);
        }
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return categories as well as tags so the select can show
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create', compact(['categories', 'tags']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        $image = $request->file('image')->store('images/posts');
        $post = Post::create([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
            'image' => $image,
            'published_at' => $request->published_at
        ]);
        $post->tags()->attach($request->tags);
        session()->flash('success', 'Post Created Succesfully');
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.edit', compact(['post','categories','tags']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->only(['title','excerpt','content','published_at','category_id']);
        if($request->hasFile('image')) {
            $image = $request->image->store('images/posts');
            $data['image'] = $image;
            $post->deleteImage();
        }
        $post->update($data);

        $post->tags()->sync($request->tags);
        session()->flash('success','Post Updated Succesfully');
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->deleteImage();
        $post->ForceDelete();
        session()->flash('success', 'Post deleted succesfully');
        return redirect(route('posts.trashed'));
    }

    public function trashed()
    {
        $trashed = Post::onlyTrashed()->paginate(10);
        return view('posts.trashed', ['posts'=> $trashed]);
    }

    public function trash(Post $post)
    {
        $post->delete();
        session()->flash('success', 'Post Trashed');
        return redirect(route('posts.index'));

    }

    public function restore($id)
    {
        $trashedPost = Post::onlyTrashed()->findOrFail($id);
        $trashedPost->restore();
        session()->flash('success','Post restored successfully !');
        return redirect(route('posts.index'));
    }

}
