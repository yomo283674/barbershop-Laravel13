<?php

namespace Tests\Feature;

use App\Models\Cita;
use App\Models\Configuracion;
use App\Models\Disponibilidad;
use App\Models\Reprogramacion;
use App\Models\Servicio;
use App\Models\Usuario;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_cliente_can_access_dashboard(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->assertNotNull($cliente);

        $this->actingAs($cliente);

        $response = $this->get('/cliente/dashboard3');
        $response->assertStatus(200);
        $response->assertSee('Mis Reservas');
        $response->assertSee('Nuestros Barberos y sus Servicios');
    }

    public function test_cliente_can_access_citas_index(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        $response = $this->get('/cliente/citas');
        $response->assertStatus(200);
        $response->assertSee('Mis Citas e Historial');
    }

    public function test_cliente_can_access_barberos_directory(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        $response = $this->get('/cliente/barberos');
        $response->assertStatus(200);
        $response->assertSee('Equipo de Barberos');
    }

    public function test_cliente_cannot_access_admin_or_barber_areas(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        // 1. Administrador
        $responseAdmin = $this->get('/administrador/dashboard1');
        $responseAdmin->assertRedirect('/cliente/dashboard3');

        // 2. Barbero
        $responseBarbero = $this->get('/barbero/dashboard2');
        $responseBarbero->assertRedirect('/cliente/dashboard3');
    }

    public function test_cliente_can_fetch_horarios_disponibles_json(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        $barbero = Usuario::where('id_rol', Usuario::ROL_BARBERO)->first();
        $servicio = Servicio::where('id_barbero', $barbero->id_usuario)->where('estado', 'ACTIVO')->first()
            ?? Servicio::first();

        $fechaFutura = Carbon::today()->addDays(2)->toDateString();

        $response = $this->getJson("/cliente/horarios-disponibles?id_barbero={$barbero->id_usuario}&id_servicio={$servicio->id_servicio}&fecha={$fechaFutura}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'fecha',
            'servicio',
            'duracion_min',
            'slots',
            'total_disponibles',
        ]);
    }

    public function test_cliente_can_book_appointment_with_chosen_barber_service(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        $barbero = Usuario::where('id_rol', Usuario::ROL_BARBERO)->first();
        $servicio = Servicio::where('id_barbero', $barbero->id_usuario)->where('estado', 'ACTIVO')->first()
            ?? Servicio::create([
                'id_barbero' => $barbero->id_usuario,
                'nombre' => 'Corte Test',
                'precio' => 25000,
                'duracion_min' => 40,
                'estado' => 'ACTIVO',
            ]);

        $fecha = Carbon::today()->addDays(3)->toDateString();

        $response = $this->post('/cliente/citas', [
            'id_barbero' => $barbero->id_usuario,
            'id_servicio' => $servicio->id_servicio,
            'fecha' => $fecha,
            'hora' => '15:00',
            'observacion' => 'Preferencia de corte personalizada',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('citas', [
            'id_cliente' => $cliente->id_usuario,
            'id_barbero' => $barbero->id_usuario,
            'id_servicio' => $servicio->id_servicio,
            'estado' => 'PENDIENTE',
            'observacion' => 'Preferencia de corte personalizada',
        ]);
    }

    public function test_cliente_cannot_book_overlapping_appointment(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        $barbero = Usuario::where('id_rol', Usuario::ROL_BARBERO)->first();
        $servicio = Servicio::create([
            'id_barbero' => $barbero->id_usuario,
            'nombre' => 'Corte Fade',
            'precio' => 30000,
            'duracion_min' => 60,
            'estado' => 'ACTIVO',
        ]);

        $fecha = Carbon::today()->addDays(2)->toDateString();

        // 1. Crear cita existente de 10:00 a 11:00
        Cita::create([
            'id_cliente' => $cliente->id_usuario,
            'id_barbero' => $barbero->id_usuario,
            'id_servicio' => $servicio->id_servicio,
            'fecha' => $fecha,
            'hora' => '10:00:00',
            'estado' => 'ACEPTADA',
        ]);

        // 2. Intentar agendar a las 10:30 (dentro de la franja de 10:00 a 11:00)
        $response = $this->post('/cliente/citas', [
            'id_barbero' => $barbero->id_usuario,
            'id_servicio' => $servicio->id_servicio,
            'fecha' => $fecha,
            'hora' => '10:30',
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(1, Cita::where('id_barbero', $barbero->id_usuario)->whereDate('fecha', $fecha)->count());
    }

    public function test_cliente_cannot_book_during_barber_break_block(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        $barbero = Usuario::where('id_rol', Usuario::ROL_BARBERO)->first();
        $servicio = Servicio::create([
            'id_barbero' => $barbero->id_usuario,
            'nombre' => 'Corte Barba',
            'precio' => 20000,
            'duracion_min' => 45,
            'estado' => 'ACTIVO',
        ]);

        $fecha = Carbon::today()->addDays(2)->toDateString();

        // Bloqueo de descanso de 13:00 a 14:00
        Disponibilidad::create([
            'id_barbero' => $barbero->id_usuario,
            'fecha' => $fecha,
            'hora_inicio' => '13:00:00',
            'hora_fin' => '14:00:00',
            'disponible' => false,
            'motivo' => 'Almuerzo / Receso técnico',
        ]);

        $response = $this->post('/cliente/citas', [
            'id_barbero' => $barbero->id_usuario,
            'id_servicio' => $servicio->id_servicio,
            'fecha' => $fecha,
            'hora' => '13:15',
        ]);

        $response->assertSessionHas('error');
    }

    public function test_cliente_cannot_book_mismatched_service_from_another_barber(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        $barberos = Usuario::where('id_rol', Usuario::ROL_BARBERO)->get();
        if ($barberos->count() >= 2) {
            $barbero1 = $barberos[0];
            $barbero2 = $barberos[1];

            $servicioBarbero2 = Servicio::create([
                'id_barbero' => $barbero2->id_usuario,
                'nombre' => 'Corte Exclusivo B2',
                'precio' => 35000,
                'duracion_min' => 45,
                'estado' => 'ACTIVO',
            ]);

            $response = $this->post('/cliente/citas', [
                'id_barbero' => $barbero1->id_usuario,
                'id_servicio' => $servicioBarbero2->id_servicio,
                'fecha' => Carbon::today()->addDays(1)->toDateString(),
                'hora' => '10:00',
            ]);

            $response->assertSessionHas('error');
        }
    }

    public function test_cliente_can_cancel_own_appointment_with_sufficient_advance(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        $barbero = Usuario::where('id_rol', Usuario::ROL_BARBERO)->first();
        $servicio = Servicio::first();

        // Cita con 3 días de antelación
        $cita = Cita::create([
            'id_cliente' => $cliente->id_usuario,
            'id_barbero' => $barbero->id_usuario,
            'id_servicio' => $servicio->id_servicio,
            'fecha' => Carbon::today()->addDays(3)->toDateString(),
            'hora' => '11:00:00',
            'estado' => 'PENDIENTE',
        ]);

        $response = $this->patch("/cliente/citas/{$cita->id_cita}/cancelar", [
            'motivo_cancelacion' => 'Inconveniente personal',
        ]);

        $response->assertSessionHas('info');

        $cita->refresh();
        $this->assertEquals('CANCELADA', $cita->estado);
        $this->assertEquals('Inconveniente personal', $cita->motivo_cancelacion);
    }

    public function test_cliente_cannot_cancel_appointment_inside_cancellation_window(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        $config = Configuracion::first();
        $tiempoMin = $config ? (int) $config->tiempo_cancelacion_min : 60;

        $barbero = Usuario::where('id_rol', Usuario::ROL_BARBERO)->first();
        $servicio = Servicio::first();

        // Cita programada para dentro de solo 15 minutos (menor al tiempo minimo de cancelacion)
        $horaCita = Carbon::now()->addMinutes(15);
        $cita = Cita::create([
            'id_cliente' => $cliente->id_usuario,
            'id_barbero' => $barbero->id_usuario,
            'id_servicio' => $servicio->id_servicio,
            'fecha' => $horaCita->toDateString(),
            'hora' => $horaCita->format('H:i:s'),
            'estado' => 'PENDIENTE',
        ]);

        $response = $this->patch("/cliente/citas/{$cita->id_cita}/cancelar");

        $response->assertSessionHas('error');

        $cita->refresh();
        $this->assertEquals('PENDIENTE', $cita->estado);
    }

    public function test_cliente_cannot_cancel_another_clients_appointment(): void
    {
        $cliente1 = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $cliente2 = Usuario::create([
            'nombre' => 'Otro Cliente',
            'email' => 'otrocliente@test.com',
            'password' => bcrypt('password123'),
            'id_rol' => Usuario::ROL_CLIENTE,
            'estado' => 'ACTIVO',
        ]);

        $this->actingAs($cliente1);

        $barbero = Usuario::where('id_rol', Usuario::ROL_BARBERO)->first();
        $servicio = Servicio::first();

        $citaCliente2 = Cita::create([
            'id_cliente' => $cliente2->id_usuario,
            'id_barbero' => $barbero->id_usuario,
            'id_servicio' => $servicio->id_servicio,
            'fecha' => Carbon::today()->addDays(5)->toDateString(),
            'hora' => '10:00:00',
            'estado' => 'PENDIENTE',
        ]);

        $response = $this->patch("/cliente/citas/{$citaCliente2->id_cita}/cancelar");

        $response->assertSessionHas('error');

        $citaCliente2->refresh();
        $this->assertEquals('PENDIENTE', $citaCliente2->estado);
    }

    public function test_cliente_can_accept_reprogramacion(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        $barbero = Usuario::where('id_rol', Usuario::ROL_BARBERO)->first();
        $servicio = Servicio::first();

        $cita = Cita::create([
            'id_cliente' => $cliente->id_usuario,
            'id_barbero' => $barbero->id_usuario,
            'id_servicio' => $servicio->id_servicio,
            'fecha' => Carbon::today()->addDays(1)->toDateString(),
            'hora' => '10:00:00',
            'estado' => 'REPROGRAMADA',
        ]);

        $nuevaFecha = Carbon::today()->addDays(2)->toDateString();
        $reprogramacion = Reprogramacion::create([
            'id_cita' => $cita->id_cita,
            'nueva_fecha' => $nuevaFecha,
            'nueva_hora' => '14:00:00',
            'estado' => 'PENDIENTE',
        ]);

        $response = $this->post("/cliente/reprogramaciones/{$reprogramacion->id_reprogramacion}/responder", [
            'accion' => 'aceptar',
        ]);

        $response->assertSessionHas('success');

        $reprogramacion->refresh();
        $cita->refresh();

        $this->assertEquals('CONFIRMADA', $reprogramacion->estado);
        $this->assertEquals('ACEPTADA', $cita->estado);
        $this->assertEquals($nuevaFecha, Carbon::parse($cita->fecha)->toDateString());
        $this->assertEquals('14:00:00', $cita->hora);
    }

    public function test_cliente_can_reject_reprogramacion(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        $barbero = Usuario::where('id_rol', Usuario::ROL_BARBERO)->first();
        $servicio = Servicio::first();

        $cita = Cita::create([
            'id_cliente' => $cliente->id_usuario,
            'id_barbero' => $barbero->id_usuario,
            'id_servicio' => $servicio->id_servicio,
            'fecha' => Carbon::today()->addDays(1)->toDateString(),
            'hora' => '10:00:00',
            'estado' => 'REPROGRAMADA',
        ]);

        $reprogramacion = Reprogramacion::create([
            'id_cita' => $cita->id_cita,
            'nueva_fecha' => Carbon::today()->addDays(2)->toDateString(),
            'nueva_hora' => '16:00:00',
            'estado' => 'PENDIENTE',
        ]);

        $response = $this->post("/cliente/reprogramaciones/{$reprogramacion->id_reprogramacion}/responder", [
            'accion' => 'rechazar',
        ]);

        $response->assertSessionHas('info');

        $reprogramacion->refresh();
        $cita->refresh();

        $this->assertEquals('CANCELADA', $reprogramacion->estado);
        $this->assertEquals('CANCELADA', $cita->estado);
    }

    public function test_barberos_pagination_and_partial_rendering(): void
    {
        $cliente = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->first();
        $this->actingAs($cliente);

        // Dashboard pagination query
        $responseDashboard = $this->get('/cliente/dashboard3?barberos_page=1');
        $responseDashboard->assertStatus(200);
        $responseDashboard->assertViewHas('barberos');
        $responseDashboard->assertViewHas('todosLosBarberos');

        // Barberos directory pagination
        $responseBarberos = $this->get('/cliente/barberos?page=1');
        $responseBarberos->assertStatus(200);
        $responseBarberos->assertViewHas('barberos');
        $responseBarberos->assertViewHas('todosLosBarberos');
    }
}
