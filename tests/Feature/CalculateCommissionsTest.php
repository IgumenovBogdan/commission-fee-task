<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\CommissionService;

class CalculateCommissionsTest extends TestCase
{

    protected CommissionService $commissionService;

    public function setUp(): void
    {
        parent::setUp();

        $this->commissionService = $this->app->make(CommissionService::class);
    }

    public function testConsoleCommand(): void
    {
        $data = $this->commissionService->calculateCommissions(
            $this->commissionService->getOperationsData('input.csv')
        );
        $this->assertSame(
            $data,
            ["0.60", "3.00", 0, "0.06", "1.50", 0, "0.69", "0.30", "0.30", "3.00", 0, 0, "8997.00"]
        );
    }
}
