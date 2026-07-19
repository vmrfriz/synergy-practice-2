<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Пользователь
 *
 * @property int $id
 * @property boolean $admin
 * @property string $name
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property bool $subscribed
 *
 * @property Collection<int,User> $subscriptions
 * @property Collection<int,Post> $posts
 * @property Collection<int,Comment> $comments
 */
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $attributes = [
        'admin' => false,
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'admin' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** @return BelongsToMany<User, User, Subscription> */
    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, Subscription::class, 'subscriber_id', 'target_id');
    }

    /** @return HasMany<Post, User> */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id')->latest();
    }

    /** @return HasManyThrough<Post, Subscription, User> */
    public function feed(): HasManyThrough
    {
        return $this->hasManyThrough(
            Post::class,
            Subscription::class,
            'subscriber_id',
            'author_id',
            'id',
            'target_id'
        )->latest();
    }

    /** @return HasMany<Comment, User> */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    public function getSubscribedAttribute(): bool
    {
        return Subscription::subscribed(auth()->id(), $this->id);
    }
}
