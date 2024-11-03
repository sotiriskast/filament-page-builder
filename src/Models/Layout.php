<?php
namespace Sotiriskast\FilamentPageBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Layout extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'content',
        'fields_schema',
    ];

    protected $casts = [
        'content' => 'array',
        'fields_schema' => 'array',
    ];

    public array $translatable = [
        'content',
    ];

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }
}
