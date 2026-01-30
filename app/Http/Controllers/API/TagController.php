<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tags\TagStoreRequest;
use App\Http\Requests\Tags\TagUpdateRequest;
use App\Http\Resources\Tag\TagListResource;
use App\Models\Tag\Tag;
use App\Repository\Interfaces\TagInterface;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $tagInterface;

    public function __construct(TagInterface $tagInterface)
    {
        $this->tagInterface = $tagInterface;
    }

    public function index(Request $request)
    {
        $per_page = $request->per_page;
        $query = Tag::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('translations', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }
        $tags = $query->paginate($per_page);
        if ($tags->isEmpty()) {
            return successResponse([], 'No Data Found!');
        }
        $tags = TagListResource::collection($tags);
        return paginatedResponse($tags);
    }


    public function store(TagStoreRequest $request)
    {
        $value = $this->tagInterface->store($request);
        $tag =  new TagListResource($value);
        return successResponse($tag, 'Tag Stored Successfully!');
    }


    public function show(Tag $tag)
    {
        $tag = new TagListResource($tag);
        return successResponse($tag, 'Tag Retrived Successfully!');
    }


    public function update(TagUpdateRequest $request, Tag $tag)
    {
        $tag = $this->tagInterface->update($request, $tag);
        $tag = new TagListResource($tag);
        return successResponse($tag, 'Tag Updated Successfully!');
    }


    public function destroy(Tag $tag)
    {
        $this->tagInterface->destroy($tag);
        return successResponse([], 'Tag Deleted Successfully!');
    }
}
