<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Http\Resources\Post\PostListResource;
use App\Models\Post\Post;
use App\Repository\Interfaces\PostInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{

    private $postInterface;

    public function __construct(PostInterface  $postInterface)
    {
        $this->postInterface = $postInterface;
    }
    public function index(Request $request)
    {
        $per_page = $request->per_page;
        $query = Post::with(['user', 'category', 'tags']);

        if ($request->has('search')) {
            $search = $request->search;
            // Search on post translations
            $query->whereHas('translations', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%')
                    ->orWhere('small_description', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('user_id')) {
            // Search on user translations
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('category_id')) {
            // Search on category translations
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('tag_id')) {
            // Search on tags translations
            $search = $request->tag_id;
            $query->whereHas('tags', function ($t) use ($search) {
                $t->where('tag_id', $search);
            });
        }

        $posts = $query->paginate($per_page);
        if ($posts->isEmpty()) {
            return successResponse([], 'No Data found!');
        }
        return paginatedResponse($posts);
    }


    public function store(PostStoreRequest $request)
    {
        $value = $this->postInterface->store($request);
        $post = new PostListResource($value);
        return successResponse($post, 'Post stored successfully!');
    }


    public function show(Post $post)
    {
        if (empty($post)) {
            return successResponse([], 'Post not found!');
        }
        $post->load(['user', 'category', 'tags']);
        $post = new PostListResource($post);
        return successResponse($post, 'Post retrived successfully!');
    }


    public function update(PostUpdateRequest $request, Post $post)
    {
        $post = $this->postInterface->update($request, $post);
        $post = new PostListResource($post);
        return successResponse($post, 'Post Updated successfully!');
    }


    public function destroy(Post $post)
    {
        $this->postInterface->destroy($post);
        return successResponse([], 'Post Deleted successfully!');
    }
}
