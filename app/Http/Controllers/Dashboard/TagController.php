<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tags\TagStoreRequest;
use App\Http\Requests\Tags\TagUpdateRequest;
use App\Models\Tag\Tag;
use App\Repository\Interfaces\TagInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    protected $path;
    protected $tagInterface;

    public function __construct(TagInterface $tagInterface)
    {
        $this->path = 'dashboard.tags.';
        $this->tagInterface = $tagInterface;
    }

    public function index()
    {
        $title = 'All Tags';
        return view($this->path . 'index', compact('title'));
    }

    public function ajax(Request $request)
    {
        return $this->tagInterface->ajax($request);
    }


    public function create()
    {
        $title = 'Add new Tag';
        return view($this->path . 'create', compact('title'));
    }


    public function store(TagStoreRequest $request)
    {
         $this->tagInterface->store($request);
         if($request->ajax()){
            return response()->json(
                [
                'success'=>true,
                'message'=>'Tag created sucessfully',
            ]);

         }

         return redirect()->route('dashboard.tags.index');
    }


    public function edit(Tag $tag)
    {
        $title = 'Add new Tag';
        return view($this->path . 'edit', compact('title', 'tag'));
    }


    public function update(TagUpdateRequest $request, Tag $tag)
    {
         $this->tagInterface->update($request, $tag);
        if($request->ajax()){
            return response()->json(
                [
                'success'=>true,
                'message'=>'Tag updated sucessfully',
            ]);

         }

         return redirect()->route('dashboard.tags.index');

    }


    public function destroy(Request $request,  Tag $tag)
    {
        $this->tagInterface->destroy($tag);

        if($request->ajax()){
            return response()->json(
                [
                'success'=>true,
                'message'=>'Tag deleted sucessfully',
            ]);

         }

         return redirect()->route('dashboard.tags.index');
    }
}
