<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'message',
        'user_id',
        'email',
        'inquiry_id',
        'is_read',
        'data'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'data' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiries::class, 'inquiry_id');
    }

    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForUser($query, $user)
    {
        return $query->where(function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('email', $user->email);
        });
    }

    public function scopeForAdmin($query)
    {
        return $query->whereNull('user_id')->whereNull('email');
    }
}
