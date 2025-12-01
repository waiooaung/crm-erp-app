<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Department;

/**
 * @property int $id
 * @property string $name
 * @property string|null $category
 * @property string|null $serial_number
 * @property string $status
 * @property int|null $assigned_to_user_id
 * @property int|null $assigned_to_department_id
 * @property \Illuminate\Support\Carbon|null $purchase_date
 * @property \Illuminate\Support\Carbon|null $warranty_expiry
 * @property float|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AssetTransaction> $assetTransactions
 * @property-read int|null $asset_transactions_count
 * @property-read \App\Models\Department|null $assignedDepartment
 * @property-read \App\Models\User|null $assignedUser
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereAssignedToDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereAssignedToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset wherePurchaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereWarrantyExpiry($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\File> $files
 * @property-read int|null $files_count
 * @property string|null $summary
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereSummary($value)
 * @mixin \Eloquent
 */
class Asset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'category', 'serial_number', 'status', 'assigned_to_user_id', 'assigned_to_department_id', 'purchase_date', 'warranty_expiry', 'value', 'summary'];

    protected $casts = [
        'purchase_date' => 'datetime',
        'warranty_expiry' => 'datetime',
        'assigned_to_user_id' => 'integer',
        'assigned_to_department_id' => 'integer',
        'value' => 'float',
    ];

    public $tempChanges = [];

    protected static function booted()
    {
        static::created(function ($asset) {
            $asset->logActivity('CREATED');
        });

        static::updating(function ($asset) {
            $changes = [];
            foreach ($asset->getDirty() as $key => $value) {
                if ($key === 'updated_at') continue;

                // Capture Raw Values
                $rawFrom = $asset->getOriginal($key);
                $rawTo   = $value;

                // CONVERT TO READABLE TEXT HERE
                $changes[$key] = [
                    'from' => self::formatChangeValue($key, $rawFrom),
                    'to'   => self::formatChangeValue($key, $rawTo),
                ];
            }
            $asset->tempChanges = $changes;
        });

        static::updated(function ($asset) {
            if (!empty($asset->tempChanges)) {
                $asset->logActivity('UPDATED', $asset->tempChanges);
            }
        });
    }

    /**
     * Helper to convert IDs/Dates to readable text
     */
    private static function formatChangeValue($key, $value)
    {
        if ($value === null) return '—';

        return match ($key) {
            'assigned_to_user_id' => User::find($value)?->name ?? 'Unknown User',
            'assigned_to_department_id' => Department::find($value)?->name ?? 'Unknown Dept',
            'purchase_date', 'warranty_expiry' => Carbon::parse($value)->format('M d, Y'),
            'value' => number_format((float)$value, 2) . ' USD',
            'status' => ucfirst(strtolower($value)),
            default => (string) $value,
        };
    }

    public function logActivity(string $action, ?array $changes = null)
    {
        Activity::create([
            'user_id' => auth()->id(),
            'entity' => strtolower(class_basename($this)),
            'entity_id' => $this->id,
            'action' => $action,
            'changes' => $changes ? json_encode($changes) : null,
        ]);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function assignedDepartment()
    {
        return $this->belongsTo(Department::class, 'assigned_to_department_id');
    }

    public function assetTransactions()
    {
        return $this->hasMany(AssetTransaction::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'entity_id')->where('entity', 'asset');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\File>
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
