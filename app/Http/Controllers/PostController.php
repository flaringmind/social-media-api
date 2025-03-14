<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Post\CommentRequest;
use App\Http\Requests\Post\RepostRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
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
        $posts = $this->postService->listMyPosts();

        return PostResource::collection($posts);
    }

    public function creatorPosts(User $user): ResourceCollection
    {
        $posts = $this->postService->listCurrentUserPosts($user);

        return PostResource::collection($posts)
            ->additional(['user_name' => $user->name]);
    }

    public function followingPosts(): ResourceCollection
    {
        $posts = $this->postService->listFollowingPosts();

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
        $data['likes_count'] = $post->likes()->count();

        return $data;
    }

    public function repost(RepostRequest $request, Post $post): void
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['reposted_id'] = $post->id;
        Post::create($data);
    }

    public function comment(CommentRequest $request, Post $post): CommentResource
    {
        $data = $request->validated();
        $data['post_id'] = $post->id;
        $data['user_id'] = auth()->id();
        $comment = Comment::create($data);
        return new CommentResource($comment);
    }

    public function commentList(Post $post): ResourceCollection
    {
        $comments = $post->comments()->latest()->get();

        return CommentResource::collection($comments);
    }
}
