<?php

namespace App\Models;

use App\Traits\Discountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Category extends Model
{
    use Discountable;
    protected $fillable = [
        'name',
        'parent_id',
        'menu_id'
    ];

    public function subCategories()
    {
        return $this->hasMany(Category::class,"parent_id","id");
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class,"parent_id","id");
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function computeDiscount()
    {
        $discount = $this->discount;
        if (  is_null($discount)){
            $discount = $this->menu->discount ?? $this->parentCategory()->first()->discount()->first();
            $this->discount = $discount;
        }
        $this->subCategories->whereNull("discount")
            ->each(fn(Category $c) => $c->discount = $discount);
    }

    public function loadItemsWithDiscount()
    {
        if ($this->subCategories?->isNotEmpty())
            return;
        logger()->info("{$this->id} has items");
        $this->load(["items.discount"]);
    }
    public function items()
    {
        return $this->hasMany(Item::class);
    }

}
