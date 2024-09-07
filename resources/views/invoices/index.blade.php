@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Invoices</h1>
                
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Invoice Number</th>
                                <th>Total Amount</th>
                                <th>Amount Paid</th>
                                <th>Remaining Balance</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>${{ number_format($invoice->total_amount, 2) }}</td>
                                    <td>${{ number_format($invoice->amount_paid, 2) }}</td>
                                    <td>${{ number_format($invoice->remaining_balance, 2) }}</td>
                                    <td>{{ $invoice->status }}</td>
                                    <td>{{ $invoice->due_date->format('Y-m-d') }}</td>
                                    <td> <a href="{{ route('invoices.show', $invoice->id)}}" class="btn btn-success btn-sm">View</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
