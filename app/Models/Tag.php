<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Тэг для записей блога
 *
 * @property string $id
 * @property string $name
 * @property int $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection<int,Post> $posts
 */
#[Fillable(['name'])]
#[Table(timestamps: false)]
class Tag extends Model
{
    use HasFactory;

    /** @return BelongsToMany<Post, Tag> */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /** @return BelongsTo<User, Tag> */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
