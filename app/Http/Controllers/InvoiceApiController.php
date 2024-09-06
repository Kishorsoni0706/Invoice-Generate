<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceApiController extends Controller
{
    public function index()
    {
        // Fetch the authenticated user
        $user = Auth::user();

        // Retrieve invoices for the authenticated user
        $invoices = $user->invoices()->with('transactions')->get(); // Assuming a 'transactions' relationship exists

        // Transform invoices and their transactions
        $data = $invoices->map(function ($invoice) {
            return [
                'invoice_number' => $invoice->invoice_number,
                'total_amount' => $invoice->total_amount,
                'amount_paid' => $invoice->amount_paid,
                'remaining_balance' => $invoice->remaining_balance,
                'status' => $invoice->status,
                'due_date' => $invoice->due_date->toDateString(),
                'transactions' => $invoice->transactions->map(function ($transaction) {
                    return [
                        'id' => $transaction->id,
                        'amount' => $transaction->amount,
                        'created_at' => $transaction->created_at->toDateString(),
                    ];
                }),
            ];
        });

        return response()->json($data);
    }
}

