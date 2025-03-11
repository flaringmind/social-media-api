<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller
{
    public function index(): ResourceCollection
    {
        $users = User::whereNot('id', auth()->id())->get();
        return UserResource::collection($users);
    }

    public function posts(User $user): ResourceCollection
    {
        return PostResource::collection($user->posts)
            ->additional(['user_name' => $user->name]);
    }
}
