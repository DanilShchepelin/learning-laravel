<?php

namespace App\Models;

use App\Models\Traits\SearchByIdOrSlug;
use Cviebrock\EloquentSluggable\Services\SlugService;
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
    use SearchByIdOrSlug;
    use Sluggable, NodeTrait {
        NodeTrait::replicate as replicateNode;
        Sluggable::replicate as replicateSlug;
    }

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'parent_id'
    ];

    protected $hidden = [
        '_lft',
        '_rgt'
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
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'articles_categories');
    }

    /**
     * Совместимость двух пакетов Sluggable и NodeTrait
     *
     * @param array|null $except
     * @return Model|Category
     */
    public function replicate(array $except = null): Model|Category
    {
        $instance = $this->replicateNode($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }
}
