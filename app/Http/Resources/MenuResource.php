<?php

namespace App\Http\Resources;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Menu */
class MenuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        CategoryResource::$fullView = true;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'categories_count' => $this->whenCounted('categories'),
            "categories" => $this->whenLoaded('categories',function (){

                return collect(CategoryResource::collection($this->categories))
                    ->where("parentCategory.parent_id","=",null)
                    ->where("parent_id",null)
                    ->groupBy("id")
                    ->map(fn($c) => $c[0])
                    ->values();

            }),
            "discount" => new DiscountResource($this->whenLoaded("discount"))
        ];
    }
}
