<?php

namespace Database\Factories;

use App\Models\Category;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
//        $title = $this->faker->text(50);
        $title = '$this->faker->text(50)';
        return [
            'title' => $title,
            'category_photo_path' => $this->faker->imageUrl(),
            'description' => $this->faker->text(),
            'slug' => SlugService::createSlug(Category::class, 'slug', $title),
        ];
    }
}
