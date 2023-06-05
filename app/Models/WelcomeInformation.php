<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class WelcomeInformation extends Model
{
    use HasFactory;

    public $table = 'welcome_informations';

    protected $attributes = ['description', 'image_url', 'messages'];

    protected $casts = ['messages' => 'json'];

    public static function cachedFirstEntry(): WelcomeInformation
    {
        return Cache::rememberForever('welcome-page-informations', fn () => self::first());
    }
}
