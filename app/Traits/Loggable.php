<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

trait Loggable
{
    public static function bootLoggable()
    {
        static::created(function (Model $model) {
            // Renamed function call
            self::recordActivity($model, 'created', $model->toArray());
        });

        static::updated(function (Model $model) {
            $changes = $model->getChanges();
            unset($changes['updated_at']);

            if (!empty($changes)) {
                // Renamed function call
                self::recordActivity($model, 'updated', $changes);
            }
        });

        static::deleted(function (Model $model) {
            // Renamed function call
            self::recordActivity($model, 'deleted', null);
        });
    }

    // RENAMED FUNCTION: 'recordActivity' instead of 'logActivity'
    // This avoids conflicts with any methods inside Asset.php
    protected static function recordActivity(Model $model, string $action, ?array $changes = null)
    {
        if (!Auth::check()) {
            return;
        }

        Activity::create([
            'user_id' => Auth::id(),
            'entity' => $model::class,
            'entity_id' => $model->getKey(),
            'action' => $action,
            'changes' => $changes,
        ]);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'entity_id')->where('entity', static::class)->latest();
    }
}
