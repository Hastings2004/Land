<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'plot_id',
        'reservation_id',
        'amount',
        'status',
        'transaction_id',
        'provider',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function plot() { return $this->belongsTo(Plot::class); }
    public function reservation() { return $this->belongsTo(Reservation::class); }
}
