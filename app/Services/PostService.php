<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Models\PostImage;
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

    private function changePostImageStatus (int $imageId, int $postId): void
    {
        PostImage::whereId($imageId)
            ->update(['post_id' => $postId]);
    }
}
