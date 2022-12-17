<?php

namespace App\Service;

use Ecommerce\Common\DTOs\Rating\ProductRatingData;
use Ecommerce\Common\Events\Rating\ProductRatedEvent;
use Ecommerce\Common\Services\RedisService as BaseRedisService;

class RedisService extends BaseRedisService
{
    public function getServiceName(): string
    {
        return 'ratings';
    }

    public function publishProductRated(ProductRatingData $data)
    {
        $this->publish(new ProductRatedEvent($data));
    }
}
