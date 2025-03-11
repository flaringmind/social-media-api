<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $subscriber_id
 * @property int $following_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriberFollowing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriberFollowing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriberFollowing query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriberFollowing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriberFollowing whereFollowingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriberFollowing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriberFollowing whereSubscriberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriberFollowing whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubscriberFollowing extends Model
{
    protected $guarded = [];
}
