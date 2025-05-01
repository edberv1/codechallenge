<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'category', 'venue_id', 'created_by', 'start_time', 'end_time'
    ];


    public function venue() {
        return $this->belongsTo(Venue::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function admin() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
