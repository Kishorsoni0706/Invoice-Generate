<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('invoice_number')->unique(); // 6-digit invoice number
            $table->decimal('total_amount', 8, 2); // Total amount
            $table->decimal('amount_paid', 8, 2)->default(0); // Amount already paid
            $table->decimal('remaining_balance', 8, 2); // Remaining balance
            $table->date('due_date'); // Due date
            $table->enum('status', ['Unpaid', 'Partially Paid', 'Paid'])->default('Unpaid'); // Invoice status
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
