<?php

namespace App\Repository;

use App\Models\Tag\Tag;
use App\Repository\Interfaces\PostInterface;
use App\Repository\Interfaces\TagInterface;
use Yajra\DataTables\Facades\DataTables;

class TagRepository implements TagInterface
{

    public function ajax($request)
    {

        $query = Tag::query()->with('translations');
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editText   = __('main-words.edit');
                $deleteText = __('main-words.delete');

                $editBtn = '<a href="' . route('dashboard.tags.edit', $row->id) . '" class="btn btn-primary btn-sm me-1">' . $editText . '</a>';
                $deleteBtn = '<button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">' . $deleteText . '</button>';
                return   $editBtn . $deleteBtn;
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
    }

    public function store($request)
    {
        $validated = $request->validated();

        $tag = Tag::create($validated);
        multiLanguageSave($tag, $validated);
        return $tag;
    }


    public function update($request, $tag)
    {
        $validated = $request->validated();
        $tag->update($validated);
        multiLanguageSave($tag, $validated);
        return $tag;
    }

    public function destroy($tag)
    {
        $tag->delete();
        return true;
    }
}
