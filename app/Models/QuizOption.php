<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 */
class QuizOption extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = "quiz_questions";

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
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
