<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, string $string)
 * @method static latest()
 * @method static create(array $existedData)
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
}
