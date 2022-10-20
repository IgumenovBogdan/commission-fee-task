<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    public function __construct(
        private readonly string $getCurrenciesUrl
    ) {
    }

    public function getCurrencies(): Response
    {
        return Http::get($this->getCurrenciesUrl);
    }

    public function getCurrencyValue(string $currency, Response $currencies): float
    {
        return round($currencies['rates'][$currency], 2);
    }
}
