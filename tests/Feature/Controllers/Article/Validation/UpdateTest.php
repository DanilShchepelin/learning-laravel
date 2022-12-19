<?php

namespace Tests\Feature\Controllers\Article\Validation;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @return void
     * @throws Exception
     */
    public function testIsValid(): void
    {
        $author = User::factory()->create(['role' => Roles::AUTHOR]);

        $user_id = $this->actingAsAuthor();

        $article = Article::factory()->create(['author_id' => $user_id]);

        $newData = [
            'title' => $this->faker->title,
            'text' => $this->faker->text,
            'author_id' => $author->id
        ];

        $this
            ->postJson("/api/articles/{$article->id}", $newData)
            ->assertStatus(200);

        $article->refresh();

        $this->assertEquals($newData['title'], $article->title);
        $this->assertEquals($newData['text'], $article->text);
        $this->assertEquals($newData['author_id'], $article->author_id);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testTitleCantBeNull(): void
    {
        $user = User::factory()->create(['role' => Roles::AUTHOR]);
        Sanctum::actingAs(
            $user,
            Roles::getAbilities(Roles::AUTHOR)
        );
        $article = Article::factory()->create(['author_id' => $user->id]);

        $this
            ->postJson("/api/articles/{$article->id}", ['title' => null])
            ->assertStatus(422);

        $article->refresh();

        $this->assertNotEquals(null, $article->title);
    }

    use RefreshDatabase;
    /**
     * @return void
     * @throws Exception
     */
    public function testTextCantBeNull(): void
    {
        $user = User::factory()->create(['role' => Roles::AUTHOR]);
        Sanctum::actingAs(
            $user,
            Roles::getAbilities(Roles::AUTHOR)
        );
        $article = Article::factory()->create(['author_id' => $user->id]);

        $this
            ->postJson("/api/articles/{$article->id}", ['text' => null])
            ->assertStatus(422);

        $article->refresh();

        $this->assertNotEquals(null, $article->text);
    }

    use RefreshDatabase;
    /**
     * @return void
     * @throws Exception
     */
    public function testAuthorCantBeNonExist(): void
    {
        $user = User::factory()->create(['role' => Roles::AUTHOR]);
        Sanctum::actingAs(
            $user,
            Roles::getAbilities(Roles::AUTHOR)
        );
        $article = Article::factory()->create(['author_id' => $user->id]);

        $this
            ->postJson("/api/articles/{$article->id}", ['author_id' => 999])
            ->assertStatus(422);

        $article->refresh();

        $this->assertNotEquals(999, $article->author_id);
    }

    use RefreshDatabase;
    /**
     * @return void
     * @throws Exception
     */
    public function testMaxFieldTitle(): void
    {
        $user = User::factory()->create(['role' => Roles::AUTHOR]);
        Sanctum::actingAs(
            $user,
            Roles::getAbilities(Roles::AUTHOR)
        );
        $article = Article::factory()->create(['author_id' => $user->id]);

        $this->validationTest(
            'max.string',
            "/api/articles/{$article->id}",
            ['title' => $this->faker->realTextBetween(256, 270)],
            'title',
            ['max' => 255]
        );
    }
}
