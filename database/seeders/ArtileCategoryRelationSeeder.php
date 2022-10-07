<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ArtileCategoryRelationSeeder extends Seeder
{
//    public static ?Collection $categories_id = null;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // для каждой статьи сделать 0-3 категории
        $categories_id = Category::all()->pluck('id');

        Article::all()->each(function (Article $article) use ($categories_id) {
            $category_id = $categories_id->random();
            for (
                $i = 0, $iterations_limit = rand(0, 2);
                $i <= $iterations_limit;
                $i++
            ) {
                $article->categories()->attach($category_id);
            }
        });
    }
}
