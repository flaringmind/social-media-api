<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\Post;
use App\Models\SubscriberFollowing;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller
{
    public function index(): ResourceCollection
    {
        $users = User::whereNot('id', auth()->id())->get();
        $followingIds = SubscriberFollowing::where('subscriber_id', auth()->id())
            ->pluck('following_id')->toArray();
        foreach ($users as $user) {
            if (in_array($user->id, $followingIds)) {
                $user->isFollowed = true;
            }
        }
        return UserResource::collection($users);
    }

    public function followingPost(): ResourceCollection
    {
        $followedIds = auth()->user()->followings()->get()->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $followedIds)->latest()->get();

        return PostResource::collection($posts);
    }

    public function posts(User $user): ResourceCollection
    {
        return PostResource::collection($user->posts)
            ->additional(['user_name' => $user->name]);
    }

    public function toggleFollowing(User $user)
    {
        $res = auth()->user()->followings()->toggle($user->id);
        $data['is_followed'] = count($res['attached']) > 0;

        return $data;
    }
}
