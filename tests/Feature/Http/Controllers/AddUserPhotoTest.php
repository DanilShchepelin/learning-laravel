<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Testing\File;
use Tests\TestCase;

class AddUserPhotoTest extends TestCase
{
    /**
     * @return void
     */
    public function testAddUserPhoto(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->be($user, 'sanctum');

//        $file = UploadedFile::fake()->image('avatar.jpg');
        $file = File::image('IMG_3657.PNG');

        $response = $this
            ->post("api/users/{$user->id}", ['image' => $file])
            ->assertOk();

        $photos = $this->user->getMedia('profile_picture');

        $this->assertCount(1, $photos);
        $this->assertFileExists($photos->first()->getPath());
        $this->assertFileExists($photos->first()->getPath('thumb'));

//        Storage::disk('media')->assertExists($file->name);
    }
}
