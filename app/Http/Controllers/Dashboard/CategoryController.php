<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CategoryStoreRequest;
use App\Http\Requests\Categories\CategoryUpdateRequest;
use App\Models\Category\Category;
use App\Repository\Interfaces\CategoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    protected $path;
    protected $categoryInterface;
    public function __construct(CategoryInterface $categoryInterface)
    {
        $this->path = 'dashboard.categories.';
        $this->categoryInterface = $categoryInterface;
    }

    public function index()
    {
        $title = 'All Categories';
        return view($this->path . 'index', compact('title'));
    }

    public function ajax(Request $request)
    {
        return $this->categoryInterface->ajax($request);
    }

    public function create()
    {

        $title = 'Create Category';
        $categories = Category::whereNull('category_id')->get();

        return view($this->path . 'create', compact('title', 'categories'));
    }


    public function store(CategoryStoreRequest $request)
    {
        $this->categoryInterface->store($request);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category Created Successfully'
            ]);
        }
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully');
    }


    public function edit(Category $category)
    {
        $title = 'Edit Category';
        $categories = Category::whereNull('category_id')
            ->where('id', '!=', $category->id)->get();

        return view($this->path . 'edit', compact('title', 'category', 'categories'));
    }


    public function update(CategoryUpdateRequest $request,  Category $category)
    {
        $this->categoryInterface->update($request, $category);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category updated Successfully'
            ]);
        }
        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully');
    }


    public function destroy(Request $request, Category $category)
    {
        $this->categoryInterface->destroy($category);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category deleted Successfully'
            ]);
        }
        return redirect()->route('dashboard.categories.index')->with('success', 'deleted updated successfully');
    }
    public function archive()
    {
        $title = 'Archive';
        return view($this->path . 'archive',compact('title'));
    }

    public function archiveAjax(Request $request)
    {
        return $this->categoryInterface->archiveAjax($request);
    }

    public function restore(Request $request, $id)
    {
        $this->categoryInterface->restore($id);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category restored Successfully'
            ]);
        }
        return redirect()->route('dashboard.categories.index')->with('success', 'deleted updated successfully');
    }

    public function delete(Request $request, $id)
    {
        $this->categoryInterface->delete($id);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category deleted Successfully'
            ]);
        }
        return redirect()->route('dashboard.categories.index')->with('success', 'deleted updated successfully');
    }
}
