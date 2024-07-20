<?php

namespace App\Models;

use App\Models\Ghost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'invitee_name',
        'invitee_code',
        'status',
        'ghost_selection_id',
    ];

    public function ghost()
    {
        return $this->belongsTo(Ghost::class);
    }
}
