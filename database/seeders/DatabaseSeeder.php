<?php

namespace Database\Seeders;

use App\Models\Auditoria;
use App\Models\Categoria;
use App\Models\Cita;
use App\Models\Configuracion;
use App\Models\Reporte;
use App\Models\Reprogramacion;
use App\Models\Servicio;
use App\Models\Turno;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        DB::table('roles')->insertOrIgnore([
            ['id_rol' => 1, 'nombre' => 'Administrador', 'descripcion' => 'Control total del sistema'],
            ['id_rol' => 2, 'nombre' => 'Barbero', 'descripcion' => 'Gestión de agenda y citas asignadas'],
            ['id_rol' => 3, 'nombre' => 'Cliente', 'descripcion' => 'Reservas y consultas'],
        ]);

        // 2. Usuario Administrador
        $admin = Usuario::firstOrCreate(
            ['email' => 'admin@barbershop.com'],
            [
                'id_rol' => 1,
                'nombre' => 'Juan Administrador',
                'password' => Hash::make('password123'),
                'telefono' => '3001234567',
                'estado' => 'ACTIVO',
                'cargo' => 'Gerente General',
            ]
        );

        // 3. Barberos (rol 2)
        $barbero1 = Usuario::firstOrCreate(
            ['email' => 'mateo@barbershop.com'],
            [
                'id_rol' => 2,
                'nombre' => 'Mateo Silva',
                'password' => Hash::make('password123'),
                'telefono' => '3109876541',
                'estado' => 'ACTIVO',
                'especialidad' => 'Fade Moderno & Degradados',
                'cargo' => 'Barbero Senior',
            ]
        );

        $barbero2 = Usuario::firstOrCreate(
            ['email' => 'andres@barbershop.com'],
            [
                'id_rol' => 2,
                'nombre' => 'Andrés Vélez',
                'password' => Hash::make('password123'),
                'telefono' => '3109876542',
                'estado' => 'ACTIVO',
                'especialidad' => 'Cuidado de Barba & Afeitado Tradicional',
                'cargo' => 'Master Barber',
            ]
        );

        $barbero3 = Usuario::firstOrCreate(
            ['email' => 'camilo@barbershop.com'],
            [
                'id_rol' => 2,
                'nombre' => 'Camilo Rojas',
                'password' => Hash::make('password123'),
                'telefono' => '3109876543',
                'estado' => 'ACTIVO',
                'especialidad' => 'Cortes Clásicos & Tijera',
                'cargo' => 'Barbero Pro',
            ]
        );

        $barbero4 = Usuario::firstOrCreate(
            ['email' => 'diego@barbershop.com'],
            [
                'id_rol' => 2,
                'nombre' => 'Diego Ramos',
                'password' => Hash::make('password123'),
                'telefono' => '3109876544',
                'estado' => 'ACTIVO',
                'especialidad' => 'Diseños Urbanos & Colorimetría',
                'cargo' => 'Estilista Barber',
            ]
        );

        // 4. Clientes (rol 3)
        $cliente1 = Usuario::firstOrCreate(
            ['email' => 'alejandro@cliente.com'],
            [
                'id_rol' => 3,
                'nombre' => 'Alejandro Morales',
                'numero_identificacion' => '1020456789',
                'password' => Hash::make('password123'),
                'telefono' => '3124567890',
                'estado' => 'ACTIVO',
            ]
        );

        $cliente2 = Usuario::firstOrCreate(
            ['email' => 'carlos@cliente.com'],
            [
                'id_rol' => 3,
                'nombre' => 'Carlos Restrepo',
                'numero_identificacion' => '1035678912',
                'password' => Hash::make('password123'),
                'telefono' => '3019876543',
                'estado' => 'ACTIVO',
            ]
        );

        $cliente3 = Usuario::firstOrCreate(
            ['email' => 'david@cliente.com'],
            [
                'id_rol' => 3,
                'nombre' => 'David Gómez',
                'numero_identificacion' => '1045987123',
                'password' => Hash::make('password123'),
                'telefono' => '3157789900',
                'estado' => 'ACTIVO',
            ]
        );

        $cliente4 = Usuario::firstOrCreate(
            ['email' => 'javier@cliente.com'],
            [
                'id_rol' => 3,
                'nombre' => 'Javier Ramírez',
                'numero_identificacion' => '1018765432',
                'password' => Hash::make('password123'),
                'telefono' => '3201122334',
                'estado' => 'ACTIVO',
            ]
        );

        $cliente5 = Usuario::firstOrCreate(
            ['email' => 'sebastian@cliente.com'],
            [
                'id_rol' => 3,
                'nombre' => 'Sebastián Torres',
                'numero_identificacion' => '1098761234',
                'password' => Hash::make('password123'),
                'telefono' => '3112233445',
                'estado' => 'ACTIVO',
            ]
        );

        // 5. Categorías de Servicio
        $catCortes = Categoria::firstOrCreate(['nombre' => 'Cortes de Cabello'], ['descripcion' => 'Técnicas modernas y clásicas']);
        $catBarba = Categoria::firstOrCreate(['nombre' => 'Cuidado de Barba'], ['descripcion' => 'Afeitado, perfilado y tratamientos']);
        $catTratamientos = Categoria::firstOrCreate(['nombre' => 'Tratamientos & Spa'], ['descripcion' => 'Exfoliación, vapor ozono y mascarillas']);

        // 6. Servicios
        $serv1 = Servicio::firstOrCreate(
            ['nombre' => 'Corte Fade & Barba'],
            [
                'id_categoria' => $catCortes->id_categoria,
                'descripcion' => 'Corte con desvanecido personalizado más perfilado de barba',
                'precio' => 35.00,
                'duracion_min' => 45,
                'estado' => 'ACTIVO',
                'id_barbero' => $barbero1->id_usuario,
            ]
        );

        $serv2 = Servicio::firstOrCreate(
            ['nombre' => 'Perfilado de Barba'],
            [
                'id_categoria' => $catBarba->id_categoria,
                'descripcion' => 'Delimitación con navaja y toalla caliente',
                'precio' => 20.00,
                'duracion_min' => 30,
                'estado' => 'ACTIVO',
                'id_barbero' => $barbero2->id_usuario,
            ]
        );

        $serv3 = Servicio::firstOrCreate(
            ['nombre' => 'Tratamiento Capilar & Corte'],
            [
                'id_categoria' => $catTratamientos->id_categoria,
                'descripcion' => 'Lavado nutritivo, exfoliación capilar y corte de cabello',
                'precio' => 45.00,
                'duracion_min' => 60,
                'estado' => 'ACTIVO',
                'id_barbero' => $barbero1->id_usuario,
            ]
        );

        $serv4 = Servicio::firstOrCreate(
            ['nombre' => 'Corte Clásico'],
            [
                'id_categoria' => $catCortes->id_categoria,
                'descripcion' => 'Corte tradicional a tijera o máquina',
                'precio' => 25.00,
                'duracion_min' => 35,
                'estado' => 'ACTIVO',
                'id_barbero' => $barbero3->id_usuario,
            ]
        );

        $serv5 = Servicio::firstOrCreate(
            ['nombre' => 'Afeitado Tradicional'],
            [
                'id_categoria' => $catBarba->id_categoria,
                'descripcion' => 'Afeitado completo con espuma caliente y bálsamo',
                'precio' => 22.00,
                'duracion_min' => 30,
                'estado' => 'ACTIVO',
                'id_barbero' => $barbero2->id_usuario,
            ]
        );

        // 7. Citas para hoy (now()->toDateString())
        $hoy = now()->toDateString();

        if (Cita::whereDate('fecha', $hoy)->count() === 0) {
            $cita1 = Cita::create([
                'id_cliente' => $cliente1->id_usuario,
                'id_barbero' => $barbero1->id_usuario,
                'id_servicio' => $serv1->id_servicio,
                'fecha' => $hoy,
                'hora' => '09:00:00',
                'estado' => 'ACEPTADA',
                'observacion' => 'Pide degradado medio y toalla caliente',
            ]);

            $cita2 = Cita::create([
                'id_cliente' => $cliente2->id_usuario,
                'id_barbero' => $barbero2->id_usuario,
                'id_servicio' => $serv2->id_servicio,
                'fecha' => $hoy,
                'hora' => '10:30:00',
                'estado' => 'PENDIENTE',
                'observacion' => 'Cliente nuevo, primera vez',
            ]);

            $cita3 = Cita::create([
                'id_cliente' => $cliente3->id_usuario,
                'id_barbero' => $barbero1->id_usuario,
                'id_servicio' => $serv3->id_servicio,
                'fecha' => $hoy,
                'hora' => '11:45:00',
                'estado' => 'REPROGRAMADA',
                'observacion' => 'Solicitó cambio de horario por reunión',
            ]);

            $cita4 = Cita::create([
                'id_cliente' => $cliente4->id_usuario,
                'id_barbero' => $barbero3->id_usuario,
                'id_servicio' => $serv4->id_servicio,
                'fecha' => $hoy,
                'hora' => '08:15:00',
                'estado' => 'COMPLETADA',
                'observacion' => 'Atendido a primera hora, pago en efectivo',
            ]);

            $cita5 = Cita::create([
                'id_cliente' => $cliente5->id_usuario,
                'id_barbero' => $barbero2->id_usuario,
                'id_servicio' => $serv5->id_servicio,
                'fecha' => $hoy,
                'hora' => '14:00:00',
                'estado' => 'CANCELADA',
                'observacion' => 'Aviso telefónico',
                'motivo_cancelacion' => 'Calamidad doméstica de último momento',
            ]);

            // 8. Turnos en sala de espera (turnos)
            Turno::create([
                'id_cliente' => $cliente3->id_usuario,
                'id_cita' => $cita3->id_cita,
                'fecha' => $hoy,
                'posicion' => 1,
                'estado' => 'EN_ATENCION',
            ]);

            Turno::create([
                'id_cliente' => $cliente2->id_usuario,
                'id_cita' => $cita2->id_cita,
                'fecha' => $hoy,
                'posicion' => 2,
                'estado' => 'EN_ESPERA',
            ]);

            Turno::create([
                'id_cliente' => $cliente4->id_usuario,
                'id_cita' => $cita4->id_cita,
                'fecha' => $hoy,
                'posicion' => 3,
                'estado' => 'EN_ESPERA',
            ]);

            // 9. Solicitud de Reprogramación
            Reprogramacion::create([
                'id_cita' => $cita3->id_cita,
                'nueva_fecha' => now()->addDay()->toDateString(),
                'nueva_hora' => '14:30:00',
                'estado' => 'PENDIENTE',
                'fecha_limite_respuesta' => now()->addHours(6),
            ]);
        }

        // 10. Configuración del Sistema
        if (Configuracion::count() === 0) {
            Configuracion::create([
                'nombre_negocio' => 'Barbershop',
                'horario_apertura' => '08:00:00',
                'horario_cierre' => '20:00:00',
                'duracion_cita_min' => 45,
                'tiempo_cancelacion_min' => 60,
                'tiempo_reprogramacion_min' => 60,
                'tiempo_notificacion_min' => 15,
                'id_administrador_actualizacion' => $admin->id_usuario,
                'fecha_actualizacion' => now(),
            ]);
        }

        // 11. Auditoría Inicial del Sistema
        if (Auditoria::count() === 0) {
            Auditoria::create([
                'id_usuario' => $admin->id_usuario,
                'accion' => 'SISTEMA_INICIALIZACION',
                'resultado' => 'EXITO',
                'entidad_afectada' => 'configuracion_sistema',
                'detalle' => 'Configuración base del estudio cargada con éxito',
                'observacion' => 'Horario: 08:00 a 20:00 | Duración base: 45 min',
            ]);

            Auditoria::create([
                'id_usuario' => $admin->id_usuario,
                'accion' => 'REGISTRO_BARBERO',
                'resultado' => 'EXITO',
                'entidad_afectada' => 'usuarios',
                'detalle' => 'Barbero Mateo Silva habilitado en estación operativa #1',
                'observacion' => 'Especialidad: Fade Moderno & Degradados',
            ]);

            Auditoria::create([
                'id_usuario' => $admin->id_usuario,
                'accion' => 'CREACION_SERVICIO',
                'resultado' => 'EXITO',
                'entidad_afectada' => 'servicios',
                'detalle' => 'Nuevo servicio catálogo: Corte Fade & Barba ($35.000 COP)',
                'observacion' => 'Categoría: Cortes de Cabello',
            ]);

            Auditoria::create([
                'id_usuario' => $admin->id_usuario,
                'accion' => 'ASIGNACION_TURNO',
                'resultado' => 'EXITO',
                'entidad_afectada' => 'turnos',
                'detalle' => 'Turno #1 asignado a sala de espera',
                'observacion' => 'Cliente atendido en sala',
            ]);
        }

        // 12. Reporte Ejecutivo de Ejemplo
        if (Reporte::count() === 0) {
            Reporte::create([
                'id_generador' => $admin->id_usuario,
                'tipo_reporte' => 'RESUMEN_EJECUTIVO',
                'fecha_inicio' => now()->startOfMonth()->toDateString(),
                'fecha_fin' => now()->toDateString(),
                'datos' => [
                    'total_citas' => 5,
                    'citas_completadas' => 1,
                    'ingresos_totales' => 35000,
                    'barbero_destacado' => 'Mateo Silva',
                    'servicio_mas_vendido' => 'Corte Fade & Barba',
                ],
            ]);
        }
    }
}
