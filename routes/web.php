<?php

use App\Http\Controllers\AdminAuditoriaController;
use App\Http\Controllers\AdminBarberoController;
use App\Http\Controllers\AdminCitaController;
use App\Http\Controllers\AdminClienteController;
use App\Http\Controllers\AdminConfiguracionController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminServicioController;
use App\Http\Controllers\AdminTurnoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarberoCitaController;
use App\Http\Controllers\BarberoComisionController;
use App\Http\Controllers\BarberoDashboardController;
use App\Http\Controllers\BarberoDisponibilidadController;
use App\Http\Controllers\BarberoServicioController;
use App\Http\Controllers\BarberoTurnoController;
use App\Http\Controllers\ClienteDashboardController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('sitioweb');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rutas comunes de Perfil (todos los roles autenticados)
Route::middleware('auth')->group(function () {
    Route::post('/perfil/foto', [PerfilController::class, 'actualizarFoto'])->name('perfil.foto.update');
    Route::delete('/perfil/foto', [PerfilController::class, 'eliminarFoto'])->name('perfil.foto.destroy');
    Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.update');
});

// Rutas protegidas para Administradores (rol: 1)
Route::middleware(['auth', 'role:1'])->group(function () {
    // Admin Dashboard
    Route::get('/administrador/dashboard1', [AdminDashboardController::class, 'index'])->name('admin.dashboard1');

    // Módulo de Citas
    Route::get('/administrador/citas', [AdminCitaController::class, 'index'])->name('admin.citas.index');
    Route::post('/administrador/citas', [AdminCitaController::class, 'store'])->name('admin.citas.store');
    Route::put('/administrador/citas/{cita}', [AdminCitaController::class, 'update'])->name('admin.citas.update');
    Route::patch('/administrador/citas/{cita}/estado', [AdminCitaController::class, 'cambiarEstado'])->name('admin.citas.estado');
    Route::delete('/administrador/citas/{cita}', [AdminCitaController::class, 'destroy'])->name('admin.citas.destroy');

    // Módulo de Turnos
    Route::get('/administrador/turnos', [AdminTurnoController::class, 'index'])->name('admin.turnos.index');
    Route::post('/administrador/turnos', [AdminTurnoController::class, 'store'])->name('admin.turnos.store');
    Route::patch('/administrador/turnos/{turno}/llamar', [AdminTurnoController::class, 'llamar'])->name('admin.turnos.llamar');
    Route::patch('/administrador/turnos/{turno}/finalizar', [AdminTurnoController::class, 'finalizar'])->name('admin.turnos.finalizar');
    Route::delete('/administrador/turnos/{turno}', [AdminTurnoController::class, 'destroy'])->name('admin.turnos.destroy');

    // Módulo de Barberos
    Route::get('/administrador/barberos', [AdminBarberoController::class, 'index'])->name('admin.barberos.index');
    Route::post('/administrador/barberos', [AdminBarberoController::class, 'store'])->name('admin.barberos.store');
    Route::put('/administrador/barberos/{barbero}', [AdminBarberoController::class, 'update'])->name('admin.barberos.update');
    Route::patch('/administrador/barberos/{barbero}/estado', [AdminBarberoController::class, 'cambiarEstado'])->name('admin.barberos.estado');

    // Módulo de Servicios
    Route::get('/administrador/servicios', [AdminServicioController::class, 'index'])->name('admin.servicios.index');
    Route::post('/administrador/servicios', [AdminServicioController::class, 'store'])->name('admin.servicios.store');
    Route::put('/administrador/servicios/{servicio}', [AdminServicioController::class, 'update'])->name('admin.servicios.update');
    Route::patch('/administrador/servicios/{servicio}/estado', [AdminServicioController::class, 'cambiarEstado'])->name('admin.servicios.estado');
    Route::delete('/administrador/servicios/{servicio}/imagen', [AdminServicioController::class, 'eliminarImagen'])->name('admin.servicios.imagen.destroy');
    Route::post('/administrador/servicios/categoria', [AdminServicioController::class, 'storeCategoria'])->name('admin.servicios.categoria');

    // Módulo de Clientes
    Route::get('/administrador/clientes', [AdminClienteController::class, 'index'])->name('admin.clientes.index');
    Route::post('/administrador/clientes', [AdminClienteController::class, 'store'])->name('admin.clientes.store');
    Route::put('/administrador/clientes/{cliente}', [AdminClienteController::class, 'update'])->name('admin.clientes.update');
    Route::patch('/administrador/clientes/{cliente}/estado', [AdminClienteController::class, 'cambiarEstado'])->name('admin.clientes.estado');
    Route::get('/administrador/clientes/{cliente}/historial', [AdminClienteController::class, 'historial'])->name('admin.clientes.historial');

    // Módulo de Auditoría y Reportes
    Route::get('/administrador/auditoria', [AdminAuditoriaController::class, 'index'])->name('admin.auditoria.index');
    Route::post('/administrador/auditoria/reporte', [AdminAuditoriaController::class, 'generarReporte'])->name('admin.auditoria.reporte');

    // Módulo de Configuración
    Route::get('/administrador/configuracion', [AdminConfiguracionController::class, 'index'])->name('admin.configuracion.index');
    Route::put('/administrador/configuracion', [AdminConfiguracionController::class, 'update'])->name('admin.configuracion.update');

    // Gestión de reprogramaciones desde el Dashboard
    Route::patch('/administrador/reprogramaciones/{reprogramacion}', [AdminDashboardController::class, 'gestionarReprogramacion'])->name('admin.reprogramaciones.gestionar');
});

// Rutas protegidas para Barberos (rol: 2)
Route::middleware(['auth', 'role:2'])->prefix('barbero')->as('barbero.')->group(function () {
    // Dashboard / Inicio
    Route::get('/dashboard2', [BarberoDashboardController::class, 'index'])->name('dashboard2');

    // Módulo Mis Servicios (Cada barbero crea y gestiona sus propios servicios)
    Route::get('/servicios', [BarberoServicioController::class, 'index'])->name('servicios.index');
    Route::post('/servicios', [BarberoServicioController::class, 'store'])->name('servicios.store');
    Route::put('/servicios/{servicio}', [BarberoServicioController::class, 'update'])->name('servicios.update');
    Route::patch('/servicios/{servicio}/estado', [BarberoServicioController::class, 'cambiarEstado'])->name('servicios.estado');
    Route::delete('/servicios/{servicio}', [BarberoServicioController::class, 'destroy'])->name('servicios.destroy');
    Route::delete('/servicios/{servicio}/imagen', [BarberoServicioController::class, 'eliminarImagen'])->name('servicios.imagen.destroy');

    // Módulo Mi Agenda / Citas
    Route::get('/citas', [BarberoCitaController::class, 'index'])->name('citas.index');
    Route::patch('/citas/{cita}/estado', [BarberoCitaController::class, 'cambiarEstado'])->name('citas.estado');
    Route::patch('/citas/{cita}/iniciar', [BarberoCitaController::class, 'iniciarServicio'])->name('citas.iniciar');
    Route::patch('/citas/{cita}/finalizar', [BarberoCitaController::class, 'finalizar'])->name('citas.finalizar');
    Route::post('/citas/{cita}/reprogramar', [BarberoCitaController::class, 'reprogramar'])->name('citas.reprogramar');

    // Módulo Turnos en Sala
    Route::get('/turnos', [BarberoTurnoController::class, 'index'])->name('turnos.index');
    Route::patch('/turnos/{turno}/llamar', [BarberoTurnoController::class, 'llamar'])->name('turnos.llamar');
    Route::patch('/turnos/{turno}/finalizar', [BarberoTurnoController::class, 'finalizar'])->name('turnos.finalizar');

    // Módulo Mi Horario y Disponibilidad
    Route::get('/disponibilidad', [BarberoDisponibilidadController::class, 'index'])->name('disponibilidad.index');
    Route::post('/disponibilidad', [BarberoDisponibilidadController::class, 'store'])->name('disponibilidad.store');
    Route::delete('/disponibilidad/{disponibilidad}', [BarberoDisponibilidadController::class, 'destroy'])->name('disponibilidad.destroy');

    // Módulo Mis Comisiones y Rendimiento
    Route::get('/comisiones', [BarberoComisionController::class, 'index'])->name('comisiones.index');
});

// Rutas protegidas para Clientes (rol: 3)
Route::middleware(['auth', 'role:3'])->prefix('cliente')->as('cliente.')->group(function () {
    // Dashboard principal y turno en vivo
    Route::get('/dashboard3', [ClienteDashboardController::class, 'index'])->name('dashboard3');

    // Catálogo e historial de citas
    Route::get('/citas', [ClienteDashboardController::class, 'citas'])->name('citas.index');
    Route::post('/citas', [ClienteDashboardController::class, 'reservar'])->name('citas.store');
    Route::patch('/citas/{cita}/cancelar', [ClienteDashboardController::class, 'cancelar'])->name('citas.cancelar');

    // Cálculo dinámico de horarios libres
    Route::get('/horarios-disponibles', [ClienteDashboardController::class, 'horariosDisponibles'])->name('horarios.disponibles');

    // Gestión de reprogramaciones
    Route::match(['post', 'patch'], '/reprogramaciones/{reprogramacion}/responder', [ClienteDashboardController::class, 'responderReprogramacion'])->name('reprogramaciones.responder');

    // Directorio de barberos y portafolio visual
    Route::get('/barberos', [ClienteDashboardController::class, 'barberos'])->name('barberos.index');
});
