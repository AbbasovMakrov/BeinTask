<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['amount'];

    public function discountable()
    {
        return $this->morphTo("discountable");
    }
}
