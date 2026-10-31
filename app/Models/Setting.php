<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * The Back to Us offer as set in Admin → Offer, falling back to config/site.php.
     *
     * @return array{label: string, price: int, spots_total: ?int, spots_left: ?int, note_title: ?string, note: ?string}
     */
    public static function offer(): array
    {
        $saved = static::where('key', 'like', 'offer.%')->pluck('value', 'key');

        $offer = collect(config('site.offer'))
            ->map(fn ($default, $name) => $saved->has("offer.{$name}") ? $saved["offer.{$name}"] : $default)
            ->all();

        foreach (['price', 'spots_total', 'spots_left'] as $number) {
            $offer[$number] = filled($offer[$number]) ? (int) $offer[$number] : null;
        }

        return $offer;
    }

    /**
     * @param  array<string, mixed>  $values
     */
    public static function saveOffer(array $values): void
    {
        foreach ($values as $name => $value) {
            static::updateOrCreate(['key' => "offer.{$name}"], ['value' => $value]);
        }
    }
}
