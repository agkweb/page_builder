<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    protected static function boot(): void
    {
        parent::boot();
        static::deleting(function ($question){
            foreach ($question->answers as $answer){
                $answer->delete();
            }
        });
        static::restoring(function ($question){
            foreach ($question->answers as $answer){
                $answer->restore();
            }
        });
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }
}
