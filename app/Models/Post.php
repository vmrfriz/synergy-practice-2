<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Запись блога
 *
 * @property string $id
 * @property string $slug
 * @property int $author_id
 * @property string $title
 * @property string $content
 * @property boolean $hidden
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property User $author
 * @property Collection<int,Tag> $tags
 */
#[Fillable(['slug', 'title', 'content', 'hidden'])]
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $with = ['author', 'tags'];

    protected $withCount = ['comments'];

    protected static function booted(): void
    {
        static::addGlobalScope('latest', function (Builder $builder) {
            $builder->latest();
        });
    }

    /** @return BelongsTo<User, Post> */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /** @return BelongsToMany<Tag, Post> */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /** @return HasMany<Comment, Post> */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
