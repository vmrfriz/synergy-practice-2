<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property string $ulid
 * @property int $author_id
 * @property string $text
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property User $author
 */
#[Fillable(['text'])]
class Comment extends Model
{
    use HasUuids;

    protected $primaryKey = 'ulid';

    public function author(): HasMany
    {
        return $this->hasMany(User::class, 'author_id');
    }
}
