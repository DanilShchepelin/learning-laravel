<?php

namespace App\Models;

use App\Models\Traits\SearchByIdOrSlug;
use App\Models\Traits\Sortable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

/**
 * @mixin IdeHelperArticle
 */
class Article extends Model
{
    use HasFactory;
    use Sluggable;
    use SearchByIdOrSlug;
    use Sortable;

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
                'onUpdate' => true,
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
        return $this->belongsTo(User::class,'author_id');
    }

    /**
     * @param Builder $query
     * @param string|null $id_or_slug
     * @return Builder
     */
    public function scopeWithAuthor(Builder $query, ?string $id_or_slug): Builder
    {
        if (empty($id_or_slug)) {
            return $query;
        }

        return $query->withWhereHas('author', function ($query) use ($id_or_slug) {
            /** @var User $query */
            return $query->findByIdOrSlug($id_or_slug);
        });
    }

    /**
     * @param Builder $query
     * @param string|null $id_or_slug
     * @return Builder
     */
    public function scopeWithCategory(Builder $query, ?string $id_or_slug): Builder
    {
        if (empty($id_or_slug)) {
            return $query;
        }

        return $query->whereHas('categories', function ($query) use ($id_or_slug) {
            /** @var Category $query */
            return $query->findByIdOrSlug($id_or_slug);
        });
    }

    /**
     * @param Builder $query
     * @param string|null $title
     * @return Builder
     */
    public function scopeWithTitle(Builder $query, ?string $title): Builder
    {
        if (!empty($title)) {
            $query->where('title', 'like', "%{$title}%");
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @param Request $request
     * @return Builder
     */
    public function scopeFiltering(Builder $query, Request $request): Builder
    {
        /** @var self $query */
        return $query
            ->withAuthor($request->query('author'))
            ->withCategory($request->query('category'))
            ->withTitle($request->query('title'));
    }

    public function scopeAddRelations(Builder $query, ?Array $with): Builder
    {
        if (empty($with)) {
            return $query;
        }
        return $query->with($with);
    }
}
