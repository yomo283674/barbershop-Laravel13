<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbershop | Inicia Sesión</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-black': '#111111',
                        'brand-gray': '#666666',
                        'brand-light': '#F6F6F4',
                        'brand-accent': '#C5A059',
                    },
                    fontFamily: {
                        'serif': ['Arial', '"Helvetica Neue"', 'Helvetica', 'sans-serif'],
                        'sans': ['Arial', '"Helvetica Neue"', 'Helvetica', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body, button, input, select, textarea, h1, h2, h3, h4, span, p {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif !important;
        }
    </style>
</head>

<body
    class="bg-[#F3F3F0] min-h-screen text-brand-black antialiased flex items-center justify-center p-2 sm:p-6 lg:p-10 py-4 sm:py-8">

    <!-- Tarjeta de alerta SweetAlert2 y Redirección -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: '{{ session("success") }}',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                }).then(() => {
                    @if (session('redirect_url'))
                        window.location.href = "{{ session('redirect_url') }}";
                    @endif
                });
            });
        </script>
    @endif

    <div
        class="w-full max-w-[1240px] bg-white rounded-2xl sm:rounded-3xl shadow-[0_25px_65px_-15px_rgba(0,0,0,0.09),0_10px_20px_-10px_rgba(0,0,0,0.04)] flex flex-col md:flex-row overflow-hidden border border-gray-200/90 my-auto relative">

        <!-- COLUMNA IZQUIERDA: FORMULARIO DE LOGIN -->
        <div class="w-full md:w-1/2 p-5 sm:p-10 lg:p-14 flex flex-col justify-between bg-white relative">

            <!-- Botón Atrás (Esquina Superior Izquierda Refinado) -->
            <a href="/"
                class="absolute top-5 left-5 sm:top-7 sm:left-7 inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2.5 rounded-xl bg-[#F4F4F1] hover:bg-stone-900 hover:text-white hover:border-stone-900 text-xs sm:text-sm font-bold tracking-wider text-brand-black border border-stone-200/90 transition-all duration-300 group shadow-sm z-20">
                <i data-lucide="arrow-left"
                    class="w-4 h-4 text-brand-black group-hover:text-brand-accent group-hover:-translate-x-1 transition-all"></i>
                <span>Atrás</span>
            </a>

            <!-- Brand Header Emblem -->
            <div class="flex flex-col items-center justify-center text-center mt-5 sm:mt-1 mb-3 group">
                <img src="{{ asset('images/barber-logo-combined.png') }}" alt="Barbershop Emblem"
                    class="w-16 h-16 sm:w-18 sm:h-18 object-contain drop-shadow-md mb-2 group-hover:scale-105 transition-transform duration-300">

                <!-- Title con BARBER (Negro) y SHOP (Dorado Cursiva) sin fondo negro -->
                <div class="flex items-center gap-2.5">
                    <span class="h-[1px] w-5 bg-brand-accent/40"></span>
                    <span
                        class="font-serif font-bold text-xl tracking-[0.25em] text-brand-black uppercase block leading-none pl-1">
                        BARBER<span class="text-brand-accent italic font-normal tracking-[0.2em]">SHOP</span>
                    </span>
                    <span class="h-[1px] w-5 bg-brand-accent/40"></span>
                </div>
            </div>

            <!-- Header Content -->
            <div class="my-auto py-4 sm:py-6">
                <div class="mb-6 sm:mb-8">
                    <h1
                        class="font-serif text-2xl sm:text-3xl lg:text-[38px] font-bold text-brand-black tracking-tight leading-tight">
                        Iniciar sesión
                    </h1>
                    <p
                        class="text-brand-gray text-xs sm:text-sm lg:text-base mt-2 sm:mt-2.5 leading-relaxed font-normal">
                        Accede a tu cuenta para gestionar tus reservas y preferencias.
                    </p>
                </div>

                <!-- Formulario -->
                <form action="{{ route('login') }}" method="POST" class="space-y-4 sm:space-y-5">
                    @csrf
                    <!-- Field Email -->
                    <div>
                        <label for="email"
                            class="block text-[11px] font-bold text-brand-black uppercase tracking-[0.12em] mb-1.5 sm:mb-2">
                            Correo electrónico
                        </label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-accent transition-colors">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="tu@ejemplo.com"
                                class="block w-full pl-11 pr-4 py-3 sm:py-3.5 bg-[#F9F9F8] border border-gray-200 rounded-xl text-base sm:text-sm text-brand-black placeholder:text-gray-400 focus:bg-white focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all outline-none font-normal shadow-sm">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Field Password -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5 sm:mb-2">
                            <label for="password"
                                class="block text-[11px] font-bold text-brand-black uppercase tracking-[0.12em]">
                                Contraseña
                            </label>
                            <a href="#"
                                class="text-xs font-semibold text-brand-accent hover:text-brand-black transition-colors">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-accent transition-colors">
                                <i data-lucide="lock" class="w-5 h-5"></i>
                            </div>
                            <input type="password" id="password" name="password" required placeholder="••••••••"
                                class="block w-full pl-11 pr-12 py-3 sm:py-3.5 bg-[#F9F9F8] border border-gray-200 rounded-xl text-base sm:text-sm text-brand-black placeholder:text-gray-400 focus:bg-white focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all outline-none font-normal shadow-sm">

                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-brand-accent transition-colors focus:outline-none">
                                <i data-lucide="eye" id="eyeIcon" class="w-5 h-5"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember me -->
                    <div class="pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 rounded border-gray-300 text-brand-accent focus:ring-brand-accent accent-brand-accent cursor-pointer">
                            <span class="text-xs font-medium text-brand-gray">Recordarme en este dispositivo</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-4 px-6 bg-brand-black hover:bg-stone-900 active:scale-[0.99] text-white font-bold text-sm tracking-wide rounded-xl transition-all duration-200 flex items-center justify-center gap-2.5 shadow-lg shadow-black/10 hover:shadow-black/20 group mt-4 border border-brand-accent/30 hover:border-brand-accent/70">
                        <span>Iniciar sesión</span>
                        <i data-lucide="arrow-right"
                            class="w-4 h-4 text-brand-accent group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>
            </div>

            <!-- Footer Link -->
            <div class="pt-5 border-t border-gray-100 text-center">
                <p class="text-xs sm:text-sm text-brand-gray">
                    ¿No tienes una cuenta?
                    <a href="/register"
                        class="font-semibold text-brand-black hover:text-brand-accent transition-colors underline decoration-brand-accent/40 underline-offset-4">Crear
                        una cuenta</a>
                </p>
            </div>
        </div>

        <!-- COLUMNA DERECHA: SECCIÓN EDITORIAL E IMAGEN PREMIUM -->
        <div
            class="hidden md:flex w-1/2 relative min-h-[640px] bg-brand-black flex-col justify-between p-10 sm:p-12 lg:p-16 text-white overflow-hidden group">

            <!-- Imagen de Fondo Editorial Realista & Profesional -->
            <div
                class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1621605815971-fbc98d665033?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-85 transform scale-105 group-hover:scale-100 transition-transform duration-1000">
            </div>

            <!-- Overlay Elegante con Iluminación Equilibrada -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/20"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-black/40 via-transparent to-black/20"></div>

            <!-- Contenido Editorial Principal -->
            <div class="relative z-10 my-auto py-8">
                <h2
                    class="font-serif text-3xl sm:text-4xl lg:text-[44px] font-bold leading-[1.18] mb-5 text-white tracking-tight">
                    El arte del <br class="hidden xl:inline"><span class="italic font-normal text-brand-accent">cuidado
                        masculino.</span>
                </h2>
                <p
                    class="text-gray-300 text-sm sm:text-base leading-relaxed font-normal max-w-md border-l-2 border-brand-accent/50 pl-4 py-0.5">
                    Tradición, precisión y excelencia en cada servicio. Un espacio exclusivo diseñado para el caballero
                    contemporáneo.
                </p>
            </div>
        </div>

    </div>

    <!-- Script de Lucide Icons e Interactividad -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (toggleBtn && passwordInput && eyeIcon) {
                toggleBtn.addEventListener('click', () => {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    eyeIcon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
                    lucide.createIcons();
                });
            }
        });
    </script>
</body>

</html>