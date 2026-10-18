<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Servicio;
use App\Models\Usuario;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BarberoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_barbero_can_access_dashboard_and_modules(): void
    {
        $barbero = Usuario::where('id_rol', 2)->first();
        $this->assertNotNull($barbero, 'Debe existir un barbero en base de datos');

        $this->actingAs($barbero);

        // 1. Dashboard
        $response = $this->get('/barbero/dashboard2');
        $response->assertStatus(200);
        $response->assertSee('Mi Estación de Trabajo');

        // 2. Mis Servicios
        $response = $this->get('/barbero/servicios');
        $response->assertStatus(200);
        $response->assertSee('Mis Servicios');
        $response->assertSee('Servicios Creados');
        $response->assertSee('Servicios Activos');
        $response->assertSee('Tarifa Promedio');
        $response->assertSee('Duración Promedio');
        $response->assertSee('Portafolio propio');
        $response->assertSee('Disponibles al cliente');
        $response->assertSee('Por corte/técnica');
        $response->assertSee('Estimado en silla');
        $response->assertSee('Tarifa Cliente');
        $response->assertSee('Tiempo en Silla');
        $response->assertSee('Tu Ganancia');

        // 3. Mi Agenda / Citas
        $response = $this->get('/barbero/citas');
        $response->assertStatus(200);
        $response->assertSee('Mi Agenda');
        $response->assertSee('Agenda e Historial de Citas');
        $response->assertSee('Filtrar Agenda');
        $response->assertSee('Todas');
        $response->assertSee('Pendientes');
        $response->assertSee('Confirmadas');
        $response->assertSee('Finalizadas');
        $response->assertSee('Canceladas');

        // 4. Turnos en Sala
        $response = $this->get('/barbero/turnos');
        $response->assertStatus(200);
        $response->assertSee('Monitor de Sala de Espera');

        // 5. Mi Disponibilidad
        $response = $this->get('/barbero/disponibilidad');
        $response->assertStatus(200);
        $response->assertSee('Mi Horario');

        // 6. Mis Comisiones
        $response = $this->get('/barbero/comisiones');
        $response->assertStatus(200);
        $response->assertSee('Mis Comisiones');
    }

    public function test_barbero_cannot_access_admin_dashboard(): void
    {
        $barbero = Usuario::where('id_rol', 2)->first();
        $this->actingAs($barbero);

        $response = $this->get('/administrador/dashboard1');
        // Debe ser redirigido por el middleware CheckRole
        $response->assertRedirect('/barbero/dashboard2');
    }

    public function test_barbero_can_create_and_manage_own_services(): void
    {
        $barbero = Usuario::where('id_rol', 2)->first();
        $this->actingAs($barbero);

        $categoria = Categoria::first();

        // 1. Crear servicio propio
        $response = $this->post('/barbero/servicios', [
            'nombre' => 'Corte Degradado Exclusivo Mateo',
            'id_categoria' => $categoria->id_categoria,
            'precio' => 40000,
            'duracion_min' => 50,
            'descripcion' => 'Técnica personalizada con toalla caliente y navaja',
        ]);

        $response->assertRedirect('/barbero/servicios');
        $this->assertDatabaseHas('servicios', [
            'nombre' => 'Corte Degradado Exclusivo Mateo',
            'id_barbero' => $barbero->id_usuario,
            'precio' => 40000,
            'estado' => 'ACTIVO',
        ]);

        $servicio = Servicio::where('nombre', 'Corte Degradado Exclusivo Mateo')->first();

        // 2. Pausar servicio
        $response = $this->patch("/barbero/servicios/{$servicio->id_servicio}/estado");
        $servicio->refresh();
        $this->assertEquals('INACTIVO', $servicio->estado);

        // 3. Reactivar servicio
        $response = $this->patch("/barbero/servicios/{$servicio->id_servicio}/estado");
        $servicio->refresh();
        $this->assertEquals('ACTIVO', $servicio->estado);
    }

    public function test_barbero_can_create_service_with_haircut_image(): void
    {
        Storage::fake('public');

        $barbero = Usuario::where('id_rol', 2)->first();
        $this->actingAs($barbero);

        $categoria = Categoria::first();
        $file = UploadedFile::fake()->image('corte_fade_premium.jpg', 600, 600);

        // Crear servicio con foto del corte
        $response = $this->post('/barbero/servicios', [
            'nombre' => 'Corte Fade Texturizado con Foto',
            'id_categoria' => $categoria->id_categoria,
            'precio' => 45000,
            'duracion_min' => 45,
            'descripcion' => 'Degradado limpio con acabado profesional',
            'imagen' => $file,
        ]);

        $response->assertRedirect('/barbero/servicios');
        $response->assertSessionHas('success');

        $servicio = Servicio::where('nombre', 'Corte Fade Texturizado con Foto')->first();
        $this->assertNotNull($servicio);
        $this->assertNotNull($servicio->imagen);
        $this->assertStringStartsWith('/storage/servicios/', $servicio->imagen);

        // Verificar que el archivo existe en el disco público
        $relativePath = str_replace('/storage/', '', $servicio->imagen);
        Storage::disk('public')->assertExists($relativePath);

        // Actualizar servicio con nueva foto
        $newFile = UploadedFile::fake()->image('nuevo_corte.png', 800, 800);
        $updateResponse = $this->put("/barbero/servicios/{$servicio->id_servicio}", [
            'nombre' => 'Corte Fade Texturizado Modificado',
            'id_categoria' => $categoria->id_categoria,
            'precio' => 48000,
            'duracion_min' => 45,
            'estado' => 'ACTIVO',
            'imagen' => $newFile,
        ]);

        $updateResponse->assertRedirect('/barbero/servicios');
        $servicio->refresh();
        $this->assertEquals('Corte Fade Texturizado Modificado', $servicio->nombre);
        $this->assertNotEquals($relativePath, str_replace('/storage/', '', $servicio->imagen));

        // Eliminar foto del servicio
        $deleteImgResponse = $this->delete("/barbero/servicios/{$servicio->id_servicio}/imagen");
        $deleteImgResponse->assertSessionHas('success');
        $servicio->refresh();
        $this->assertNull($servicio->imagen);
    }
}
