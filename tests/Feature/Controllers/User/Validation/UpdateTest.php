<?php

namespace Tests\Feature\Controllers\User\Validation;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
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
    public function testUpdateIsValid(): void
    {
        $user_id = $this->actingAsAuthor();

        $new_data = [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'biography' => $this->faker->text
        ];

        $this
            ->postJson("/api/users/{$user_id}", $new_data)
            ->assertStatus(200);

        $user = User::where('id', $user_id)->first();

        $this->assertEquals($new_data['email'], $user->email);
        $this->assertEquals($new_data['name'], $user->name);
        $this->assertEquals($new_data['biography'], $user->biography);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testMaxFieldName(): void
    {
        $user_id = $this->actingAsAuthor();
        $this->validationTest(
            'max.string',
            "/api/users/{$user_id}",
            ['name' => $this->faker->realTextBetween(71, 80)],
            'name',
            ['max' => 70]
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testEmailFieldIsEmail(): void
    {
        $user_id = $this->actingAsAuthor();
        $this->validationTest(
            'email',
            "/api/users/{$user_id}",
            ['email' => 'test@'],
            'email'
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testEmailFieldIsUnique(): void
    {
        User::factory()->create(['email' => 'test@test.com']);

        $user_id = $this->actingAsAuthor();
        $this->validationTest(
            'unique',
            "/api/users/{$user_id}",
            ['email' => 'test@test.com'],
            'email'
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testMaxFieldBiography(): void
    {
        $user_id = $this->actingAsAuthor();
        $this->validationTest(
            'max.string',
            "/api/users/{$user_id}",
            ['biography' => $this->faker->realTextBetween(256, 270)],
            'biography',
            ['max' => 255]
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testImageFieldIsImage(): void
    {
        $user_id = $this->actingAsAuthor();
        $this->validationTest(
            'image',
            "/api/users/{$user_id}",
            ['image' => File::create('not_image.pdf', 10)],
            'image'
        );
    }
}
