<?php

namespace App\Services;

use App\Models\Url;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class UrlShortenerService
{
    public function shortenUrl(string $originalUrl): Url
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->shortenedUrls()->count() >= config('urlshorten.maxLimit')) {
            throw new Exception('You have already shortened the maximum number of URLs.', 403);
        }

        $shortenedUrl = $this->generateShortenedUrl();

        return Url::create([
            'user_id' => $user->id,
            'original_url' => $originalUrl,
            'shortened_url' => $shortenedUrl,
        ]);
    }

    private function generateShortenedUrl(): string
    {

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $shortenedUrl = '';

        for ($i = 0; $i < 8; $i++) {
            $shortenedUrl .= $characters[rand(0, strlen($characters) - 1)];
        }

        $exists = Url::where('shortened_url', $shortenedUrl)->exists();

        if ($exists) {
            return $this->generateShortenedUrl();
        }

        return $shortenedUrl;
    }
}
