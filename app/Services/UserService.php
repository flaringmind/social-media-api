<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SubscriberFollowing;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function listUsers(): Collection
    {
        $users = User::whereNot('id', auth()->id())->get();
        $followingIds = SubscriberFollowing::where('subscriber_id', auth()->id())
            ->pluck('following_id')->toArray();
        foreach ($users as $user) {
            if (in_array($user->id, $followingIds)) {
                $user->isFollowed = true;
            }
        }
        return $users;
    }

}
