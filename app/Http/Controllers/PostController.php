<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService,
    )
    {
    }

    public function index(): ResourceCollection
    {
        $posts = Post::where('user_id', auth()->id())->latest()->get();
        return PostResource::collection($posts);
    }

    public function store(StoreRequest $request): PostResource
    {
        return $this->postService->storePost($request);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
