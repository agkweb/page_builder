<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static latest()
 * @method static create(array $array)
 */
class Quiz extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    protected $guarded = [];
    protected $table = "quizzes";

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
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
        static::deleting(function ($quiz){
            foreach ($quiz->questions as $question){
                $question->delete();
            }
        });
        static::restoring(function ($quiz){
            foreach ($quiz->questions as $question){
                $question->restore();
                foreach ($question->options as $option){
                    $option->restore();
                }
            }
        });
    }
}
