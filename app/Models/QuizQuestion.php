<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 */
class QuizQuestion extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = "quiz_questions";

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
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
                foreach ($question->answers as $answer){
                    $answer->restore();
                }
            }
        });
    }
}