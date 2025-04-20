<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'gross_amount',
        'payment_type',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details() {
        return $this->hasMany(TransactionDetail::class);
    }
}
