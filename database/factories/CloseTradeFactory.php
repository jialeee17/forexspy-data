<?php

namespace Database\Factories;

use App\Models\OpenTrade;
use App\Models\CloseTrade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CloseTrade>
 */
class CloseTradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = CloseTrade::class;

    public function definition(): array
    {
        $randomOpenTrade = OpenTrade::inRandomOrder()
            ->first();

        $openPrice = $randomOpenTrade->open_price;

        $closePrice = $this->faker->randomFloat(5, $randomOpenTrade->open_price - 10, $randomOpenTrade->open_price + 100);

        $profit = $closePrice - $openPrice;

        return [
            'ticket' => $randomOpenTrade->ticket,
            'telegram_user_uuid' => $randomOpenTrade->telegram_user_uuid,
            'symbol' => $randomOpenTrade->symbol,
            'type' => $randomOpenTrade->type,
            'commission' => $randomOpenTrade->commission,
            'profit' => $profit,
            'stop_loss' => $this->faker->randomFloat(2, $openPrice * ($this->faker->numberBetween(1, 10) / $openPrice), $openPrice),
            'swap' => $randomOpenTrade->swap,
            'take_profit' => 0,
            'magic_number' => $randomOpenTrade->magic_number,
            'comment' => '',
            'open_price' => $randomOpenTrade->open_price,
            'open_at' => $randomOpenTrade->open_at,
            'close_price' => $closePrice,
            'close_at' => $this->faker->dateTimeInInterval($randomOpenTrade->open_at, 'now'),
            'expired_at' => null,
        ];
    }
}
