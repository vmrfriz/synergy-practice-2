<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property string $uild
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
#[Fillable(['title', 'content', 'hidden'])]
class Post extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $primaryKey = 'ulid';
    protected $keyType = 'string';
    public $incrementing = false;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_ulid', 'tag_ulid');
    }

    public function getCanEditAttribute(): bool
    {
        return auth()->check() && auth()->id() === $this->author?->id;
    }

    public function getCanDeleteAttribute(): bool
    {
        return auth()->check() && auth()->id() === $this->author?->id;
    }
}
