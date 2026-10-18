<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PerfilTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_user_can_upload_profile_photo(): void
    {
        Storage::fake('public');

        $user = Usuario::where('id_rol', 2)->first();
        $this->assertNotNull($user);

        $file = UploadedFile::fake()->image('avatar.jpg', 300, 300);

        $response = $this->actingAs($user)->post(route('perfil.foto.update'), [
            'foto' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertNotNull($user->foto_perfil);
        $this->assertStringStartsWith('/storage/avatars/', $user->foto_perfil);

        $storedPath = str_replace('/storage/', '', $user->foto_perfil);
        Storage::disk('public')->assertExists($storedPath);
    }

    public function test_user_can_delete_profile_photo(): void
    {
        Storage::fake('public');

        $user = Usuario::where('id_rol', 2)->first();
        $this->assertNotNull($user);

        $file = UploadedFile::fake()->image('old_avatar.png');
        $path = $file->store('avatars', 'public');
        $user->foto_perfil = '/storage/'.$path;
        $user->save();

        $response = $this->actingAs($user)->delete(route('perfil.foto.destroy'));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertNull($user->foto_perfil);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_user_can_update_profile_info(): void
    {
        $user = Usuario::where('id_rol', 2)->first();
        $this->assertNotNull($user);

        $response = $this->actingAs($user)->put(route('perfil.update'), [
            'nombre' => 'Mateo Barber Pro',
            'telefono' => '3219876543',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals('Mateo Barber Pro', $user->nombre);
        $this->assertEquals('3219876543', $user->telefono);
    }
}
