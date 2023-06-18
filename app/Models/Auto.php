<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasFactory;

    protected $table = 'automobiles';
    protected $fillable = ['type', 'registration_number', 'date_itp_begin', 'date_itp_end', 'date_insurance_begin', 'date_insurance_end', 'files'];
    protected $casts = [
        'files' => 'array'
    ];
}
