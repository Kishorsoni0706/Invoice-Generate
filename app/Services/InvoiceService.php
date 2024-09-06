<?php

namespace App\Services;

use App\Models\Invoice;
use Carbon\Carbon;

class InvoiceService
{
    public function generatePendingInvoices()
    {
        // Retrieve all unpaid invoices that are overdue
        $overdueInvoices = Invoice::where('status', 'Unpaid')
                                  ->where('due_date', '<', Carbon::now())
                                  ->get();

        foreach ($overdueInvoices as $invoice) {
            $this->applyLateFeesAndInterest($invoice);
        }

        // Generate a new invoice example (you can customize as needed)
        $this->createNewInvoice();
    }

    protected function applyLateFeesAndInterest(Invoice $invoice)
    {
        $lateFee = 10;
        $interest = $invoice->remaining_balance * 0.10;

        $invoice->total_amount = $invoice->remaining_balance + $lateFee + $interest;
        $invoice->remaining_balance = $invoice->total_amount;
        $invoice->due_date = Carbon::now()->addMonth(); // Set new due date
        $invoice->save();
    }

    protected function createNewInvoice()
    {
        $invoice = new Invoice();
        $invoice->invoice_number = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT); // Generate 6-digit invoice number
        $invoice->total_amount = 250.50; // Default amount; adjust if needed
        $invoice->remaining_balance = $invoice->total_amount;
        $invoice->due_date = Carbon::now()->addMonth(); // Set due date
        $invoice->status = 'Unpaid';
        $invoice->save();
    }
}
