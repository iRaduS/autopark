<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'action', 'ip_address', 'type'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function createLog($user_id, $action, $ip_address, $type) {
        return self::create(['user_id' => $user_id, 'action' => $action, 'ip_address' => $ip_address, 'type' => $type]);
    }
}
