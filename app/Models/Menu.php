<?php

namespace App\Models;

use App\Traits\Discountable;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Discountable;
    protected $fillable = [
        'name',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

}
