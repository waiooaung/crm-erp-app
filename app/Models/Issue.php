<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $asset_id
 * @property int $user_id
 * @property string $description
 * @property string|null $classification
 * @property string $priority
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Asset $asset
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Issue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Issue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Issue query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Issue whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Issue whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Issue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Issue whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Issue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Issue wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Issue whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Issue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Issue whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @mixin \Eloquent
 */
class Issue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['asset_id', 'user_id', 'description', 'classification', 'priority', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'entity_id')->where('entity', 'issue');
    }

    public $tempChanges = [];

    protected static function booted()
    {
        static::created(function ($issue) {
            $issue->logActivity('CREATED');
        });

        static::updating(function ($issue) {
            $changes = [];
            foreach ($issue->getDirty() as $key => $value) {
                if ($key === 'updated_at') {
                    continue;
                }

                $changes[$key] = [
                    'from' => $issue->getOriginal($key),
                    'to' => $value,
                ];
            }
            $issue->tempChanges = $changes;
        });

        static::updated(function ($issue) {
            if (!empty($issue->tempChanges)) {
                $issue->logActivity('UPDATED', $issue->tempChanges);
            }
        });
    }

    public function logActivity(string $action, array $changes = null)
    {
        Activity::create([
            'user_id' => auth()->id(),
            'entity' => strtolower(class_basename($this)),
            'entity_id' => $this->id,
            'action' => $action,
            'changes' => $changes ? json_encode($changes) : null,
        ]);
    }
}
