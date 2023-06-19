<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartureTicket extends Model
{
    use HasFactory;
    protected $table = 'departure_ticket';
    protected $fillable = [
        'location_id', 'employee_id', 'auto_id', 'passangers', 'create_date'
    ];
    protected $casts = [
        'passangers' => 'array'
    ];
    public function location() {
        return $this->belongsTo(Location::class);
    }
}