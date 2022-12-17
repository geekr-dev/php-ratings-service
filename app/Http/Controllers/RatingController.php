<?php

namespace App\Http\Controllers;

use App\Actions\RateProductAction;
use App\Http\Requests\RateProductRequest;
use App\Models\Product;
use Illuminate\Http\Response;

class RatingController extends Controller
{
    public function store(
        Product $product,
        RateProductRequest $request,
        RateProductAction $rateProduct,
    ) {
        $productRatingData = $rateProduct->execute(
            $product,
            $request->getRating(),
            $request->getComment(),
        );
        return response([
            'data' => $productRatingData
        ], Response::HTTP_CREATED);
    }
}
