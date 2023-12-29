<?php

namespace App\Http\Controllers\API;

use App\Actions\CreateCategoryAction;
use App\Actions\FormatCategoriesResponseAction;
use App\Actions\GetLevelCategoryLevelCountAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Category\CreateRequest;
use App\Http\Requests\API\Category\FilterRequest;
use App\Http\Requests\API\Category\UpdateRequest;
use App\Http\Requests\API\Discount\DiscountRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller
{
    public function index(FilterRequest $request)
    {
        CategoryResource::$fullView = false;
        $categories = Category::with("subCategories.subCategories.subCategories.subCategories")
            ->when($request['menu_id'], fn(Builder $query) => $query->where("menu_id",$request['menu_id']))
            ->get();
        return $this->jsonResponse([
            'data' => [
                'categories' => FormatCategoriesResponseAction::make()->handle($categories)
            ]
        ]);
    }

    public function store(CreateRequest $request)
    {
        $response = [
            'data' => [
                'category_id' => null
            ]
        ];
        $data = $request->validated();
        $categoryCreatingAction = CreateCategoryAction::make();
        if (!$request->filled("parent_id")){
            $response['data']['category_id'] = $categoryCreatingAction->handle($data);
            return $this->jsonResponse($response,201);
        }
        $parentCategory = Category::find($request['parent_id']);
        if ($parentCategory->items()->exists()){
            $response = [
                'validation_errors' => [
                    'parent_id' => ["You can not use this parent category , it used as items category"]
                ],
                'message' => "Error Creating SubCategory"
            ];
             return $this->jsonResponse($response,422);
        }
        if (is_null($parentCategory->parent_id)){
             $response['data']['category_id'] = $categoryCreatingAction->handle($data);
             return $this->jsonResponse($response,201);
        }

        $subCategoryLevels = GetLevelCategoryLevelCountAction::make()->handle($data['parent_id']);
        logger()->info("Level Count : {$subCategoryLevels}");
        if ($subCategoryLevels >= 4){
            $response = [
                'validation_errors' => [
                    'parent_id' => ["Max. Subcategories levels is 4 levels only!"]
                ],
                'message' => "Error Creating SubCategory"
            ];
            return $this->jsonResponse($response,422);
        }
        $response['data']['category_id'] = $categoryCreatingAction->handle($data);
        return  $this->jsonResponse($response,201);

    }

    public function show(Category $category)
    {
        $category->load(["discount","subCategories"]);
        $category->loadCount("items");
        return $this->jsonResponse([
            'data' => [
                'category' => new CategoryResource($category)
            ]
        ]);
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return $this->jsonResponse([],204);
    }
    public function update(UpdateRequest $request,Category $category)
    {
        $data = $request->validated();
        $category->update($data);
        return $this->jsonResponse(statusCode: 204);

    }
    public function discount(Category $category,DiscountRequest $request)
    {
        if ($category->has("discount"))
            $category->discount()->delete();
        $category->discount()->create(['amount' => $request['amount']]);
        return $this->jsonResponse([],204);
    }
}
