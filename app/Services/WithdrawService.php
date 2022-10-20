<?php

declare(strict_types=1);

namespace App\Services;

class WithdrawService
{
    private const BUSINESS_CLIENT = 0.005;
    private const PRIVATE_CLIENT = 0.003;

    public function calculateWithdraw(object $operation, int $counter, float $freeAmount, float $amount): string|int
    {
        if ($operation->user_type === 'business') {
            return number_format($operation->amount * self::BUSINESS_CLIENT, 2, '.', '');
        }

        if ($operation->user_type === 'private') {
            return $this->calculateForPrivateClient($operation, $counter, $freeAmount, $amount);
        }
    }

    public function calculateForPrivateClient(
        object $operation,
        int $counter,
        float $freeAmount,
        float $amount
    ): string|int {
        if ($amount <= $freeAmount && $counter <= 3) {
            return 0;
        }

        if ($amount > $freeAmount && $freeAmount > 0) {
            return number_format(($operation->amount - $freeAmount) * self::PRIVATE_CLIENT, 2, '.', '');
        }

        return number_format($operation->amount * self::PRIVATE_CLIENT, 2, '.', '');
    }
}
