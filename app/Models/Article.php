<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperArticle
 */
class Article extends Model
{
    use HasFactory;
    use Filterable;
    use Sluggable;

    public $timestamps = false;


    protected $fillable = [
        'title',
        'text',
        'author_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'announcement' => 'datetime',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'unique' => true,
            ]
        ];
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'articles_categories');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    /**
     * @param $value
     * @param null $field
     * @return Article|null
     */
    public function resolveRouteBinding($value, $field = null): ?Article
    {
        return $this->where('slug', $value)->orWhere('id', $value)->first();
    }
}
