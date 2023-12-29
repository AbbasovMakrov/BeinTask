<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Category */
class CategoryResource extends JsonResource
{
    public static bool $fullView = false;

    public static function collection($resource)
    {
        return parent::collection($resource);

    }

    public function toArray(Request $request): array
    {
        if (self::$fullView){
            $this->computeDiscount();
            $this->loadItemsWithDiscount();
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'items_count' => $this->whenCounted('items'),
            'sub_categories_count' => $this->whenCounted('subCategories'),
            'is_parent_entity' => is_null($this->parent_id) ,
            'parent_id' => $this->parent_id ,
            'menu_id' => $this->menu_id,
            'menu' => new MenuResource($this->whenLoaded('menu')),
            'parentCategory' => new CategoryResource($this->whenLoaded('parentCategory')),
            'subCategories' => CategoryResource::collection($this->whenLoaded('subCategories')),
            'discount' => $this->when(!is_null($this->discount),fn() => $this->discount),
            'items' => ItemResource::collection($this->whenLoaded('items'))
        ];
    }
}
