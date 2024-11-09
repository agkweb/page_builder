<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static status()
 * @method static where(string $string, string $string1, string $string2)
 * @method static latest()
 * @method static active()
 * @method static create(array $array)
 * @method static get()
 */
class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = "categories";

    public function scopeActive($query): void
    {
        $query->where('is_active', 1);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class , 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($category) {
            foreach ($category->children as $child){
                $child->delete();
            }
            $category->update([
                'is_active' => 0
            ]);
        });
        static::restoring(function ($category){
            foreach ($category->children as $child){
                $child->restore();
            }
            $category->update([
                'is_active' => 1
            ]);
        });
    }
}
