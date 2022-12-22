<?php

namespace Tests\Unit\Models\User\Traits;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlugTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testSlugIsDifferent(): void
    {
        $users = User::factory(2)->create(['name' => 'Test']);

        $this->assertNotEquals($users[1]->slug, $users[0]->slug);
    }
}
