<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\CommissionService;
use Illuminate\Console\Command;

class CalculateCommissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commissions:calculate {fileName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will calculate commissions of operations';

    public function __construct(private readonly CommissionService $commissionService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $data = $this->commissionService->getOperationsData($this->argument('fileName'));

        foreach ($this->commissionService->calculateCommissions($data) as $commission) {
            echo $commission . PHP_EOL;
        }
    }
}
