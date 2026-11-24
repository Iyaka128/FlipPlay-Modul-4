<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollectionResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class CollectionController extends Controller
{
    public function index(User $user): UserCollectionResource
    {
        return new UserCollectionResource($user->load('media'));
    }

    public function store(User $user, Media $media): JsonResponse
    {
        if ($user->media()->whereKey($media->id)->exists()) {
            return response()->json([
                'message' => 'Media sudah ada di koleksi pengguna.',
            ], 409);
        }

        $user->media()->attach($media->id);

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi.',
            'user_id' => $user->id,
            'media_id' => $media->id,
        ], 201);
    }

    public function destroy(User $user, Media $media): JsonResponse
    {
        if (! $user->media()->whereKey($media->id)->exists()) {
            return response()->json([
                'message' => 'Media tidak ditemukan di koleksi pengguna.',
            ], 404);
        }

        $user->media()->detach($media->id);

        return response()->json([
            'message' => 'Media berhasil dihapus dari koleksi.',
            'user_id' => $user->id,
            'media_id' => $media->id,
        ]);
    }
}
