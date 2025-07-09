<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlotImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'plot_id',
        'image_path',
        'alt_text',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Get the plot that owns the image.
     */
    public function plot()
    {
        return $this->belongsTo(Plot::class);
    }

    /**
     * Get the full URL for the image.
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}
