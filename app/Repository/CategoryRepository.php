<?php

namespace App\Repository;

use App\Models\Category\Category;
use App\Repository\Interfaces\CategoryInterface;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryRepository implements CategoryInterface
{

    public function ajax( $request)
    {
        $data = Category::query()->with('translations');

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editText   = __('main-words.edit');
                $deleteText = __('main-words.delete');

                $editBtn = '<a href="' . route('dashboard.categories.edit', $row->id) . '" class="btn btn-primary btn-sm me-1">' . $editText . '</a>';
                $deleteBtn = '<button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">' . $deleteText . '</button>';

                return  $editBtn . $deleteBtn;
            })
            ->addColumn('name', function ($row) {
                return $row->name ?? 'N/A';
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

    public function archiveAjax( $request)
    {
        $data = Category::onlyTrashed()->with('translations')->select('categories.*');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $restoreText = __('main-words.restore');
                $deleteText = __('main-words.delete');
                $restoreBtn = '<button type="button" class="btn btn-warning btn-sm me-1 restore-btn" data-id="' . $row->id . '">' . $restoreText . '</button>';
                $deleteBtn = '<button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">' . $deleteText . '</button>';

                return $restoreBtn . $deleteBtn;
            })
            ->addColumn('name', function ($row) {
                return $row->name ?? 'N/A';
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
        $validated = $request->validated();
        if ($request->hasFile('image')) {
              $validated['image'] = $request->file('image')->store('categories', 'public');
        }


        $category = Category::create([
            'image' => $validated['image'],
            'category_id' => $validated['category_id'],
        ]);
        multiLanguageSave($category, $validated);
        return $category;
    }


    public function update($request, $category)
    {

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }else{
            $validated['image'] = $category->image;
        }
        $category->update([
            'image' => $validated['image'],
            'category_id' => $validated['category_id'],
        ]);
        multiLanguageSave($category, $validated);
        return $category;
    }

    public function destroy($category)
    {
        $category->delete();
        return true;
    }

    public function restore($category)
    {
        $category = Category::withTrashed($category);
        $category->restore();
        return true;
    }

    public function delete($category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->forceDelete();
        return true;
    }
}
