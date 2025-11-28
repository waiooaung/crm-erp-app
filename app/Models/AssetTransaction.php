<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $asset_id
 * @property int $user_id
 * @property int|null $department_id
 * @property string $action
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Asset $asset
 * @property-read \App\Models\Department|null $department
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssetTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssetTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssetTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssetTransaction whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssetTransaction whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssetTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssetTransaction whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssetTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssetTransaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssetTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssetTransaction whereUserId($value)
 * @mixin \Eloquent
 */
class AssetTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['asset_id', 'user_id', 'department_id', 'action'];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
