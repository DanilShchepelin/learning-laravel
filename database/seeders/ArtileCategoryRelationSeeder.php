<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ArtileCategoryRelationSeeder extends Seeder
{
//    public static ?GetList $categories_id = null;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories_id = Category::all()->pluck('id');

        Article::all()->each(function (Article $article) use ($categories_id) {

            for (
                $i = 0, $iterations_limit = rand(0, 2);
                $i <= $iterations_limit;
                $i++
            ) {
                $category_id = $categories_id->random();
                $article->categories()->attach($category_id);
            }
        });
    }
}
