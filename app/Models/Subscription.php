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
    // protected $primaryKey = null;
    protected $table = 'subscriptions';
    public $incrementing = false;
}
