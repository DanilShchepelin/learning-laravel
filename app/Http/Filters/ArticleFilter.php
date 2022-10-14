<?php

namespace App\Http\Filters;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ArticleFilter extends AbstractFilter
{
    public const TITLE = 'title';
    public const CATEGORY_ID = 'category_id';
    public const AUTHOR = 'author';


    protected function getCallbacks(): array
    {
        return [
            self::TITLE => [$this, 'title'],
            self::AUTHOR => [$this, 'author'],
            self::CATEGORY_ID => [$this, 'categoryId'],
        ];
    }

    public function title(Builder $builder, $value) {
        $builder->where('title', 'like', "%{$value}%");
    }

    public function author(Builder $builder, $value) {
        $builder->whereHas('users', function (Builder $query) use ($value){
            return $query->where('name', 'like', "%{$value}%");
        });
    }

    public function categoryId(Builder $builder, $value) {
        $builder->where('category_id', $value);
    }
}
