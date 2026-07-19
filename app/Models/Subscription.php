<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Подписка
 *
 * @property int $subscriber_id Подписчик
 * @property int $target_id Автор
 */
class Subscription extends Pivot
{
    protected $table = 'subscriptions';
    public $incrementing = false;

    /**
     * Проверка наличия подписки
     * @param int $subscriber_id
     * @param int $target_id
     * @return bool
     */
    public static function subscribed(int $subscriber_id, int $target_id): bool
    {
        return self::query()
            ->where(compact('subscriber_id', 'target_id'))
            ->exists();
    }
}
