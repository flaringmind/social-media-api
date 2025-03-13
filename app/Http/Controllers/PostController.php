<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\LikedPost;
use App\Models\Post;
use App\Services\PostService;
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


        $likedPostIds = LikedPost::where('user_id', auth()->id())
            ->pluck('post_id')->toArray();
        foreach ($posts as $post) {
            if (in_array($post->id, $likedPostIds)) {
                $post->isLiked = true;
            }
        }


        return PostResource::collection($posts);
    }

    public function store(StoreRequest $request): PostResource
    {
        return $this->postService->storePost($request);
    }

    public function toggleLike(Post $post): array
    {
        $res = auth()->user()->likedPosts()->toggle($post->id);
        $data['is_liked'] = count($res['attached']) > 0;

        return $data;
    }

}
