<?php

namespace App\Models;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Comment.
 *
 * @property int                             $id
 * @property string                          $comment
 * @property int                             $post_id
 * @property int                             $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null                        $parent_id
 * @property-read EloquentCollection<int, Comment> $comments
 * @property-read int|null $comments_count
 * @property-read Comment|null $parentComment
 * @property-read Post $post
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 *
 * @mixin Eloquent
 */
class Comment extends Model
{
    protected $fillable = [
        'comment',
        'post_id',
        'user_id',
        'parent_id',
    ];

    // User relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Post relationship
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    // Parent comment relationship
    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Child comments relationship
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Scope for filtering parent comments
    public function scopeParentComments($query)
    {
        return $query->whereNotNull('parent_id')->orderBy('created_at', 'desc');
    }
}
