<?php

namespace App\Http\Controllers\API\Common;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Admin\CategoryFormRequest;

class BaseCategoryController extends Controller
{
    public function index() 
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return response() -> json([
            'status' => 1,
            'message' => 'List of all categories',
            'data' => [
                'categories' => CategoryResource::collection($categories)
            ]
        ], 200); 
    }

    /////////////////////////////////////////////////////////////////////////  
    public function store(CategoryFormRequest $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->save();

        return response() -> json([
            'status' => 1,
            'message' => 'New category created successfully',
            'data' => [
                'category' => new CategoryResource($category)
            ]
        ], 201);                

    }    

    /////////////////////////////////////////////////////////////////////////  
    public function update(CategoryFormRequest $request, $id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return response() -> json([
            'status' => 1,
            'message' => 'Category deatils updated successfully',
            'data' => [
                'category' => new CategoryResource($category),
            ]
        ], 200);              

    }    


    /////////////////////////////////////////////////////////////////////////  
    public function removeCategoryRecord($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->delete();

        return response() -> json([
            'status' => 1,
            'message' => 'Category removed successfully',
        ], 200);            

    }


}
