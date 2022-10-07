<?php

namespace Database\Factories;

use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    public static ?Collection $authors_id = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        if (empty(self::$authors_id)) {
            self::$authors_id = User::all()->pluck('id');
        }

        $author_id = self::$authors_id->random();

        return [
            'title' => $this->faker->text(50),
            'article_photo_path' => $this->faker->imageUrl(),
            'announcement' => $this->faker->dateTime(),
            'text' => $this->faker->text(),
            'author_id' => $author_id,
        ];
    }
}
