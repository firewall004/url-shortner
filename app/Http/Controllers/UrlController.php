<?php

namespace App\Http\Controllers;

use App\Services\UrlShortenerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UrlController extends Controller
{
    protected $urlShortenerService;

    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->urlShortenerService = $urlShortenerService;
    }

    public function shortenUrl(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url|max:255',
        ]);

        try {
            $url = $this->urlShortenerService->shortenUrl($request->input('original_url'));
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['data' => $url], 201);
    }

    public function getUserUrls()
    {
        /** @var User $user */
        $user = Auth::user();
        $urls = $user->shortenedUrls()->get();
        return response()->json(['data' => $urls]);
    }
}
