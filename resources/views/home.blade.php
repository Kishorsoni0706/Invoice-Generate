@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Welcome, {{ Auth::user()->name }}</h1>
                </div>
                
                <div class="content-section">
                    <h2>Your Invoices</h2>
                    
                    <a href="{{ route('invoices.index') }}" class="btn btn-primary">
                        View Invoices
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
