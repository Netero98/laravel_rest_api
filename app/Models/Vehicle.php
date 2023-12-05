<?php

declare(strict_types=1);

namespace App\Models;

use App\ColorEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User $user
 */
final class Vehicle extends Model
{
    use HasFactory;
    use HasUuids;

    public const PROP_VEHICLE_MODEL_ID = 'vehicle_model_id';
    public const PROP_YEAR ='year';
    public const PROP_MILEAGE_KM = 'mileage_km';
    public const PROP_COLOR ='color';
    public const PROP_USER_ID = 'user_id';

    protected $fillable = [
        self::PROP_VEHICLE_MODEL_ID,
        self::PROP_YEAR,
        self::PROP_MILEAGE_KM,
        self::PROP_COLOR,
        self::PROP_USER_ID,
    ];

    protected $casts = [
        self::PROP_COLOR => ColorEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
