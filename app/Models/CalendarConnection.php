<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarConnection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'google_email',
        'refresh_token',
        'access_token',
        'access_token_expires_at',
        'calendar_id',
        'last_error',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'refresh_token',
        'access_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'refresh_token' => 'encrypted',
            'access_token' => 'encrypted',
            'access_token_expires_at' => 'immutable_datetime',
        ];
    }
}
