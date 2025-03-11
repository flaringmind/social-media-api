<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PostImage\StoreRequest;
use App\Http\Resources\PostImage\PostImageResource;
use App\Models\PostImage;
use Illuminate\Support\Facades\Storage;

class PostImageController extends Controller
{
    public function store(StoreRequest $request): PostImageResource
    {
        $path = Storage::disk('public')->put('/images', $request->image);
        $postImage = PostImage::create([
            'path' => $path,
            'user_id' => auth()->id(),
        ]);
        return new PostImageResource($postImage) ;
    }
}
