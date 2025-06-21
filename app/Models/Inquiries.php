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
        "plote_id"
        
    ];

    public function users() : BelongsTo {
        return $this->belongsTo(User::class);        
    }
}
