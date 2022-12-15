<?php

namespace Tests\Feature\Controllers\User;

use App\Enums\MediaCollections;
use App\Models\User;
use Illuminate\Http\Testing\File;
use Laravel\Sanctum\Sanctum;
use Storage;
use Tests\TestCase;

class AddProfilePhotoTest extends TestCase
{
    /**
     * @return void
     */
    public function testAddUserPhoto(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $file = File::image('IMG_3657.PNG');

        $this
            ->post("api/users/{$user->id}", ['image' => $file])
            ->assertOk();

        $photos = $user->getMedia(MediaCollections::PROFILE_PICTURE);
        $this->assertCount(1, $photos);

        $photo = $photos->first();

        $this->assertFileExists($photo->getPath());
        $this->assertFileExists($photo->getPath('preview'));

        Storage::disk('media')->delete([
            $photo->getPathRelativeToRoot(),
            $photo->getPathRelativeToRoot('preview')
        ]);

        $this->assertFileDoesNotExist($photo->getPath());
        $this->assertFileDoesNotExist($photo->getPath('preview'));
    }
}
