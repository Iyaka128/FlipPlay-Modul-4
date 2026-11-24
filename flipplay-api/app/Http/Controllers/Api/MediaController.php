<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class MediaController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Media::query()->with('users');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . (string) $request->input('search') . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', (string) $request->input('type'));
        }

        return MediaResource::collection(
            $query->latest()->paginate(12)->withQueryString()
        );
    }

    public function store(StoreMediaRequest $request): JsonResponse
    {
        $media = Media::create($request->validated());

        return (new MediaResource($media))->response()->setStatusCode(201);
    }

    public function show(Media $media): MediaResource
    {
        return new MediaResource($media->load('users'));
    }

    public function update(UpdateMediaRequest $request, Media $media): MediaResource
    {
        $media->update($request->validated());

        return new MediaResource($media->load('users'));
    }

    public function destroy(Media $media)
    {
        $media->delete();

        return response()->noContent();
    }
}
