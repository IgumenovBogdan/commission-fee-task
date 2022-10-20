<?php

declare(strict_types=1);

namespace App\Classes;

class Operation
{
    private const WITHDRAW = 'withdraw';
    private const DEPOSIT = 'deposit';
    private const PRIVATE = 'private';

    public string $date;
    public string $user_id;
    public string $user_type;
    public string $operation_type;
    public string $amount;
    public string $currency;

    public function __construct($data)
    {
        $this->date = $data['date'];
        $this->user_id = $data['user_id'];
        $this->operation_type = $data['operation_type'];
        $this->user_type = $data['user_type'];
        $this->amount = $data['amount'];
        $this->currency = $data['currency'];
    }

    public function isPrivateWithdraw(): bool
    {
        return $this->operation_type === self::WITHDRAW && $this->user_type === self::PRIVATE;
    }

    public function isDeposit(): bool
    {
        return $this->operation_type === self::DEPOSIT;
    }

    public function isWithdraw(): bool
    {
        return $this->operation_type === self::WITHDRAW;
    }

    public function isPrivateUser(): bool
    {
        return $this->user_type === self::PRIVATE;
    }
}
