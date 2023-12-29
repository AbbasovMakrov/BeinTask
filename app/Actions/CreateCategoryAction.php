<?php

namespace App\Actions;

use App\Models\Category;
use Lorisleiva\Actions\Concerns\AsJob;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateCategoryAction
{
    use AsObject, AsJob;

    public function handle(array $data) : int
    {
        return Category::create($data)->id;
    }

}
