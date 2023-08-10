<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\TelegramUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Account::class;

    public function definition(): array
    {
        $randomTradeMode = Account::$trade_mode[array_rand(Account::$trade_mode)];

        $randomMarginSoMode = Account::$margin_so_mode[array_rand(Account::$margin_so_mode)];

        $randomTelegramUser = TelegramUser::inRandomOrder()
            ->first();

        $balance = $this->faker->numberBetween(10000, 50000);

        return [
            'login_id' => $this->faker->numberBetween(100000, 300000),
            'telegram_user_uuid' => $randomTelegramUser->uuid ?? $this->faker->uuid(),
            'trade_mode' => $randomTradeMode,
            'leverage' => 1000,
            'limit_orders' => 300,
            'margin_so_mode' => $randomMarginSoMode,
            'is_trade_allowed' => $this->faker->boolean(),
            'is_trade_expert' => $this->faker->boolean(),
            'balance' => $balance,
            'credit' => $this->faker->numberBetween(1, 50000),
            'profit' => $this->faker->numberBetween(1, 5000),
            'equity' => $balance * ($this->faker->numberBetween(-80, 100) / 100),
            'margin' => $this->faker->randomFloat(2, 1, 100000),
            'margin_free' => $this->faker->randomFloat(2, 1, 100000),
            'margin_level' => $this->faker->randomFloat(2, 1, 100000),
            'margin_so_call' => $this->faker->randomFloat(2, 1, 100),
            'margin_so_so' => $this->faker->randomFloat(2, 0, 1000),
            'margin_initial' => $this->faker->randomFloat(2, 0, 1000),
            'margin_maintenance' => $this->faker->randomFloat(2),
            'assets' => $this->faker->randomFloat(2, 1, 50000),
            'liabilities' => $this->faker->randomFloat(2, 0, 5000),
            'commission_blocked' => 0,
            'name' => 'MT4 ONE',
            'server' => 'XMGlobal-Demo',
            'currency' => $this->faker->currencyCode(),
            'company' => 'XM Global Limited',
        ];
    }
}
