<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;

class GenerateInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generate invoices for users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $this->generateInvoiceForUser($user);
        }

        $this->info('Invoices generated successfully.');
    }

    protected function generateInvoiceForUser($user)
    {
        $pendingInvoices = Invoice::where('user_id', $user->id)
                                  ->where('status', 'Unpaid')
                                  ->where('due_date', '<', Carbon::now())
                                  ->get();

        foreach ($pendingInvoices as $invoice) {
            $lateFee = 10;
            $interest = $invoice->remaining_balance * 0.10;
            $newAmount = $invoice->remaining_balance + $lateFee + $interest;

            $invoice->status = 'Unpaid';
            $invoice->total_amount = $newAmount;
            $invoice->remaining_balance = $newAmount;
            $invoice->save();
        }

        $invoice = new Invoice();
        $invoice->user_id = $user->id;
        $invoice->invoice_number = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $invoice->total_amount = 250.50;
        $invoice->remaining_balance = 250.50;
        $invoice->due_date = Carbon::now()->addMonth();
        $invoice->save();
    }
}
