<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static latest()
 * @method static findOrFail(mixed $page_id)
 * @method static create(array $array)
 */
class Question extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = "questions";

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}
