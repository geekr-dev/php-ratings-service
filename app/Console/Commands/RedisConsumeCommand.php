<?php

namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use App\Service\RedisService;
use Ecommerce\Common\DTOs\Product\ProductData;
use Ecommerce\Common\Enums\Events;
use Illuminate\Console\Command;

class RedisConsumeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume events from Redis stream';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        RedisService $redis,
        CreateProductAction $action,
    ) {
        foreach ($redis->getUnprocessedEvents() as $event) {
            match ($event['type']) {
                Events::PRODUCT_CREATED => $action->execute(
                    ProductData::fromArray($event['data']),
                ),
                default => null
            };

            $redis->addProcessedEvent($event);
        }
    }
}
