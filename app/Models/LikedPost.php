<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LikedPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LikedPost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LikedPost query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LikedPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LikedPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LikedPost wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LikedPost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LikedPost whereUserId($value)
 * @mixin \Eloquent
 */
class LikedPost extends Model
{
    protected $guarded = [];
}
