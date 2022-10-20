<?php

declare(strict_types=1);

namespace App\Services;

use App\Classes\Operation;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class CommissionService
{
    private const FREE_AMOUNT = 1000;

    public function __construct(
        private readonly DepositService $depositService,
        private readonly WithdrawService $withdrawService,
        private readonly CurrencyService $currencyService,
        private readonly CsvService $csvService
    ) {
    }

    public function getOperationsData(string $fileName): array
    {
        $keys = ['date', 'user_id', 'user_type', 'operation_type', 'amount', 'currency'];

        return $this->csvService->getCsvData(Operation::class, $keys, $fileName);
    }

    public function calculateCommissions(array $operations): array
    {
        $commissions = [];
        $currencies = $this->currencyService->getCurrencies();

        $counters = [];
        $dates = [];
        $freeAmounts = [];

        foreach ($operations as $operation) {
            $userId = $operation->user_id;
            $clientOperations = Arr::where($operations, static function ($value) use ($userId) {
                return $value->user_id === $userId && $value->isPrivateWithdraw();
            });
            $currentDate = Carbon::parse($operation->date)->addDays(
                abs(Carbon::parse($operation->date)->dayOfWeek - 7)
            );
            $isFirst = $this->checkIsFirst($dates, $userId, $currentDate);

            $counters[$userId] = $this->counterIteration($clientOperations, $operation, $counters);

            if ($isFirst) {
                $counters[$userId] = 1;
            }

            if ($isFirst && $operation->isPrivateWithdraw()) {
                $dates[$userId] = $currentDate;
                $freeAmounts[$userId] = self::FREE_AMOUNT;
            }

            if ($operation->isDeposit()) {
                $commissions[] = $this->depositService->calculateDeposit($operation->amount);
            }

            if ($operation->isWithdraw()) {
                $amountWithCurrency = $operation->amount / $this->currencyService->getCurrencyValue(
                        $operation->currency,
                        $currencies
                    );
                $commissions[] = $this->withdrawService->calculateWithdraw(
                    $operation,
                    $counters[$userId],
                    $freeAmounts[$userId] ?? 0,
                    $amountWithCurrency
                );

                if ($operation->isPrivateUser() && $freeAmounts[$userId] > 0) {
                    $freeAmounts[$userId] -= $amountWithCurrency;
                }
            }
        }

        return $commissions;
    }

    private function checkIsFirst(array $dates, string $userId, $currentDate): bool
    {
        if (isset($dates[$userId])) {
            return $currentDate->diffInDays($dates[$userId]) > 7;
        }

        return true;
    }

    private function counterIteration(array $clientOperations, object $operation, array $counters): int
    {
        if (count($clientOperations) > 1 && $operation->isWithdraw()) {
            if (isset($counters[$operation->user_id])) {
                return $counters[$operation->user_id]++;
            }

            return 1;
        }

        return 1;
    }
}
