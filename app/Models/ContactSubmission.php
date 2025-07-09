<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'message',
        'email_sent',
        'email_error'
    ];

    protected $casts = [
        'email_sent' => 'boolean',
    ];
}
