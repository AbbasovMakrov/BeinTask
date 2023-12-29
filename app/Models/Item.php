<?php

namespace App\Models;

use App\Traits\Discountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use Discountable;
    protected $fillable = ['price','category_id','name'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


}
