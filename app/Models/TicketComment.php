<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketComment extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'comment',
    ];

    // Ticket yang dikomentari
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    // User yang membuat komentar
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}