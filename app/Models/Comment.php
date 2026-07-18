<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Комментарий к записи блога
 *
 * @property string $ulid
 * @property int $author_id
 * @property string $content
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property User $author
 */
#[Fillable(['content'])]
class Comment extends Model
{
    public function author(): HasMany
    {
        return $this->hasMany(User::class, 'author_id');
    }
}
