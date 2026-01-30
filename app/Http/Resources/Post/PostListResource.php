<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Category\CategoryListResource;
use App\Http\Resources\Tag\TagListResource;
use App\Http\Resources\User\UserListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'title' => $this->title,
            'content' => $this->content,
            'small_description' => $this->small_description,
            'image' => url('storage/' . $this->image),
            'user' => new UserListResource($this->whenLoaded('user')),
            'category' => new CategoryListResource ($this->whenLoaded('category')),
            'tags' => TagListResource::collection($this->whenLoaded('tags'))

        ];
    }
}
