<?php

namespace App\Models;

use App\Builders\ProductBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function ratinngs()
    {
        return $this->hasMany(ProductRating::class);
    }

    public function newEloquentBuilder($query)
    {
        return new ProductBuilder($query);
    }
}
