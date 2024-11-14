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
 */
class Survey extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = "surveys";

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::deleting(function ($survey){
            foreach ($survey->questions as $question){
                $question->delete();
            }
        });
        static::restoring(function ($survey){
            foreach ($survey->questions as $question){
                $question->restore();
            }
        });
    }
}
