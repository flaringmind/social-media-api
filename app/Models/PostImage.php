<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 *
 *
 * @property int $id
 * @property string $path
 * @property int|null $post_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostImage wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostImage wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostImage whereUserId($value)
 * @mixin \Eloquent
 */
class PostImage extends Model
{
    protected $guarded = [];

    public function getUrlAttribute(): string
    {
        return url('storage/' . $this->path);
    }

    public static function clearStorage(): void
    {
        $images = PostImage::where('user_id', auth()->id())
            ->whereNull('post_id')->get();

        foreach ($images as $image) {
            if ($image->path) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }
    }
}
