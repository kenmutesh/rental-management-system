<?php

namespace App\Console\Commands;

use App\Models\Tenants;
use App\Traits\InvoicingTrait;
use Illuminate\Console\Command;

class GenerateMonthlyInvoices extends Command
{
    use InvoicingTrait;

    protected $signature = 'invoices:generate-monthly';
    protected $description = 'Generate monthly rent invoices for all active tenants';

    public function handle()
    {
        $tenants = Tenants::active()->with('unit')->get();
        $count = 0;

        foreach ($tenants as $tenant) {
            $this->createMonthlyInvoice($tenant);
            $count++;
        }

        $this->info("Generated {$count} monthly rent invoices");
        return 0;
    }
}
