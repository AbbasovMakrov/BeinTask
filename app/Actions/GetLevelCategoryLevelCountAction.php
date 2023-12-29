<?php

namespace App\Actions;

use App\Models\Category;
use DB;
use Lorisleiva\Actions\Concerns\AsJob;
use Lorisleiva\Actions\Concerns\AsObject;

class GetLevelCategoryLevelCountAction
{
    use AsObject, AsJob;

    public function handle(int $childId) : int
    {
        $upperParentId = DB::selectOne("SELECT GetUpperParentId(:childId) as upper_parent_id;",[':childId' => $childId])->upper_parent_id;
        return DB::selectOne("select GetCategoryHierarchyLevelCount(:parentId) as levels_count" , [':parentId' => $upperParentId])->levels_count;
    }
}
