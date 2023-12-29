<?php

namespace App\Actions;

use App\Http\Resources\CategoryResource;
use Lorisleiva\Actions\Concerns\AsJob;
use Lorisleiva\Actions\Concerns\AsObject;

class FormatCategoriesResponseAction
{
    use AsObject, AsJob;

    public function handle($categories)
    {

        return collect(CategoryResource::collection($categories))
            ->where("parentCategory.parent_id","=",null)
            ->where("parent_id",null)
            ->groupBy("id")
            ->map(fn($c) => $c[0])
            ->values();
    }
}
