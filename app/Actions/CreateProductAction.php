<?php

namespace App\Actions;

use App\Models\Product;
use Ecommerce\Common\DTOs\Product\ProductData;

class CreateProductAction
{
    public function execute(ProductData $data): Product
    {
        return Product::create([
            'uuid' => $data->uuid,
            'name' => $data->name,
        ]);
    }
}
