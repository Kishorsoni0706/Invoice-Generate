<?php

namespace App\Jobs;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateInvoices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $today = Carbon::now();
        $users = \App\Models\User::all();
    
        foreach ($users as $user) {
            $invoices = $user->invoices()->where('status', 'Partially Paid')->get();
            foreach ($invoices as $invoice) {
                if ($invoice->due_date < $today) {
                    $late_fee = 10;
                    $interest = $invoice->remaining_balance * 0.10;
    
                    $new_invoice = new Invoice();
                    $new_invoice->user_id = $user->id;
                    $new_invoice->invoice_number = rand(100000, 999999);
                    $new_invoice->total_amount = $invoice->remaining_balance + $late_fee + $interest;
                    $new_invoice->amount_paid = 0;
                    $new_invoice->remaining_balance = $new_invoice->total_amount;
                    $new_invoice->due_date = $today->addDays(30); // new due date
                    $new_invoice->status = 'Unpaid';
                    $new_invoice->save();
                }
            }
        }
    }
    
}
