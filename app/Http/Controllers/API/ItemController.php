<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Discount\DiscountRequest;
use App\Http\Requests\API\Item\FilterRequest;
use App\Http\Requests\API\Item\ItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Item;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class ItemController extends Controller
{
    public function index(FilterRequest $request)
    {
        $items = Item::when($request['menu_id'],fn(Builder $q) => $q->whereHas("category.menu",fn($qq) => $qq->where('id',$request['menu_id'])))
            ->when($request['category_id'], fn(Builder $query) => $query->where("category_id",$request['category_id']))
            ->with(['discount','category' => fn(BelongsTo $q) => $q->with(["parentCategory.discount","discount","menu.discount"]) /*'category.discount','category.parentCategory.discount','category.menu.discount'*/])
            ->get();
       // dd($items);
        return $this->jsonResponse([
                'data' => [
                    'items' => ItemResource::collection($items)
                ]
        ]);
    }

    public function store(ItemRequest $request)
    {
        $hasParentCategorySubCategories = Category::has("subCategories")->where('id',$request['category_id'])->exists();
        if ($hasParentCategorySubCategories){
            return  $this->jsonResponse([
                'validation_errors' => [
                    'category_id' => ["this category can not be used"]
                ],
                "message" => "error creating new item"
            ],422);
        }
        $item = Item::create($request->validated());

        return $this->jsonResponse([
            'data' => [
                'item_id'  => $item->id
            ]
        ],201);
    }

    public function show(Item $item)
    {
        $item->load(['discount','category' => fn(BelongsTo $q) => $q->with(["parentCategory.discount","discount","menu.discount"])]);
        return $this->jsonResponse([
            'data' => [
                'item' => new ItemResource($item)
            ]
        ]);
    }

    public function update(ItemRequest $request, Item $item)
    {
        $hasParentCategorySubCategories = Category::has("subCategories")->where('id',$request['category_id'])->exists();
        if ($hasParentCategorySubCategories){
            return  $this->jsonResponse([
                'validation_errors' => [
                    'category_id' => ["this category can not be used"]
                ],
                "message" => "error creating new item"
            ],422);
        }
        $item->update($request->validated());
        return $this->jsonResponse([],204);
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return $this->jsonResponse([],204);
    }
    public function discount(Item $item,DiscountRequest $request)
    {
        if ($item->has("discount"))
            $item->discount()->delete();
        $item->discount()->create(['amount' => $request['amount']]);
        return $this->jsonResponse([],204);
    }
}
