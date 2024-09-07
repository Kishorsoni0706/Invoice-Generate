@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Invoice #{{ $invoice->invoice_number }}</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Total Amount:</strong> ${{ number_format($invoice->total_amount, 2) }}</p>
                        <p><strong>Amount Paid:</strong> ${{ number_format($invoice->amount_paid, 2) }}</p>
                        <p><strong>Remaining Balance:</strong> ${{ number_format($invoice->remaining_balance, 2) }}</p>
                        <p><strong>Status:</strong> {{ $invoice->status }}</p>
                        <p><strong>Due Date:</strong> {{ $invoice->due_date->toDateString() }}</p>

                        <form action="{{ route('invoices.pay', $invoice) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="amount">Amount to Pay</label>
                                <input type="number" id="amount" name="amount" step="0.01" max="{{ $invoice->remaining_balance }}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="payment_mode">Payment Mode</label>
                                <select id="payment_mode" name="payment_mode" class="form-control">
                                    <option value="online">Online</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div></br>
                            <button type="submit" class="btn btn-primary">Pay</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
