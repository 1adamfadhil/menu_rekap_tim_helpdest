<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'user_id',
        'agent_id',
        'category_id',
        'title',
        'description',
        'priority',
        'status',
        'attachment',
    ];

    // User yang membuat ticket
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Agent yang menangani ticket
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    // Category dari ticket
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Semua komentar pada ticket
    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class);
    }
}