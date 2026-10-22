<aside id="mainSidebar" 
    style="background-color: #0b0c10; border-color: #1a1b22;" 
    class="fixed md:relative inset-y-0 left-0 md:inset-auto z-50 md:z-20 w-64 h-full min-h-screen bg-[#0b0c10] text-zinc-300 flex flex-col shrink-0 border-r border-[#1a1b22] sidebar-open shadow-2xl md:shadow-none"
    onmouseenter="showSidebar()"
    onmouseleave="hideSidebar()">
    <!-- Brand / Logo & Navigation -->
    <div class="flex-1 overflow-y-auto pb-6">
        <!-- Brand Header -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-zinc-800/70" style="border-bottom-color: #1a1b22;">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl overflow-hidden shadow-lg shadow-amber-500/20 shrink-0 border border-amber-500/30 bg-[#07080a] flex items-center justify-center">
                    <img src="{{ asset('images/barber-sidebar-logo.jpg') }}" alt="Logo Barbershop" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="text-xl font-bold uppercase block select-none text-white" style="letter-spacing: 2.5px;">
                        BARBER<span class="italic font-bold" style="color: #c5a059;">SHOP</span>
                    </span>
                </div>
            </div>
            <!-- Mobile Close Button -->
            <button type="button" 
                    onclick="hideSidebarImmediate()" 
                    class="md:hidden w-8 h-8 rounded-lg flex items-center justify-center text-zinc-400 hover:text-white hover:bg-zinc-800/80 border border-zinc-800 transition-all cursor-pointer" 
                    title="Cerrar Menú"
                    aria-label="Cerrar menú">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-4 px-3 space-y-1.5">
            @if(Auth::check() && Auth::user()->esAdmin())
                <!-- MENÚ ADMINISTRADOR -->
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard1') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('administrador/dashboard*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 {{ request()->is('administrador/dashboard*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Inicio</span>
                </a>

                <!-- Citas y Agenda -->
                <a href="{{ route('admin.citas.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('administrador/citas*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="calendar" class="w-4 h-4 {{ request()->is('administrador/citas*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Citas</span>
                    @if(($adminCitasPendientes ?? 0) > 0)
                        <span class="ml-auto bg-amber-400/15 text-amber-300 text-xs px-2 py-0.5 rounded-full font-semibold">{{ $adminCitasPendientes }}</span>
                    @endif
                </a>

                <!-- Turnos en Sala -->
                <a href="{{ route('admin.turnos.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('administrador/turnos*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="list-ordered" class="w-4 h-4 {{ request()->is('administrador/turnos*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Turnos en Sala</span>
                    @if(($adminTurnosEnEspera ?? 0) > 0)
                        <span class="ml-auto bg-emerald-400/15 text-emerald-300 text-[10px] px-1.5 py-0.5 rounded-full font-bold">{{ $adminTurnosEnEspera }} en espera</span>
                    @endif
                </a>

                <!-- Barberos -->
                <a href="{{ route('admin.barberos.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('administrador/barberos*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="users" class="w-4 h-4 {{ request()->is('administrador/barberos*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Barberos</span>
                    <span class="ml-auto bg-zinc-800 text-zinc-300 text-[10px] px-1.5 py-0.5 rounded-full font-semibold">{{ $adminBarberosCount ?? 0 }}</span>
                </a>

                <!-- Servicios -->
                <a href="{{ route('admin.servicios.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('administrador/servicios*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="sparkles" class="w-4 h-4 {{ request()->is('administrador/servicios*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Servicios</span>
                    <span class="ml-auto bg-zinc-800 text-zinc-300 text-[10px] px-1.5 py-0.5 rounded-full font-semibold">{{ $adminServiciosCount ?? 0 }}</span>
                </a>

                <!-- Clientes -->
                <a href="{{ route('admin.clientes.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('administrador/clientes*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="user-check" class="w-4 h-4 {{ request()->is('administrador/clientes*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Clientes</span>
                    <span class="ml-auto bg-zinc-800 text-zinc-300 text-[10px] px-1.5 py-0.5 rounded-full font-semibold">{{ $adminClientesCount ?? 0 }}</span>
                </a>

                <!-- Reportes y Auditoría -->
                <a href="{{ route('admin.auditoria.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('administrador/auditoria*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="shield-check" class="w-4 h-4 {{ request()->is('administrador/auditoria*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Auditoría y Reportes</span>
                </a>

                <!-- Configuración Sistema -->
                <a href="{{ route('admin.configuracion.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('administrador/configuracion*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="settings" class="w-4 h-4 {{ request()->is('administrador/configuracion*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Configuración</span>
                </a>

            @elseif(Auth::check() && Auth::user()->esBarbero())
                <!--MENÚ BARBERO-->
                <!-- Mi Estación (Dashboard) -->
                <a href="{{ route('barbero.dashboard2') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('barbero/dashboard*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 {{ request()->is('barbero/dashboard*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Inicio</span>
                </a>

                <!-- Mis Servicios -->
                <a href="{{ route('barbero.servicios.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('barbero/servicios*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="scissors" class="w-4 h-4 {{ request()->is('barbero/servicios*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Mis Servicios</span>
                    <span class="ml-auto bg-amber-400/10 text-amber-300 text-[10px] px-1.5 py-0.5 rounded-full font-bold">{{ $misServiciosCount ?? 0 }} activos</span>
                </a>

                <!-- Mi Agenda y Citas -->
                <a href="{{ route('barbero.citas.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('barbero/citas*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="calendar" class="w-4 h-4 {{ request()->is('barbero/citas*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Mi Agenda</span>
                    @if(($misCitasPendientes ?? 0) > 0)
                        <span class="ml-auto bg-amber-400/15 text-amber-300 text-xs px-2 py-0.5 rounded-full font-semibold">{{ $misCitasPendientes }}</span>
                    @endif
                </a>

                <!-- Turnos en Sala -->
                <a href="{{ route('barbero.turnos.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('barbero/turnos*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="list-ordered" class="w-4 h-4 {{ request()->is('barbero/turnos*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Turnos en Sala</span>
                    @if(($misTurnosEnEspera ?? 0) > 0)
                        <span class="ml-auto bg-emerald-400/15 text-emerald-300 text-[10px] px-1.5 py-0.5 rounded-full font-bold">{{ $misTurnosEnEspera }} en espera</span>
                    @endif
                </a>

                <!-- Mi Disponibilidad y Horario -->
                <a href="{{ route('barbero.disponibilidad.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('barbero/disponibilidad*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="clock" class="w-4 h-4 {{ request()->is('barbero/disponibilidad*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Mi Horario</span>
                </a>

                <!-- Mis Comisiones y Rendimiento -->
                <a href="{{ route('barbero.comisiones.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('barbero/comisiones*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="badge-percent" class="w-4 h-4 {{ request()->is('barbero/comisiones*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Mis Comisiones</span>
                </a>

            @else
                <!-- MENÚ CLIENTE-->
                <!-- Inicio / Dashboard -->
                <a href="{{ route('cliente.dashboard3') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('cliente/dashboard*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 {{ request()->is('cliente/dashboard*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Inicio</span>
                </a>

                <!-- Mis Citas & Historial -->
                <a href="{{ route('cliente.citas.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('cliente/citas*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="calendar" class="w-4 h-4 {{ request()->is('cliente/citas*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Mis Citas</span>
                </a>

                <!-- Equipo de Barberos & Portafolio -->
                <a href="{{ route('cliente.barberos.index') }}" 
                class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->is('cliente/barberos*') ? 'bg-[#17181f] text-amber-400 font-semibold shadow-sm border-l-4 border-amber-400' : 'text-zinc-400 hover:text-white hover:bg-zinc-900/80' }}">
                    <i data-lucide="users" class="w-4 h-4 {{ request()->is('cliente/barberos*') ? 'text-amber-400' : 'text-zinc-500' }}"></i>
                    <span>Barberos y Cortes</span>
                </a>
            @endif
        </nav>
    </div>
</aside>
