<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserDetail(): JsonResponse
    {
        return response()->json(['data' => Auth::user()], 200);
    }

    public function upgradePlan(Request $request): JsonResponse
    {
        $request->validate([
            'shortenLimit' => 'required|integer|between:0,1000'
        ]);

        /** @var User $user */
        $user = auth()->user();

        $shortenLimit = $request->input('shortenLimit');
        $user->update(['shorten_limit' => $shortenLimit]);

        return response()->json(['message' => 'Plan upgraded successfully', 'data' => $user]);
    }
}
