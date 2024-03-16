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

        if ($user->shortenedUrls()->count() >= $user->shorten_limit) {
            throw new Exception('You have already shortened the maximum number of URLs.', 403);
        }

        $url = Url::where('original_url', $originalUrl)->first();
        $shortenedUrl = $this->generateShortenedUrl();

        if ($url) {
            if ($url->trashed()) {
                $url->restore();
            }

            return Url::where('id', $url->id)
                ->update([
                    'shortened_url' => $shortenedUrl,
                ]);
        }

        return Url::create([
            'user_id' => $user->id,
            'original_url' => $originalUrl,
            'shortened_url' => $shortenedUrl,
        ]);
    }

    public function updateShortenUrl(int $id, string $originalUrl): Url
    {
        $url = Url::findOrFail($id);
        $url->update([
            'original_url' => $originalUrl,
            'shortened_url' => $this->generateShortenedUrl()
        ]);

        return $url;
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

        return 'short/' . $shortenedUrl;
    }
}
