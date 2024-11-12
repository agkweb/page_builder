<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static latest()
 * @method static create(array $existedData)
 * @method static whereHas(string $string, \Closure $param)
 * @method static where(string $string, mixed $id)
 */
class Registration extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'registrations';

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
