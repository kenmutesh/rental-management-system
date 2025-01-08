<?php

namespace App\Console\Commands;

use App\Models\InvoiceItem;
use App\Models\Invoices;
use App\Models\Property;
use App\Models\TenantAccounts;
use App\Models\Tenants;
use App\Models\Units;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        $properties = Property::all();

        foreach ($properties as $property) {
            if ($property->invoicingDay == 1) {
                $units = Units::where('property_id', $property->id)
                    ->whereNotNull('occupied_by')
                    ->get();

                foreach ($units as $unit) {
                    $tenant = Tenants::find($unit->occupied_by);

                    if ($tenant) {
                        $tenantAccount = TenantAccounts::where('account_number', $tenant->account_number)->first();
                        $tenantBalance = $tenantAccount ? $tenantAccount->balance : 0;

                        // Clear outstanding invoices with balance
                        $this->clearOutstandingInvoices($tenant, $tenantBalance);

                        // Re-fetch the balance in case it's modified by clearing outstanding invoices
                        $tenantAccount->refresh();
                        $tenantBalance = $tenantAccount->balance;

                        $currentMonth = now()->month;
                        $currentYear = now()->year;

                        // Create new invoice
                        $invoice = new Invoices();
                        $invoice->tenant_id = $tenant->id;
                        $invoice->unit_id = $unit->id;
                        $invoice->amount = 0;
                        $invoice->invoice_month = $currentMonth;
                        $invoice->invoice_year = $currentYear;
                        $invoice->amount_paid = 0; // Set to 0 by default
                        $invoice->save();

                        // Calculate total amount starting with rent
                        $totalAmount = $unit->rentAmount;
                        $this->createInvoiceItem($invoice, 'Rent', $unit->rentAmount);

                        // Add utility charges
                        foreach ($unit->unit_utilities as $unitUtility) {
                            $utility = $unitUtility->utility;
                            if ($utility && $utility->status === 1) {
                                $this->createInvoiceItem($invoice, $utility->name, $utility->price);
                                $totalAmount += $utility->price;
                            }
                        }

                        // Deduct remaining balance if any and apply it to amount_paid
                        if ($tenantBalance > 0) {
                            $amountToPay = min($totalAmount, $tenantBalance);
                            $invoice->amount_paid = $amountToPay;
                            $tenantBalance -= $amountToPay;

                            // Update tenant balance in TenantAccounts
                            $tenantAccount->balance = $tenantBalance;
                            $tenantAccount->save();
                        }

                        // Update total amount in the invoice
                        $invoice->amount = $totalAmount;
                        $invoice->save();

                        $this->info("Invoice for tenant {$tenant->firstName} generated for unit {$unit->name} with total amount: {$totalAmount}");
                    }
                }
            }
        }

        $this->info('Invoices generated successfully!');
    }


    /**
     * Clear outstanding invoices with tenant's available balance.
     *
     * @param Tenants $tenant
     * @param float $tenantBalance
     * @return void
     */
    private function clearOutstandingInvoices(Tenants $tenant, $tenantBalance)
    {
        Log::info("Clearing outstanding invoices");

        $outstandingInvoices = Invoices::where('tenant_id', $tenant->id)
            ->whereColumn('amount', '>', 'amount_paid')
            ->orderBy('created_at', 'asc')
            ->get();

        Log::info($tenantBalance);

        foreach ($outstandingInvoices as $invoice) {
            if ($tenantBalance <= 0) break;

            $remainingAmount = $invoice->amount - $invoice->amount_paid;

            $payment = min($remainingAmount, $tenantBalance);
            $invoice->amount_paid += $payment;
            $tenantBalance -= $payment;

            $invoice->save();

            $tenantAccount = TenantAccounts::where('account_number', $tenant->account_number)->first();
            if ($tenantAccount) {
                $tenantAccount->balance = $tenantBalance;
                $tenantAccount->save();
            }
        }
    }

    /**
     * Helper function to create an invoice item.
     *
     * @param Invoices $invoice
     * @param string $description
     * @param float $amount
     * @return void
     */
    private function createInvoiceItem(Invoices $invoice, $description, $amount)
    {
        $invoiceItem = new InvoiceItem();
        $invoiceItem->invoices_id = $invoice->id;
        $invoiceItem->description = $description;
        $invoiceItem->amount = $amount;
        $invoiceItem->save();
    }
}
