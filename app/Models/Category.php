<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kalnoy\Nestedset\NodeTrait;


/**
 * @mixin IdeHelperCategory
 */
class Category extends Model
{
    use HasFactory;
    use Sluggable, NodeTrait {
        NodeTrait::replicate as replicateNode;
        Sluggable::replicate as replicateSlug;
    }

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
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
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'articles_categories');
    }

    public function replicate(array $except = null): Model|Category
    {
        $instance = $this->replicateNode($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }

    /**
     * @param $value
     * @param null $field
     * @return Category|null
     */
    public function resolveRouteBinding($value, $field = null): ?Category
    {
        return $this->where('slug', $value)->orWhere('id', $value)->first();
    }
}
