<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CategoryStoreRequest;
use App\Http\Requests\Categories\CategoryUpdateRequest;
use App\Http\Resources\Category\CategoryListResource;
use App\Models\Category\Category;
use App\Repository\Interfaces\CategoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryInterface;

    public function __construct(CategoryInterface $categoryInterface)
    {
        $this->categoryInterface = $categoryInterface;
    }

    public function index(Request $request)
    {
        $per_page = $request->per_page;

        $query = Category::with('sub_categories');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('translations', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $categories = $query->paginate($per_page);
        if ($categories->isEmpty()) {
            return successResponse([], 'No Data found!');
        }

        $categories = CategoryListResource::collection($categories);

        return paginatedResponse($categories, 'Categories retrived successfully', 200);
    }


    public function store(CategoryStoreRequest $request)
    {
        $category = $this->categoryInterface->store($request);
        $category->load('sub_categories');
        $category = new CategoryListResource($category);
        return successResponse($category, 'Data Stored Successfully!', 200);
    }


    public function show(Category $category)
    {
        return successResponse(new CategoryListResource($category), 'Category retrived successfully!');
    }


    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category = $this->categoryInterface->update($request, $category);
        $category->load('sub_categories');
        $category = new CategoryListResource($category);
        return successResponse($category, 'Data Updated Successfully!', 200);
    }

    public function destroy(Category $category)
    {
        $this->categoryInterface->delete($category);
        return successResponse([], 'Data Forced deleted Successfully!', 200);
    }

    public function delete(Category $category)
    {
        $this->categoryInterface->destroy($category);
        return successResponse([], 'Data Softed deleted Successfully!', 200);
    }

    public function restore($category)
    {
        $value = $this->categoryInterface->restore($category);
        if ($value == false) {
            return errorResponse([], 'Category not found!');
        }
        return successResponse([], 'Data Restored Successfully!', 200);
    }

    public function archive(Request $request)
    {
        $value = $this->categoryInterface->archive($request);
        if($value == false){
            return successResponse([],'Archive Is Empty!');
        }
        $categories = CategoryListResource::collection($value);
        return paginatedResponse($categories);
    }
}
