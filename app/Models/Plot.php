<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    /** @use HasFactory<\Database\Factories\PlotFactory> */
    use HasFactory;
    
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_plots');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function activeReservation()
    {
        return $this->hasOne(Reservation::class)->where('status', 'active')->latestOfMany();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    protected $fillable = [
        'title',
        'description',
        'price',
        'area_sqm',
        'location',
        'status',
        'is_new_listing',
    ];
    protected $casts = [
        'price' => 'decimal:2',
        'area_sqm' => 'decimal:2',
        'is_new_listing' => 'boolean',
    ];
    protected $attributes = [
        'status' => 'available',
        'is_new_listing' => true,
    ];
}
