<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'amount',
        'created_at',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
