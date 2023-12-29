<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Item */
class ItemResource extends JsonResource
{
    public static $fullView = false;
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'name' =>  $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'category' => $this->when(self::$fullView,fn() => new CategoryResource($this->whenLoaded('category'))),
            'discount' => new DiscountResource($this->whenLoaded('discount')),
        ];
    }
}
