<?php

namespace App\Traits;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Str;
use Carbon\Carbon;

trait InvoicingTrait
{
    /**
     * Create initial invoices for new tenant (deposit + first month rent)
     */
    public function createInitialInvoices(Tenant $tenant): void
    {
        // Create security deposit invoice
        $this->createDepositInvoice($tenant);

        // Create first month's rent invoice
        $this->createFirstMonthRentInvoice($tenant);
    }

    /**
     * Create security deposit invoice
     */
    protected function createDepositInvoice(Tenant $tenant): Invoice
    {
        $invoiceDate = Carbon::parse($tenant->lease_start_date);
        $dueDate = $invoiceDate->copy()->addDays(3);

        $invoice = Invoice::create([
            'tenant_id' => $tenant->id,
            'unit_id' => $tenant->unit_id,
            'invoice_number' => $this->generateInvoiceNumber('deposit'),
            'type' => 'deposit',
            'invoice_date' => $invoiceDate,
            'due_date' => $dueDate,
            'amount' => $tenant->security_deposit,
            'total_amount' => $tenant->security_deposit,
            'balance' => $tenant->security_deposit,
            'status' => 'sent',
            'description' => 'Security deposit for ' . $tenant->unit->name,
            'billing_month' => $invoiceDate->month,
            'billing_year' => $invoiceDate->year,
        ]);

        $this->sendInvoiceNotification($tenant, $invoice, 'deposit');

        return $invoice;
    }

    /**
     * Create first month's rent invoice
     */
    protected function createFirstMonthRentInvoice(Tenant $tenant): Invoice
    {
        $invoiceDate = Carbon::parse($tenant->lease_start_date);
        $dueDate = $invoiceDate->copy()->addDays(5);

        $invoice = Invoice::create([
            'tenant_id' => $tenant->id,
            'unit_id' => $tenant->unit_id,
            'invoice_number' => $this->generateInvoiceNumber('rent'),
            'type' => 'monthly_rent',
            'invoice_date' => $invoiceDate,
            'due_date' => $dueDate,
            'amount' => $tenant->rent_amount,
            'total_amount' => $tenant->rent_amount,
            'balance' => $tenant->rent_amount,
            'status' => 'sent',
            'description' => 'First month rent for ' . $tenant->unit->name,
            'billing_month' => $invoiceDate->month,
            'billing_year' => $invoiceDate->year,
        ]);

        $this->sendInvoiceNotification($tenant, $invoice, 'rent');

        return $invoice;
    }

    /**
     * Generate monthly rent invoice (for recurring billing)
     */
    public function createMonthlyRentInvoice(Tenant $tenant): Invoice
    {
        $now = Carbon::now();
        $dueDate = $now->copy()->addDays(5);

        $invoice = Invoice::create([
            'tenant_id' => $tenant->id,
            'unit_id' => $tenant->unit_id,
            'invoice_number' => $this->generateInvoiceNumber('rent'),
            'type' => 'monthly_rent',
            'invoice_date' => $now,
            'due_date' => $dueDate,
            'amount' => $tenant->rent_amount,
            'total_amount' => $tenant->rent_amount,
            'balance' => $tenant->rent_amount,
            'status' => 'sent',
            'description' => 'Monthly rent for ' . $now->format('F Y') . ' for ' . $tenant->unit->name,
            'billing_month' => $now->month,
            'billing_year' => $now->year,
        ]);

        $this->sendInvoiceNotification($tenant, $invoice, 'rent');

        return $invoice;
    }

    /**
     * Generate unique invoice number
     */
    protected function generateInvoiceNumber(string $type): string
    {
        $prefix = match ($type) {
            'deposit' => 'DEP',
            'monthly_rent' => 'RENT',
            default => 'INV'
        };

        return $prefix . '-' . Str::upper(Str::random(6)) . '-' . now()->format('Ym');
    }

    /**
     * Send invoice notification to tenant
     */
    protected function sendInvoiceNotification(Tenant $tenant, Invoice $invoice, string $type): void
    {
        $message = $this->generateNotificationMessage($tenant, $invoice, $type);

        // Uncomment when ready to implement SMS
        // $this->sendSms($tenant->phone, $message);
    }

    /**
     * Generate SMS notification message
     */
    protected function generateNotificationMessage(Tenant $tenant, Invoice $invoice, string $type): string
    {
        $invoiceType = match ($type) {
            'deposit' => 'Security Deposit Invoice',
            'rent' => 'Rent Invoice',
            default => 'Invoice'
        };

        return sprintf(
            "Hello %s,\nYour %s #%s for %s is ready.\nAmount: KES %s\nDue: %s\nThank you!",
            $tenant->first_name,
            $invoiceType,
            $invoice->invoice_number,
            $invoice->description,
            number_format($invoice->total_amount, 2),
            $invoice->due_date->format('jS M Y')
        );
    }

    /**
     * Send SMS message (to be implemented with your SMS provider)
     */
    protected function sendSms(string $phone, string $message): void
    {
        // Implementation with your SMS provider:
        // Example for AfricasTalking:
        // $sms = new AfricasTalkingSMS();
        // $sms->send([
        //     'to' => $phone,
        //     'message' => $message
        // ]);
    }
}
