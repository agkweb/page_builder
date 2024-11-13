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
 */
class Survey extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    protected $guarded = [];
    protected $table = "surveys";

    public function scopeActive($query): void
    {
        $query->where('is_active', 1);
    }

    public function pages(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
        static::creating(function ($page) {
            $page->slug = SlugService::createSlug($page, 'slug', $page->title);
        });
        static::updating(function ($page) {
            $page->slug = SlugService::createSlug($page, 'slug', $page->title);
        });
        static::deleting(function ($page){
            $page->update([
                'is_active' => 0
            ]);
        });
        static::restoring(function ($page){
            $page->update([
                'is_active' => 1
            ]);
        });
    }
}
