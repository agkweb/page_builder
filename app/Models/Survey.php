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
 * @method static where(string $string, string $string1, string $string2)
 */
class Survey extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    protected $guarded = [];
    protected $table = "surveys";

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
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
                foreach ($question->answers as $answer){
                    $answer->restore();
                }
            }
        });
    }
}
