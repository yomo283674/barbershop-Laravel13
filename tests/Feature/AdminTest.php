<?php

namespace Tests\Feature;

use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Turno;
use App\Models\Usuario;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_admin_can_access_all_administrative_modules(): void
    {
        $admin = Usuario::where('id_rol', 1)->first();
        $this->assertNotNull($admin, 'Debe existir un administrador en base de datos');

        $this->actingAs($admin);

        // 1. Dashboard Principal
        $response = $this->get('/administrador/dashboard1');
        $response->assertStatus(200);

        // 2. Módulo de Citas
        $response = $this->get('/administrador/citas');
        $response->assertStatus(200);
        $response->assertSee('Módulo de Citas');

        // 3. Módulo de Turnos en Sala
        $response = $this->get('/administrador/turnos');
        $response->assertStatus(200);
        $response->assertSee('Sala de Espera y Turnos');

        // 4. Módulo de Barberos
        $response = $this->get('/administrador/barberos');
        $response->assertStatus(200);
        $response->assertSee('Equipo de Barberos');

        // 5. Módulo de Servicios
        $response = $this->get('/administrador/servicios');
        $response->assertStatus(200);
        $response->assertSee('Catálogo de Servicios');

        // 6. Módulo de Clientes
        $response = $this->get('/administrador/clientes');
        $response->assertStatus(200);
        $response->assertSee('Directorio de Clientes');

        // 7. Módulo de Auditoría y Reportes
        $response = $this->get('/administrador/auditoria');
        $response->assertStatus(200);
        $response->assertSee('Bitácora de Auditoría');

        // 8. Módulo de Configuración
        $response = $this->get('/administrador/configuracion');
        $response->assertStatus(200);
        $response->assertSee('Configuración del Sistema');
    }

    public function test_admin_can_create_and_manage_appointments(): void
    {
        $admin = Usuario::where('id_rol', 1)->first();
        $this->actingAs($admin);

        $cliente = Usuario::where('id_rol', 3)->first();
        $barbero = Usuario::where('id_rol', 2)->first();
        $servicio = Servicio::first();

        // 1. Agendar cita desde panel administrativo
        $response = $this->post('/administrador/citas', [
            'id_cliente' => $cliente->id_usuario,
            'id_barbero' => $barbero->id_usuario,
            'id_servicio' => $servicio->id_servicio,
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '14:30',
            'estado' => 'ACEPTADA',
            'observacion' => 'Cita reservada directamente por administración',
        ]);

        $response->assertRedirect('/administrador/citas');
        $this->assertDatabaseHas('citas', [
            'id_cliente' => $cliente->id_usuario,
            'id_barbero' => $barbero->id_usuario,
            'id_servicio' => $servicio->id_servicio,
            'estado' => 'ACEPTADA',
        ]);

        $cita = Cita::where('id_cliente', $cliente->id_usuario)->latest('id_cita')->first();

        // 2. Cambiar estado a COMPLETADA
        $cambioResponse = $this->patch("/administrador/citas/{$cita->id_cita}/estado", [
            'estado' => 'COMPLETADA',
        ]);
        $cambioResponse->assertSessionHas('success');
        $cita->refresh();
        $this->assertEquals('COMPLETADA', $cita->estado);
    }

    public function test_admin_can_issue_and_process_turnos(): void
    {
        $admin = Usuario::where('id_rol', 1)->first();
        $this->actingAs($admin);

        $cliente = Usuario::where('id_rol', 3)->first();

        // 1. Emitir turno en sala
        $response = $this->post('/administrador/turnos', [
            'id_cliente' => $cliente->id_usuario,
        ]);
        $response->assertRedirect('/administrador/turnos');

        $turno = Turno::where('id_cliente', $cliente->id_usuario)->latest('id_turno')->first();
        $this->assertNotNull($turno);
        $this->assertEquals('EN_ESPERA', $turno->estado);

        // 2. Llamar turno a estación
        $llamarResponse = $this->patch("/administrador/turnos/{$turno->id_turno}/llamar");
        $llamarResponse->assertSessionHas('success');
        $turno->refresh();
        $this->assertEquals('EN_ATENCION', $turno->estado);

        // 3. Finalizar turno
        $finalizarResponse = $this->patch("/administrador/turnos/{$turno->id_turno}/finalizar");
        $finalizarResponse->assertSessionHas('success');
        $turno->refresh();
        $this->assertEquals('FINALIZADO', $turno->estado);
    }

    public function test_admin_can_register_and_toggle_barbero(): void
    {
        $admin = Usuario::where('id_rol', 1)->first();
        $this->actingAs($admin);

        // 1. Registrar nuevo barbero
        $response = $this->post('/administrador/barberos', [
            'nombre' => 'Camilo Barbero Test',
            'email' => 'camilo.test@barbershop.com',
            'telefono' => '3120001122',
            'especialidad' => 'Cortes Clásicos & Navaja',
            'cargo' => 'Barbero Profesional',
        ]);

        $response->assertRedirect('/administrador/barberos');
        $this->assertDatabaseHas('usuarios', [
            'email' => 'camilo.test@barbershop.com',
            'id_rol' => 2,
            'estado' => 'ACTIVO',
        ]);

        $nuevoBarbero = Usuario::where('email', 'camilo.test@barbershop.com')->first();

        // 2. Alternar estado activo / inactivo
        $toggleResponse = $this->patch("/administrador/barberos/{$nuevoBarbero->id_usuario}/estado");
        $toggleResponse->assertSessionHas('success');
        $nuevoBarbero->refresh();
        $this->assertEquals('INACTIVO', $nuevoBarbero->estado);
    }

    public function test_admin_can_update_business_settings(): void
    {
        $admin = Usuario::where('id_rol', 1)->first();
        $this->actingAs($admin);

        $response = $this->put('/administrador/configuracion', [
            'nombre_negocio' => 'Barbershop Exclusive Club',
            'horario_apertura' => '07:30',
            'horario_cierre' => '21:00',
            'duracion_cita_min' => 40,
            'tiempo_cancelacion_min' => 120,
            'tiempo_reprogramacion_min' => 90,
            'tiempo_notificacion_min' => 30,
        ]);

        $response->assertRedirect('/administrador/configuracion');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('configuracion_sistema', [
            'nombre_negocio' => 'Barbershop Exclusive Club',
            'duracion_cita_min' => 40,
            'tiempo_cancelacion_min' => 120,
        ]);
    }
}
