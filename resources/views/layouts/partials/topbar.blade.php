<header class="h-16 bg-white border-b border-slate-200/80 px-3 sm:px-6 lg:px-8 flex items-center justify-between shrink-0 sticky top-0 z-30 transition-all">
    <!-- Left Section: Mobile Menu Toggle & Search Input -->
    <div class="flex items-center gap-2 sm:gap-3 flex-1 max-w-md min-w-0 mr-2 sm:mr-0">
        <!-- Botón Móvil: Abrir Barra Lateral -->
        <button type="button" 
                onclick="toggleSidebar()" 
                class="md:hidden w-9 h-9 rounded-xl flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-slate-200/80 shrink-0 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#c5a059]/30 transition-all" 
                title="Abrir Menú"
                aria-label="Abrir menú de navegación">
            <i data-lucide="menu" class="w-4 h-4 sm:w-5 sm:h-5"></i>
        </button>

        @php
            $searchRoute = route('admin.citas.index');
            if (Auth::check() && Auth::user()->esBarbero()) {
                $searchRoute = route('barbero.citas.index');
            } elseif (Auth::check() && Auth::user()->esCliente()) {
                $searchRoute = route('cliente.dashboard3');
            }
        @endphp
        <form method="GET" action="{{ $searchRoute }}" class="relative w-full min-w-0">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 sm:pl-3.5 pointer-events-none text-slate-400">
                <i data-lucide="search" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
            </span>
            <input type="text" 
                name="buscar"
                value="{{ request('buscar') }}"
                placeholder="Buscar citas, clientes, turnos..." 
                class="w-full pl-8 sm:pl-10 pr-3 sm:pr-4 py-1.5 sm:py-2 bg-slate-100/80 hover:bg-slate-100 focus:bg-white border border-slate-200 focus:border-amber-500/60 focus:ring-2 focus:ring-amber-500/15 rounded-xl text-xs sm:text-sm text-slate-800 placeholder-slate-400 placeholder:truncate transition-all outline-none">
        </form>
    </div>

    <!-- Right Section: Quick CTA, Notifications, Settings & User Profile -->
    <div class="flex items-center gap-2 sm:gap-3 shrink-0">

        <!-- Notification Bell -->
        <div class="relative">
            <button type="button" 
                    class="relative w-9 h-9 rounded-xl flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-slate-200/70 transition-all cursor-pointer" 
                    title="Notificaciones">
                <i data-lucide="bell" class="w-4 h-4"></i>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
            </button>
        </div>

        <!-- Settings Icon -->
        <button type="button" 
                id="btnSettingsMenu"
                onclick="toggleSettingsMenu(event)" 
                class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-slate-100 border border-slate-200/80 active:scale-95 transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#c5a059]/30" 
                title="Configuraciones">
            <i data-lucide="settings" class="w-4 h-4 stroke-[1.75]"></i>
        </button>

        <!-- Vertical Divider -->
        <div class="h-6 w-px bg-slate-200 mx-1 hidden sm:block"></div>

        <!-- User Profile Topbar Trigger & Anclaje del Menú Desplegable -->
        <div class="relative" id="settingsMenuContainer">
            <div onclick="toggleSettingsMenu(event)" class="flex items-center gap-2.5 pl-0.5 cursor-pointer group select-none">
                <div class="w-9 h-9 rounded-full ring-1 ring-[#c5a059]/40 p-0.5 shadow-xs overflow-hidden bg-[#121319] shrink-0 flex items-center justify-center font-serif text-[#d4b26f] text-xs font-semibold group-hover:ring-[#c5a059]/80 transition-all">
                    @if(Auth::check() && Auth::user()->foto_perfil)
                        <img src="{{ Auth::user()->foto_perfil }}" alt="Avatar" class="w-full h-full rounded-full object-cover">
                    @else
                        {{ strtoupper(substr(Auth::user()->nombre ?? 'U', 0, 1)) }}
                    @endif
                </div>
                <div class="hidden lg:block text-left leading-tight">
                    <span class="block text-xs font-semibold text-slate-800 group-hover:text-slate-950 transition-colors truncate max-w-[130px]">{{ Auth::user()->nombre ?? 'Usuario' }}</span>
                    <span class="block text-[10px] font-medium text-slate-400">
                        @if(Auth::check() && Auth::user()->esAdmin())
                            Administrador
                        @elseif(Auth::check() && Auth::user()->esBarbero())
                            Barbero Pro
                        @else
                            Cliente
                        @endif
                    </span>
                </div>
            </div>

            <!-- Craftsman Obsidian Popover Menu Compacto (Alineado al extremo derecho) -->
            <div id="settingsDropdownMenu" 
                class="hidden absolute right-0 mt-2.5 w-64 max-w-[calc(100vw-1.5rem)] bg-[#111217]/95 backdrop-blur-xl rounded-2xl shadow-[0_20px_50px_-10px_rgba(0,0,0,0.7),0_0_0_1px_rgba(255,255,255,0.08)] border border-white/[0.08] z-50 p-2 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                
                <!-- Ambient Subtle Gradient -->
                <div class="absolute inset-0 bg-gradient-to-b from-white/[0.03] to-transparent pointer-events-none"></div>

                <!-- User Identity Card Compacta -->
                <div class="p-2.5 rounded-xl bg-white/[0.03] border border-white/[0.05] mb-1.5 relative z-10 flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full p-[1.5px] bg-gradient-to-b from-[#d4b26f] via-[#c5a059]/50 to-transparent shrink-0 shadow-sm">
                        <div class="w-full h-full rounded-full overflow-hidden bg-[#0d0e13] flex items-center justify-center font-serif text-[#d4b26f] text-xs font-semibold">
                            @if(Auth::check() && Auth::user()->foto_perfil)
                                <img src="{{ Auth::user()->foto_perfil }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr(Auth::user()->nombre ?? 'U', 0, 1)) }}
                            @endif
                        </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold text-stone-100 truncate tracking-tight">{{ Auth::user()->nombre ?? 'Usuario' }}</p>
                        <p class="text-[10px] text-stone-400 truncate font-normal">{{ Auth::user()->email ?? '' }}</p>
                        <span class="inline-flex items-center gap-1 mt-1 px-1.5 py-0.2 rounded text-[8.5px] font-semibold tracking-wider uppercase bg-[#c5a059]/10 text-[#d4b26f] border border-[#c5a059]/25">
                            <span class="w-1 h-1 rounded-full bg-[#c5a059]"></span>
                            @if(Auth::check() && Auth::user()->esAdmin())
                                Administrador
                            @elseif(Auth::check() && Auth::user()->esBarbero())
                                Barbero Pro
                            @else
                                Cliente
                            @endif
                        </span>
                    </div>
                </div>

                <div class="space-y-0.5 relative z-10">
                    <!-- Opción 1: Mi Perfil -->
                    <button type="button" 
                            onclick="openModalPerfil()" 
                            class="w-full flex items-center justify-between p-2 rounded-xl text-stone-300 hover:text-white hover:bg-white/[0.05] border border-transparent hover:border-white/[0.06] transition-all duration-150 text-left cursor-pointer group">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-7 h-7 rounded-lg bg-white/[0.04] border border-white/[0.07] text-stone-300 group-hover:text-[#d4b26f] group-hover:bg-[#c5a059]/10 group-hover:border-[#c5a059]/30 transition-all duration-150 flex items-center justify-center shrink-0">
                                <i data-lucide="user" class="w-3.5 h-3.5 stroke-[1.75]"></i>
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-semibold text-stone-200 group-hover:text-white transition-colors">Mi Perfil</span>
                                <span class="block text-[9.5px] text-stone-400 group-hover:text-stone-300 transition-colors">Ver y editar tu cuenta</span>
                            </div>
                        </div>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-stone-500 group-hover:text-[#d4b26f] group-hover:translate-x-0.5 transition-all duration-150 shrink-0"></i>
                    </button>

                    <div class="h-px bg-white/[0.06] my-1 mx-1"></div>

                    <!-- Opción 2: Cerrar Sesión -->
                    <form id="formCerrarSesion" action="{{ route('logout') }}" method="POST" class="w-full m-0" onsubmit="confirmarCerrarSesion(event, this)">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center justify-between p-2 rounded-xl text-stone-300 hover:bg-white/[0.05] border border-transparent hover:border-white/[0.06] transition-all duration-150 text-left cursor-pointer group">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="w-7 h-7 rounded-lg bg-white/[0.04] border border-white/[0.07] text-stone-400 group-hover:text-[#e07a68] group-hover:bg-[#d97768]/15 group-hover:border-[#d97768]/30 transition-all duration-150 flex items-center justify-center shrink-0">
                                    <i data-lucide="log-out" class="w-3.5 h-3.5 stroke-[1.75]"></i>
                                </span>
                                <div class="truncate">
                                    <span class="block text-xs font-semibold text-stone-300 group-hover:text-[#e07a68] transition-colors">Cerrar Sesión</span>
                                    <span class="block text-[9.5px] text-stone-500 group-hover:text-stone-400 transition-colors">Finalizar tu sesión actual</span>
                                </div>
                            </div>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-stone-500 group-hover:text-[#e07a68] group-hover:translate-x-0.5 transition-all duration-150 shrink-0"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- MODAL: MI PERFIL (Diseño Prémium con Cambio de Foto de Perfil) -->
<div id="modalMiPerfil" class="fixed inset-0 z-50 hidden bg-slate-950/75 backdrop-blur-md flex items-center justify-center p-3 sm:p-6 transition-all duration-300">
    <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-stone-200/80 overflow-hidden relative animate-in fade-in zoom-in-95 duration-200">
        
        <!-- Header con estética Barbería de Lujo -->
        <div class="relative bg-gradient-to-b from-[#181a23] to-[#111217] px-4 sm:px-6 pt-5 sm:pt-6 pb-6 sm:pb-7 border-b border-white/[0.08] text-white overflow-hidden">
            <!-- Destello ámbar decorativo sutil -->
            <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-[#c5a059]/10 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-white/[0.05] border border-white/[0.1] flex items-center justify-center text-[#d4b26f] shrink-0 font-bold shadow-sm">
                        <i data-lucide="user" class="w-5 h-5 stroke-[1.75]"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white font-serif text-xl tracking-tight leading-tight">Mi Perfil</h3>
                        <p class="text-xs text-stone-400 mt-0.5">Personaliza tu imagen y credenciales profesionales</p>
                    </div>
                </div>

                <button type="button" 
                        onclick="closeModalPerfil()" 
                        class="text-stone-400 hover:text-white p-2 rounded-xl hover:bg-white/10 transition-colors cursor-pointer"
                        title="Cerrar modal">
                    <i data-lucide="x" class="w-5 h-5 stroke-[1.75]"></i>
                </button>
            </div>

            <!-- Form Oculto para Subir Foto -->
            <form id="formSubirFoto" action="{{ route('perfil.foto.update') }}" method="POST" enctype="multipart/form-data" class="hidden">
                @csrf
                <input type="file" name="foto" id="inputFotoPerfil" accept="image/png,image/jpeg,image/webp,image/gif" onchange="previewSelectedPhoto(this)">
            </form>

            <!-- Tarjeta Central de Identidad con Avatar Interactivo -->
            <div class="relative z-10 mt-6 pt-2 text-center">
                <div class="relative inline-block mx-auto">
                    <!-- Contenedor Avatar con Aro Oro Champagne -->
                    <div onclick="document.getElementById('inputFotoPerfil').click()" 
                        class="w-24 h-24 sm:w-28 sm:h-28 rounded-full p-1 bg-gradient-to-b from-[#d4b26f] via-[#c5a059]/60 to-[#8a6a2c]/30 shadow-xl group relative cursor-pointer mx-auto transition-transform hover:scale-[1.02]"
                        title="Clic para subir o cambiar foto">
                        <div class="w-full h-full rounded-full overflow-hidden bg-[#0d0e13] flex items-center justify-center text-[#d4b26f] text-3xl font-bold font-serif relative">
                            @if(Auth::check() && Auth::user()->foto_perfil)
                                <img id="previewAvatarImg" src="{{ Auth::user()->foto_perfil }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <span id="previewAvatarInitial" class="w-full h-full flex items-center justify-center bg-[#13141b]">
                                    {{ strtoupper(substr(Auth::user()->nombre ?? 'U', 0, 1)) }}
                                </span>
                                <img id="previewAvatarImgPlaceholder" src="" alt="Nueva Foto" class="w-full h-full object-cover hidden">
                            @endif

                            <!-- Overlay al pasar el cursor -->
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col items-center justify-center text-white backdrop-blur-[2px]">
                                <i data-lucide="camera" class="w-6 h-6 text-[#d4b26f] mb-0.5 stroke-[1.75]"></i>
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-[#e2c992]">Cambiar</span>
                            </div>
                        </div>
                    </div>

                    <!-- Botón Flotante Cámara -->
                    <button type="button" 
                            onclick="document.getElementById('inputFotoPerfil').click()" 
                            class="absolute bottom-0 right-0 w-8 h-8 rounded-full gold-gradient text-slate-950 flex items-center justify-center shadow-lg ring-3 ring-[#111217] hover:scale-105 active:scale-95 transition-all cursor-pointer" 
                            title="Seleccionar foto">
                        <i data-lucide="camera" class="w-4 h-4 stroke-[2]"></i>
                    </button>
                </div>

                <!-- Barra de confirmación de subida (Aparece tras seleccionar archivo) -->
                <div id="photoConfirmationBar" class="hidden mt-4 p-3 rounded-2xl bg-white/[0.05] border border-[#c5a059]/30 flex flex-wrap items-center justify-between gap-3 animate-in fade-in duration-200">
                    <div class="flex items-center gap-2 text-xs font-medium text-stone-200 truncate">
                        <i data-lucide="image" class="w-4 h-4 text-[#d4b26f] shrink-0"></i>
                        <span id="selectedFileName" class="truncate max-w-[170px]">Nueva foto lista</span>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <button type="button" onclick="cancelPhotoSelection()" class="px-3 py-1.5 rounded-xl border border-stone-700 hover:bg-stone-800 text-stone-300 text-xs font-medium transition-colors cursor-pointer">
                            Cancelar
                        </button>
                        <button type="button" onclick="document.getElementById('formSubirFoto').submit()" class="px-4 py-1.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 text-xs font-bold uppercase tracking-wider flex items-center gap-1.5 shadow-md active:scale-95 transition-all cursor-pointer">
                            <i data-lucide="check" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                            <span>Guardar Foto</span>
                        </button>
                    </div>
                </div>

                <!-- Nombre, Correo y Rol -->
                <div class="mt-3.5">
                    <h4 class="text-xl font-bold text-white font-serif tracking-tight">{{ Auth::user()->nombre ?? 'Usuario' }}</h4>
                    <p class="text-xs text-stone-400 mt-0.5">{{ Auth::user()->email ?? '' }}</p>

                    <div class="flex items-center justify-center gap-2 mt-2.5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-[10px] font-semibold uppercase tracking-wider bg-[#c5a059]/10 text-[#d4b26f] border border-[#c5a059]/25">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#c5a059]"></span>
                            @if(Auth::check() && Auth::user()->id_rol == 1)
                                Administrador
                            @elseif(Auth::check() && Auth::user()->id_rol == 2)
                                Barbero Profesional
                            @else
                                Cliente
                            @endif
                        </span>

                        @if(Auth::check() && Auth::user()->foto_perfil)
                            <form id="formEliminarFoto" action="{{ route('perfil.foto.destroy') }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('¿Deseas restablecer tu foto al avatar por defecto?')" 
                                        class="px-2.5 py-1 rounded-md text-[10px] font-medium text-stone-400 hover:text-rose-400 bg-white/5 hover:bg-rose-500/10 border border-stone-700 hover:border-rose-500/30 transition-all cursor-pointer inline-flex items-center gap-1"
                                        title="Eliminar foto personalizada">
                                    <i data-lucide="trash-2" class="w-3 h-3"></i>
                                    <span>Quitar foto</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Bento Grid de Información de la Cuenta -->
        <div class="p-4 sm:p-6 bg-[#faf9f6] space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                
                <!-- Teléfono -->
                <div class="p-3.5 rounded-2xl bg-white border border-stone-200/80 shadow-2xs flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-stone-100 border border-stone-200 flex items-center justify-center text-stone-700 shrink-0">
                        <i data-lucide="phone" class="w-4 h-4 stroke-[1.75]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[10px] font-semibold text-stone-400 uppercase tracking-wider">Teléfono</span>
                        <span class="font-semibold text-stone-800 text-xs truncate block mt-0.5">
                            {{ Auth::user()->telefono ?? 'No registrado' }}
                        </span>
                    </div>
                </div>

                <!-- Estado de Cuenta -->
                <div class="p-3.5 rounded-2xl bg-white border border-stone-200/80 shadow-2xs flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 border border-emerald-200/60 flex items-center justify-center text-emerald-700 shrink-0">
                        <i data-lucide="shield-check" class="w-4 h-4 stroke-[1.75]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[10px] font-semibold text-stone-400 uppercase tracking-wider">Estado</span>
                        <span class="font-semibold text-emerald-700 text-xs flex items-center gap-1.5 mt-0.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            {{ Auth::user()->estado ?? 'ACTIVO' }}
                        </span>
                    </div>
                </div>

                <!-- Especialidad o Cargo -->
                <div class="p-3.5 rounded-2xl bg-white border border-stone-200/80 shadow-2xs flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-stone-100 border border-stone-200 flex items-center justify-center text-stone-700 shrink-0">
                        <i data-lucide="scissors" class="w-4 h-4 stroke-[1.75]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[10px] font-semibold text-stone-400 uppercase tracking-wider">
                            {{ (Auth::check() && Auth::user()->id_rol == 2) ? 'Especialidad' : 'Cargo / Perfil' }}
                        </span>
                        <span class="font-semibold text-stone-800 text-xs truncate block mt-0.5">
                            {{ Auth::user()->especialidad ?? Auth::user()->cargo ?? 'Estilismo & Barbería' }}
                        </span>
                    </div>
                </div>

                <!-- Miembro Desde -->
                <div class="p-3.5 rounded-2xl bg-white border border-stone-200/80 shadow-2xs flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-stone-100 border border-stone-200 flex items-center justify-center text-stone-700 shrink-0">
                        <i data-lucide="calendar" class="w-4 h-4 stroke-[1.75]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[10px] font-semibold text-stone-400 uppercase tracking-wider">Miembro Desde</span>
                        <span class="font-semibold text-stone-800 text-xs truncate block mt-0.5 capitalize">
                            {{ Auth::user()->fecha_ingreso ? \Carbon\Carbon::parse(Auth::user()->fecha_ingreso)->locale('es')->isoFormat('D [de] MMMM, YYYY') : (Auth::user()->fecha_registro ? \Carbon\Carbon::parse(Auth::user()->fecha_registro)->locale('es')->isoFormat('D [de] MMMM, YYYY') : 'Reciente') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Footer del Modal -->
            <div class="pt-3 border-t border-stone-200/70 flex items-center justify-between">
                <span class="text-[11px] text-stone-400 flex items-center gap-1.5 font-medium">
                    <i data-lucide="lock" class="w-3.5 h-3.5 text-stone-400 stroke-[1.75]"></i>
                    <span>Sesión cifrada y segura</span>
                </span>
                <button type="button" 
                        onclick="closeModalPerfil()" 
                        class="px-5 py-2 rounded-xl bg-[#14151b] hover:bg-[#20222b] text-white font-semibold text-xs uppercase tracking-wider transition-all active:scale-95 cursor-pointer shadow-xs border border-white/10">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let originalAvatarSrc = null;

    function toggleSettingsMenu(event) {
        if (event) event.stopPropagation();
        const menu = document.getElementById('settingsDropdownMenu');
        if (menu) {
            menu.classList.toggle('hidden');
            if (!menu.classList.contains('hidden') && window.lucide) {
                lucide.createIcons();
            }
        }
    }

    function closeSettingsMenu() {
        const menu = document.getElementById('settingsDropdownMenu');
        if (menu) {
            menu.classList.add('hidden');
        }
    }

    function openModalPerfil() {
        closeSettingsMenu();
        const modal = document.getElementById('modalMiPerfil');
        if (modal) {
            modal.classList.remove('hidden');
            if (window.lucide) {
                lucide.createIcons();
            }
        }
    }

    function closeModalPerfil() {
        cancelPhotoSelection();
        const modal = document.getElementById('modalMiPerfil');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function previewSelectedPhoto(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validar tamaño máximo: 5MB
            if (file.size > 5 * 1024 * 1024) {
                alert('La imagen seleccionada supera el límite de 5MB.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('previewAvatarImg');
                const previewInitial = document.getElementById('previewAvatarInitial');
                const previewPlaceholder = document.getElementById('previewAvatarImgPlaceholder');
                const confirmBar = document.getElementById('photoConfirmationBar');
                const fileNameSpan = document.getElementById('selectedFileName');

                if (previewImg) {
                    if (!originalAvatarSrc) originalAvatarSrc = previewImg.src;
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                } else if (previewPlaceholder) {
                    if (previewInitial) previewInitial.classList.add('hidden');
                    previewPlaceholder.src = e.target.result;
                    previewPlaceholder.classList.remove('hidden');
                }

                if (fileNameSpan) {
                    fileNameSpan.textContent = file.name;
                }
                if (confirmBar) {
                    confirmBar.classList.remove('hidden');
                    if (window.lucide) lucide.createIcons();
                }
            };
            reader.readAsDataURL(file);
        }
    }

    function cancelPhotoSelection() {
        const input = document.getElementById('inputFotoPerfil');
        if (input) input.value = '';

        const confirmBar = document.getElementById('photoConfirmationBar');
        if (confirmBar) confirmBar.classList.add('hidden');

        const previewImg = document.getElementById('previewAvatarImg');
        const previewInitial = document.getElementById('previewAvatarInitial');
        const previewPlaceholder = document.getElementById('previewAvatarImgPlaceholder');

        if (previewImg && originalAvatarSrc) {
            previewImg.src = originalAvatarSrc;
        } else {
            if (previewPlaceholder) {
                previewPlaceholder.src = '';
                previewPlaceholder.classList.add('hidden');
            }
            if (previewInitial) {
                previewInitial.classList.remove('hidden');
            }
        }
    }

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', function(e) {
        const container = document.getElementById('settingsMenuContainer');
        const btn = document.getElementById('btnSettingsMenu');
        if (container && !container.contains(e.target) && (!btn || !btn.contains(e.target))) {
            closeSettingsMenu();
        }
    });

    // Cerrar menú y modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSettingsMenu();
            closeModalPerfil();
        }
    });
</script>
