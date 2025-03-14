<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use App\Models\SubscriberFollowing;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function index(): ResourceCollection
    {
        $users = $this->userService->listUsers();

        return UserResource::collection($users);
    }

    public function toggleFollowing(User $user): array
    {
        $res = auth()->user()->followings()->toggle($user->id);
        $data['is_followed'] = count($res['attached']) > 0;

        return $data;
    }

    public function getStats(User $user)
    {
        $result = $this->userService->getStats($user);

        return response()->json(['data' => $result]);
    }
}
