<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 */
class SurveyUser extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = "survey_users";

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}
