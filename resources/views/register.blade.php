<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbershop | Crea tu Cuenta</title>
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
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    // Redirigir al login al terminar los segundos de la alerta
                    window.location.href = "{{ route('login') }}";
                });
            });
        </script>
    @endif

    <!-- TARJETA PRINCIPAL FLOATING CARD (IGUAL A LOGIN) -->
    <div
        class="w-full max-w-[1240px] bg-white rounded-2xl sm:rounded-3xl shadow-[0_25px_65px_-15px_rgba(0,0,0,0.09),0_10px_20px_-10px_rgba(0,0,0,0.04)] flex flex-col md:flex-row overflow-hidden border border-gray-200/90 my-auto relative">

        <!-- COLUMNA IZQUIERDA: FORMULARIO DE REGISTRO -->
        <div class="w-full md:w-1/2 p-5 sm:p-10 lg:p-12 flex flex-col justify-between bg-white relative">

            <!-- Brand Header Emblem -->
            <div class="flex flex-col items-center justify-center text-center mt-3 sm:mt-1 mb-2 sm:mb-3 group">
                <img src="{{ asset('images/barber-logo-combined.png') }}" alt="Barbershop Emblem"
                    class="w-14 h-14 sm:w-18 sm:h-18 object-contain drop-shadow-md mb-1.5 sm:mb-2 group-hover:scale-105 transition-transform duration-300">

                <!-- Title con BARBER (Negro) y SHOP (Dorado Cursiva) sin fondo negro -->
                <div class="flex items-center gap-2.5">
                    <span class="h-[1px] w-5 bg-brand-accent/40"></span>
                    <span
                        class="font-serif font-bold text-lg sm:text-xl tracking-[0.25em] text-brand-black uppercase block leading-none pl-1">
                        BARBER<span class="text-brand-accent italic font-normal tracking-[0.2em]">SHOP</span>
                    </span>
                    <span class="h-[1px] w-5 bg-brand-accent/40"></span>
                </div>
            </div>

            <!-- Header Content -->
            <div class="my-auto py-2 sm:py-4">
                <div class="mb-4 sm:mb-6 text-center sm:text-left">
                    <h1 class="font-serif text-2xl sm:text-3xl font-bold text-brand-black tracking-tight leading-tight">
                        Crear tu cuenta
                    </h1>
                    <p class="text-brand-gray text-[11px] sm:text-sm lg:text-base mt-1.5 sm:mt-2 leading-relaxed">
                        Únete a nuestra familia y vive la experiencia de una barbería premium.
                    </p>
                </div>

                <!-- Formulario -->
                <form action="{{ route('register') }}" method="POST" class="space-y-3 sm:space-y-4">
                    @csrf

                    <!-- Nombre -->
                    <div>
                        <label for="first_name"
                            class="block text-xs font-bold text-brand-black uppercase tracking-wider mb-1.5">
                            Nombre
                        </label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-accent transition-colors">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required placeholder="Tu nombre completo"
                                class="block w-full pl-11 pr-4 py-2.5 sm:py-3 bg-[#F9F9F8] border border-gray-200 rounded-xl text-base sm:text-sm text-brand-black placeholder:text-gray-400 focus:bg-white focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all outline-none font-normal shadow-sm">
                        </div>
                        @error('first_name')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fila 2: Correo electrónico -->
                    <div>
                        <label for="email"
                            class="block text-xs font-bold text-brand-black uppercase tracking-wider mb-1.5">
                            Correo electrónico
                        </label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-accent transition-colors">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="tu@ejemplo.com"
                                class="block w-full pl-11 pr-4 py-2.5 sm:py-3 bg-[#F9F9F8] border border-gray-200 rounded-xl text-base sm:text-sm text-brand-black placeholder:text-gray-400 focus:bg-white focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all outline-none font-normal shadow-sm">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fila 3: Contraseña & Confirmar Contraseña -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label for="password"
                                class="block text-xs font-bold text-brand-black uppercase tracking-wider mb-1.5">
                                Contraseña
                            </label>
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-accent transition-colors">
                                    <i data-lucide="lock" class="w-5 h-5"></i>
                                </div>
                                <input type="password" id="password" name="password" required placeholder="••••••••"
                                    class="block w-full pl-11 pr-11 py-2.5 sm:py-3 bg-[#F9F9F8] border border-gray-200 rounded-xl text-base sm:text-sm text-brand-black placeholder:text-gray-400 focus:bg-white focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all outline-none font-normal shadow-sm">
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-brand-accent transition-colors focus:outline-none">
                                    <i data-lucide="eye" id="eyeIcon" class="w-5 h-5"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-xs font-bold text-brand-black uppercase tracking-wider mb-1.5">
                                Confirmar contraseña
                            </label>
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-accent transition-colors">
                                    <i data-lucide="lock" class="w-5 h-5"></i>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    placeholder="••••••••"
                                    class="block w-full pl-11 pr-11 py-2.5 sm:py-3 bg-[#F9F9F8] border border-gray-200 rounded-xl text-base sm:text-sm text-brand-black placeholder:text-gray-400 focus:bg-white focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all outline-none font-normal shadow-sm">
                                <button type="button" id="toggleConfirmPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-brand-accent transition-colors focus:outline-none">
                                    <i data-lucide="eye" id="eyeIconConfirm" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Fila 4: Teléfono (Opcional) -->
                    <div>
                        <label for="phone"
                            class="block text-xs font-bold text-brand-black uppercase tracking-wider mb-1.5">
                            Número de teléfono (opcional)
                        </label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-accent transition-colors">
                                <i data-lucide="smartphone" class="w-5 h-5"></i>
                            </div>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+57 300 123 4567"
                                class="block w-full pl-11 pr-4 py-2.5 sm:py-3 bg-[#F9F9F8] border border-gray-200 rounded-xl text-base sm:text-sm text-brand-black placeholder:text-gray-400 focus:bg-white focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all outline-none font-normal shadow-sm">
                        </div>
                        @error('phone')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Términos -->
                    <div class="pt-0.5">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <input type="checkbox" name="terms" required
                                class="w-4 h-4 rounded border-gray-300 text-brand-accent focus:ring-brand-accent accent-brand-accent cursor-pointer shrink-0">
                            <span class="text-xs font-medium text-brand-gray">
                                Acepto los <a href="#"
                                    class="text-brand-accent hover:text-brand-black underline decoration-brand-accent/40 underline-offset-2">términos
                                    y condiciones</a> y la <a href="#"
                                    class="text-brand-accent hover:text-brand-black underline decoration-brand-accent/40 underline-offset-2">política
                                    de privacidad</a>
                            </span>
                        </label>
                        @error('terms')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-3.5 px-6 bg-brand-black hover:bg-[#1a1a1a] active:scale-[0.99] text-white font-semibold text-sm rounded-xl transition-all duration-200 flex items-center justify-center gap-2.5 shadow-md hover:shadow-xl hover:shadow-black/10 group mt-3 border border-brand-black hover:border-brand-accent/40">
                        <span>Crear cuenta</span>
                        <i data-lucide="arrow-right"
                            class="w-4 h-4 text-brand-accent group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>
            </div>

            <!-- Footer Link -->
            <div class="pt-4 border-t border-gray-100 text-center">
                <p class="text-xs sm:text-sm text-brand-gray">
                    ¿Ya tienes una cuenta?
                    <a href="/login"
                        class="font-semibold text-brand-black hover:text-brand-accent transition-colors underline decoration-brand-accent/40 underline-offset-4">Inicia
                        sesión</a>
                </p>
            </div>
        </div>

        <!-- COLUMNA DERECHA: SECCIÓN EDITORIAL E IMAGEN PREMIUM -->
        <div
            class="hidden md:flex w-1/2 relative min-h-[640px] bg-brand-black flex-col justify-between p-10 sm:p-12 lg:p-16 text-white overflow-hidden group">

            <!-- Imagen de Fondo Editorial Realista & Profesional -->
            <div
                class="absolute inset-0 bg-[url('{{ asset('images/register-banner-new.jpg') }}')] bg-cover bg-center opacity-85 transform scale-105 group-hover:scale-100 transition-transform duration-1000">
            </div>

            <!-- Overlay Elegante con Iluminación Equilibrada -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/20"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-black/40 via-transparent to-black/20"></div>

            <!-- Contenido Editorial Principal -->
            <div class="relative z-10 my-auto py-8">
                <h2
                    class="font-serif text-3xl sm:text-4xl lg:text-[44px] font-bold leading-[1.18] mb-5 text-white tracking-tight">
                    Sé parte de <br class="hidden xl:inline"><span class="italic font-normal text-brand-accent">nuestra
                        historia.</span>
                </h2>
                <p
                    class="text-gray-300 text-sm sm:text-base leading-relaxed font-normal max-w-md border-l-2 border-brand-accent/50 pl-4 py-0.5">
                    Únete a una comunidad de caballeros que valoran la excelencia. Regístrate para disfrutar de reservas
                    prioritarias, beneficios exclusivos y una experiencia premium inigualable.
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

            const toggleConfirmBtn = document.getElementById('toggleConfirmPassword');
            const confirmInput = document.getElementById('password_confirmation');
            const eyeIconConfirm = document.getElementById('eyeIconConfirm');

            if (toggleConfirmBtn && confirmInput && eyeIconConfirm) {
                toggleConfirmBtn.addEventListener('click', () => {
                    const isPassword = confirmInput.getAttribute('type') === 'password';
                    confirmInput.setAttribute('type', isPassword ? 'text' : 'password');
                    eyeIconConfirm.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
                    lucide.createIcons();
                });
            }
        });
    </script>
</body>

</html>