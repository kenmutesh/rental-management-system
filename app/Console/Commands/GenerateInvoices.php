<?php

namespace App\Console\Commands;

use App\Models\InvoiceItem;
use App\Models\Invoices;
use App\Models\Tenants;
use App\Models\Units;
use Illuminate\Console\Command;

class GenerateInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generate invoices for customers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Fetch all units that are occupied by tenants
        $units = Units::whereNotNull('occupied_by')->get();

        foreach ($units as $unit) {
            // Find the tenant occupying the unit
            $tenant = Tenants::find($unit->occupied_by);

            if ($tenant) {
                $currentMonth = now()->month;
                $currentYear = now()->year;


                $invoice = new Invoices();
                $invoice->tenant_id = $tenant->id;
                $invoice->unit_id = $unit->id;
                $invoice->amount = 0;
                $invoice->invoice_month = $currentMonth;
                $invoice->invoice_year = $currentYear;
                $invoice->save();

                $totalAmount = $unit->rentAmount;
                $this->createInvoiceItem($invoice, 'Rent', $unit->rentAmount);

                foreach ($unit->unit_utilities as $unitUtility) {
                    $utility = $unitUtility->utility;
                    if ($utility && $utility->status === 1) {
                        $this->createInvoiceItem($invoice, $utility->name, $utility->price);
                        $totalAmount += $utility->price;
                    }
                }

                // Update the total amount in the invoice
                $invoice->amount = $totalAmount;
                $invoice->save();

                $this->info("Invoice for tenant {$tenant->firstName} generated for unit {$unit->name} with total amount: {$totalAmount}");
            }
        }

        $this->info('Invoices generated successfully!');
    }

    /**
     * Helper function to create an invoice item
     *
     * @param Invoice $invoice
     * @param string $description
     * @param float $amount
     * @return void
     */
    private function createInvoiceItem(Invoices $invoice, $description, $amount)
    {
        $currentMonth = now()->month; // e.g., 10 for October
        $currentYear = now()->year;

        $invoiceItem = new InvoiceItem();
        $invoiceItem->invoices_id = $invoice->id;
        $invoiceItem->description = $description;
        $invoiceItem->amount = $amount;
        $invoiceItem->save();
    }
}
