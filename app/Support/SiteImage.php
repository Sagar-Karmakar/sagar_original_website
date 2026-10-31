<?php

namespace App\Support;

/**
 * Photos the site picks up from public/images by name (home-hero.jpg, coach.webp…),
 * so a new photo needs no code change. README → Photos lists the names.
 */
class SiteImage
{
    private const EXTENSIONS = ['webp', 'jpg', 'jpeg', 'png'];

    /**
     * The URL of public/images/{name}.*, versioned so a replaced photo shows straight away; null if there's none yet.
     */
    public static function url(string $name): ?string
    {
        foreach (self::EXTENSIONS as $extension) {
            $path = public_path("images/{$name}.{$extension}");

            if (is_file($path)) {
                return asset("images/{$name}.{$extension}").'?v='.filemtime($path);
            }
        }

        return null;
    }
}
