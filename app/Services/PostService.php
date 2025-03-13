<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function storePost(StoreRequest $request): PostResource
    {
        $data = $request->only(['title', 'content']);
        $data['user_id'] = auth()->id();

        try {
            DB::beginTransaction();
            $post = Post::create($data);
            if ($request->image_id) {
                $this->changePostImageStatus($request->image_id, $post->id);
            }
            PostImage::clearStorage();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            response()->json(['error' => $exception], 500);
        }

        return new PostResource($post);
    }

    private function changePostImageStatus(int $imageId, int $postId): void
    {
        PostImage::whereId($imageId)
            ->update(['post_id' => $postId]);
    }


    private function mapPostsLikedByUser(Collection $posts): Collection
    {
        $likedPostIds = LikedPost::where('user_id', auth()->id())
            ->pluck('post_id')->toArray();
        foreach ($posts as $post) {
            if (in_array($post->id, $likedPostIds)) {
                $post->isLiked = true;
            }
        }
        return $posts;
    }

    public function listMyPosts(): Collection
    {
        $posts = Post::where('user_id', auth()->id())->latest()->get();
        return $mappedPosts = $this->mapPostsLikedByUser($posts);
    }

    public function listCurrentUserPosts(User $user): Collection
    {
        $posts = $user->posts()->latest()->get();
        return $mappedPosts = $this->mapPostsLikedByUser($posts);
    }

    public function listFollowingPosts(): Collection
    {
        $followedIds = auth()->user()->followings()->get()->pluck('id')->toArray();
        $likedPostIds = LikedPost::where('user_id', auth()->id())
            ->pluck('post_id')->toArray();
        return Post::whereIn('user_id', $followedIds)
            ->whereNotIn('id', $likedPostIds)->latest()->get();
    }

}
