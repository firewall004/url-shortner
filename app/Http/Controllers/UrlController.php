<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Services\UrlShortenerService;
use Illuminate\Http\JsonResponse;
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

    public function shortenUrl(Request $request): JsonResponse
    {
        $request->validate([
            'original_url' => 'required|url|max:1000',
        ]);

        try {
            $url = $this->urlShortenerService->shortenUrl($request->input('original_url'));

            return response()->json(['data' => $url], 201);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    public function getUserUrls(): JsonResponse
    {
        try {
            $user = Auth::user();
            $userUrls = Url::where('user_id', $user->id)->get();
            return response()->json(['data' => $userUrls]);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    public function deleteUrl($id): JsonResponse
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

    public function updateUrl(Request $request, $id): JsonResponse
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

    public function toggleStatus($id): JsonResponse
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
