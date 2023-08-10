<?php

namespace Database\Factories;

use App\Models\OpenTrade;
use App\Models\TelegramUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OpenTrade>
 */
class OpenTradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = OpenTrade::class;

    public function definition(): array
    {
        $randomTelegramUser = TelegramUser::inRandomOrder()
            ->first();

        $symbol = [
            'AEDAUD',
            'USDCHF',
            'GBPUSD',
            'EURUSD',
            'EURCHF',
        ];

        $randomType = OpenTrade::$type[array_rand(OpenTrade::$type)];

        $openPrice = $this->faker->randomFloat(5, 50, 150);


        return [
            'ticket' => 'TX' . $this->faker->numberBetween(100000, 500000),
            'telegram_user_uuid' => $randomTelegramUser->uuid ?? $this->faker->uuid(),
            'symbol' => $symbol[array_rand($symbol)],
            'type' => $randomType,
            'commission' => $this->faker->randomFloat(2, 0, 5),
            'profit' => 0,
            'stop_loss' => $this->faker->randomFloat(2, $openPrice * ($this->faker->numberBetween(1, 10) / $openPrice), $openPrice),
            'swap' => $this->faker->randomFloat(1, 20, 30),
            'take_profit' => 0,
            'magic_number' => 'MG' . $this->faker->numberBetween(100000, 500000),
            'comment' => '',
            'open_price' => $openPrice,
            'open_at' => $this->faker->dateTimeBetween('-3 week', 'now'),
            'close_price' => null,
            'close_at' => null,
            'expired_at' => null,
        ];
    }
}
