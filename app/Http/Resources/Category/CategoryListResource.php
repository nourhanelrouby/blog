<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'image' => $this->image ? url('storage/' . $this->image) : null,

            'sub_categories' => CategoryListResource::collection(
                $this->whenLoaded('sub_categories')
            ),
        ];
    }
}
