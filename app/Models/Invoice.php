<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'invoice_number', 'total_amount', 'amount_paid', 'remaining_balance', 'due_date', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
  {
    return $this->hasMany(Transaction::class); // Adjust according to your actual relationship
  }

}


