<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Category\Category;
use App\Models\Post\Post;
use App\Models\Tag\Tag;
use App\Models\User;
use App\Repository\Interfaces\PostInterface;


class PostController extends Controller
{
    protected $postInterface;
    protected $path;

    public function __construct(PostInterface $postInterface)
    {
        $this->path = 'dashboard.posts.';
        $this->postInterface = $postInterface;
    }

    public function index()
    {
        $title = 'All Posts';
        $categories = Category::with('translations')->get('id','name');
        $users = User::get('id','name');
        $tags = Tag::with('translations')->get('id','title');
        return view($this->path . 'index',
         compact('title','categories','users','tags'));
    }

    public function ajax(Request $request)
    {
        return $this->postInterface->ajax($request);
    }

    public function create()
    {
        $title = 'Create New Post';
        return view($this->path . 'create', compact('title'));
    }


    public function store(PostStoreRequest $request)
    {
         $this->postInterface->store($request);
         if($request->ajax()){
            return[
                'success'=>true,
                'message'=>'Post created successfully',
            ];
         }
         return redirect()->route('dashboard.posts.index');
    }

    public function edit(Post $post)
    {
      
        $title = 'Edit Post';
        return view($this->path . 'edit', compact('title', 'post'));
    }


    public function update(PostUpdateRequest $request, Post $post)
    {
        $this->postInterface->update($request ,$post);
        if($request->ajax()){
            return[
                'success'=>true,
                'message'=>'Post updated successfully',
            ];
         }
         return redirect()->route('dashboard.posts.index');
    }


    public function destroy(Request $request,Post $post)
    {
         $this->postInterface->destroy($post);
        if($request->ajax()){
            return[
                'success'=>true,
                'message'=>'Post deleted successfully',
            ];
         }
         return redirect()->route('dashboard.posts.index');
    }
}
