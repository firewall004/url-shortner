<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\User;
use App\Services\UrlShortenerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

            return response()->json(['data' => $url], 201);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    public function getUserUrls()
    {
        try {
            /** @var User $user */
            $user = Auth::user();
            $urls = $user->shortenedUrls()->get();
            return response()->json(['data' => $urls]);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    public function deleteUrl($id)
    {
        try {
            $url = Url::findOrFail($id);
            $url->delete();
            return response()->json(['message' => 'URL deleted successfully']);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    public function updateUrl(Request $request, $id)
    {
        $request->validate([
            'original_url' => 'required|url|max:255',
        ]);

        try {
            $url = $this->urlShortenerService->updateShortenUrl(
                $id,
                $request->input('original_url')
            );

            return response()->json(['data' => $url], 201);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    public function toggleStatus($id)
    {
        $url = Url::findOrFail($id);
        $url->status = !boolval($url->status);
        $url->save();

        return response()->json(
            [
                'message' => 'URL status updated successfully',
                'data' => $url
            ],
            200
        );
    }

    public function redirectToOriginalUrl(Request $request)
    {
        $shortenedUrl = $request->path();
        $path = parse_url($shortenedUrl, PHP_URL_PATH);
        $path = ltrim($path, '/');

        $url = Url::where('shortened_url', $path)
            ->where('deleted_at', null)
            ->where('status', Url::ACTIVE)
            ->first();

        if ($url) {
            return redirect()->away($url->original_url);
        }

        abort(404, 'URL not found');
    }
}
