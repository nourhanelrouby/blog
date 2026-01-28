<?php

namespace App\Repository;

use App\Models\Post\Post;
use App\Repository\Interfaces\PostInterface;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PostRepository implements PostInterface
{
    public function ajax($request)
    {
        $query = Post::query()->with(['user','category','tags','translations']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editText   = __('main-words.edit');
                $deleteText = __('main-words.delete');

                $editBtn = '<a href="' . route('dashboard.posts.edit', $row->id) . '" class="btn btn-primary btn-sm me-1">' . $editText . '</a>';
                $deleteBtn = '<button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">' . $deleteText . '</button>';

                return  $editBtn . $deleteBtn;
            })
            ->addColumn('category', function ($row) {
                return $row->category->name ?? 'N/A';
            })
            ->addColumn('user', function ($row) {
                return $row->user->name ?? 'N/A';
            })
            ->addColumn('tags', function ($row) {
                $tagNames = $row->tags->pluck('title')->implode(', ');
                return $tagNames ?: 'N/A';
            })
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    $url = asset('storage/' . $row->image);
                    return "<img src='{$url}' width='50' height='50'/>";
                }
                return 'N/A';
            })
             ->rawColumns(['action', 'image'])
            ->make(true);
    }


    public function store($request)
    {
        $validated =  $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->image->store('posts','public');
        }

        $post = Post::create($validated);
         if($request->has('tags')){
            $post->tags()->attach($request->tags);
        }
        multiLanguageSave($post,$validated);
        return true;
    }

    public function update($request, $post)
    {
        $validated =  $request->validated();
        if ($request->image) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
          $validated['image'] = $request->image->store('posts','public');
        }

        $post->update($validated);
         if($request->has('tags')){
            $post->tags()->sync($request->tags??[]);
        }
        multiLanguageSave($post,$validated);
        return $post;
    }


    public function destroy( $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
         if($post->tags){
            $post->tags()->detach();
        }
        $post->delete();
        return true;
    }
}
