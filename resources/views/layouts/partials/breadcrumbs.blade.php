<div class="px-3 sm:px-6 lg:px-8 py-2.5 sm:py-3 bg-white/80 border-b border-slate-200/80 flex items-center text-xs sm:text-sm overflow-x-auto whitespace-nowrap scrollbar-none">
    <div class="flex items-center gap-2 text-slate-500 font-medium shrink-0">
        @php
            $homeUrl = '/';
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->esAdmin()) {
                    $homeUrl = route('admin.dashboard1');
                } elseif ($user->esBarbero()) {
                    $homeUrl = route('barbero.dashboard2');
                } else {
                    $homeUrl = route('cliente.dashboard3');
                }
            }
        @endphp
        <a href="{{ $homeUrl }}" class="hover:text-amber-600 transition-colors flex items-center gap-1.5">
            <i data-lucide="home" class="w-3.5 h-3.5 text-slate-400"></i>
            <span>Inicio</span>
        </a>
        <span class="text-slate-300">/</span>
        <span class="text-amber-600 font-semibold flex items-center gap-1.5">
            @yield('breadcrumb', 'Dashboard')
        </span>
    </div>
</div>
