<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiries extends Model
{
    /** @use HasFactory<\Database\Factories\InquiriesFactory> */
    use HasFactory;

    protected $fillable =[
        "name",
        "email",
        "phone",
        "message",
        "plot_id",
        "status",
        "admin_response"
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function plot() : BelongsTo {
        return $this->belongsTo(Plot::class);
    }
}
