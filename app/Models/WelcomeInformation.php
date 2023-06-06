<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

    public static function cacheInvalidateFirstEntry(): bool
    {
        return Cache::forget('welcome-page-informations');
    }

    public function removeMessageFromEntry(string $message): bool
    {
        $messages = $this->messages ?? [];
        if (($key = array_search($message, $messages)) !== false) {
            unset($messages[$key]);
        }

        $this->messages = $messages;
        return $this->save();
    }
}
