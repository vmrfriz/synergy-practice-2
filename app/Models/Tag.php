<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property string $ulid
 * @property string $name
 *
 * @property Collection<int,Post> $posts
 */
#[Fillable(['name'])]
#[Table(timestamps: false)]
class Tag extends Model
{
    use HasUuids;

    protected $primaryKey = 'ulid';
    protected $keyType = 'string';
    public $incrementing = false;

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag', 'tag_ulid', 'post_ulid');
    }
}
