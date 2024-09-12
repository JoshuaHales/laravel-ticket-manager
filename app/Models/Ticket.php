<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    // Fillable fields
    protected $fillable = [
        'subject', 'content', 'user_id', 'status', 'processed_at'
    ];

    // Casts for fields
    protected $casts = [
        'status' => 'boolean',         // Ensure status is treated as a boolean
        'processed_at' => 'datetime',  // Ensure processed_at is treated as a datetime
    ];

    /**
     * Define the relationship between Ticket and User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include open (unprocessed) tickets.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpen($query)
    {
        return $query->where('status', false);
    }

    /**
     * Scope a query to only include closed (processed) tickets.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClosed($query)
    {
        return $query->where('status', true);
    }
}