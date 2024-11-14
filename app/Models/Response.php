<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static latest()
 * @method static findOrFail(mixed $page_id)
 */
class Response extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = "responses";

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
