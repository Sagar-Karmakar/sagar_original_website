<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PushSubscription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'endpoint',
        'public_key',
        'auth_token',
        'content_encoding',
        'user_agent',
    ];

    /**
     * "Chrome on Android", good enough to tell devices apart in the admin.
     */
    public function deviceName(): string
    {
        $agent = (string) $this->user_agent;

        $browser = match (true) {
            Str::contains($agent, 'Edg/') => 'Edge',
            Str::contains($agent, 'Firefox/') => 'Firefox',
            Str::contains($agent, 'SamsungBrowser/') => 'Samsung Internet',
            Str::contains($agent, 'Chrome/') => 'Chrome',
            Str::contains($agent, 'Safari/') => 'Safari',
            default => 'A browser',
        };

        $system = match (true) {
            Str::contains($agent, 'Android') => 'Android',
            Str::contains($agent, ['iPhone', 'iPad']) => 'iPhone',
            Str::contains($agent, 'Windows') => 'Windows',
            Str::contains($agent, 'Mac OS') => 'Mac',
            default => null,
        };

        return $system ? "{$browser} on {$system}" : $browser;
    }
}
