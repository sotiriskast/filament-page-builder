<?php

namespace Sotiriskast\FilamentPageBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'layout_id',
        'content',
        'is_published',
        'meta',
    ];

    protected $casts = [
        'content' => 'array',
        'meta' => 'array',
        'is_published' => 'boolean',
    ];

    public array $translatable = [
        'title',
        'content',
        'meta',
    ];

    public function layout(): BelongsTo
    {
        return $this->belongsTo(Layout::class);
    }
}
