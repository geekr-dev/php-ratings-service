<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\ProductRating;
use App\Service\RedisService;
use Ecommerce\Common\DTOs\Rating\ProductRatingData;
use Illuminate\Support\Facades\DB;

class RateProductAction
{
    public function __construct(
        private readonly RedisService $redis,
    ) {
    }

    public function execute(Product $product, float $score, ?string $comment): ProductRatingData
    {
        return DB::transaction(function () use ($product, $score, $comment) {
            $avgScore = $this->rate($product, $score, $comment);
            $data = new ProductRatingData(
                $product->uuid,
                $avgScore,
            );
            $this->redis->publishProductRated($data);
            return $data;
        });
    }

    private function rate(Product $product, float $score, ?string $comment): float
    {
        ProductRating::create([
            'product_id' => $product->id,
            'score' => $score,
            'comment' => $comment,
        ]);

        return $this->updateAvgScore($product);
    }

    private function updateAvgScore(Product $product): float
    {
        $product->score = round($product->rating->avg('score'), 2);
        $product->save();
        return $product->score;
    }
}
