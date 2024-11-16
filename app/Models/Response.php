<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $string, $id)
 */
class Response extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = "responses";

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}
