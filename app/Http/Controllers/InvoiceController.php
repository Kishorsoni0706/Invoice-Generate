<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InvoiceController extends Controller
{
public function index()
{
    // Fetch invoices for the authenticated user
    $invoices = auth()->user()->invoices;

    // Convert the due_date to a Carbon instance for each invoice
    $invoices = $invoices->map(function ($invoice) {
        // Check if due_date is not already a Carbon instance and convert if necessary
        $invoice->due_date = Carbon::parse($invoice->due_date);
        return $invoice;
    });
    return view('invoices.index', compact('invoices'));
}

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->due_date = Carbon::parse($invoice->due_date);
       return view('invoices.show', compact('invoice'));
    }

    public function pay(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $paymentAmount = $request->input('amount');

        if ($paymentAmount > $invoice->remaining_balance) {
            return back()->withErrors('Payment amount exceeds the remaining balance.');
        }

        $invoice->amount_paid += $paymentAmount;
        $invoice->remaining_balance -= $paymentAmount;
        $invoice->status = $invoice->remaining_balance == 0 ? 'Paid' : 'Partially Paid';
        $invoice->save();

        Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $paymentAmount,
            'payment_mode' => $request->input('payment_mode'),
        ]);

        return redirect()->route('invoices.index')->with('success', 'Payment processed successfully.');
    }
}
