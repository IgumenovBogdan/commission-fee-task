<?php

declare(strict_types=1);

namespace App\Services;

class DepositService
{
    private const COMMISSION = 0.0003;

    public function calculateDeposit(string $amount): string
    {
        return number_format($amount * self::COMMISSION, 2, '.', '');
    }
}
