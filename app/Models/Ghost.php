<?php

namespace App\Models;

use App\Models\Ghost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ghost extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'card_front',
        'card_back',
        'rsvp_id',
    ];

    public function rsvp()
    {
        return $this->belongsTo(Rsvp::class);
    }
}
