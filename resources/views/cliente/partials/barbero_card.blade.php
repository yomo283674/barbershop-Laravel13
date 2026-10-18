@php
    $avatarStyles = [
        ['bg' => 'bg-gradient-to-br from-amber-600 via-amber-700 to-amber-900', 'text' => 'text-amber-100', 'border' => 'border-amber-500/50'],
        ['bg' => 'bg-gradient-to-br from-slate-800 via-slate-900 to-[#0b0c10]', 'text' => 'text-[#c5a059]', 'border' => 'border-[#c5a059]/50'],
        ['bg' => 'bg-gradient-to-br from-emerald-800 via-emerald-900 to-teal-950', 'text' => 'text-emerald-100', 'border' => 'border-emerald-500/50'],
        ['bg' => 'bg-gradient-to-br from-[#3b2219] via-[#4d2d22] to-[#261510]', 'text' => 'text-amber-200', 'border' => 'border-amber-600/50'],
    ];
    $style = $avatarStyles[($index ?? 0) % count($avatarStyles)];
@endphp
<div class="rounded-2xl border border-slate-200 bg-white p-4 hover:border-amber-400/80 hover:shadow-md transition-all flex flex-col justify-between group">
    <div>
        <div class="flex items-center gap-3">
            <div class="relative shrink-0">
                @if($barbero->foto_perfil)
                    <img src="{{ asset($barbero->foto_perfil) }}" 
                        alt="{{ $barbero->nombre }}" 
                        class="w-12 h-12 rounded-2xl object-cover border-2 border-amber-400/40 shadow-xs"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display: none;" class="w-12 h-12 rounded-2xl {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }} border-2 items-center justify-center font-bold text-lg font-serif shadow-xs shrink-0">
                        {{ strtoupper(substr($barbero->nombre, 0, 1)) }}
                    </div>
                @else
                    <div class="w-12 h-12 rounded-2xl {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }} border-2 flex items-center justify-center font-bold text-lg font-serif shadow-xs shrink-0">
                        {{ strtoupper(substr($barbero->nombre, 0, 1)) }}
                    </div>
                @endif
                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-500 ring-2 ring-white" title="Activo"></span>
            </div>
            <div class="min-w-0">
                <h3 class="text-sm font-bold text-slate-900 truncate">{{ $barbero->nombre }}</h3>
                <p class="text-[11px] font-semibold text-amber-800 bg-amber-50 border border-amber-200/70 px-2 py-0.5 rounded-md inline-block mt-0.5 truncate max-w-full" title="{{ $barbero->especialidad }}">
                    {{ $barbero->especialidad ?? 'Barbero Profesional' }}
                </p>
            </div>
        </div>

        <div class="mt-3 pt-3 border-t border-slate-100 space-y-1.5">
            <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-wider text-amber-800/80">
                <span>Servicios:</span>
                <span class="text-[9px] text-amber-700/60 font-semibold">COP</span>
            </div>
            @forelse($barbero->servicios->take(3) as $serv)
                <div class="flex items-center justify-between text-xs py-1.5 px-2 rounded-xl bg-amber-50/40 hover:bg-amber-50/80 border border-amber-200/50 transition-colors">
                    <span class="text-slate-800 truncate pr-2 font-medium">• {{ $serv->nombre }}</span>
                    <span class="font-bold text-amber-900 font-arial text-xs shrink-0 whitespace-nowrap bg-white px-2 py-0.5 rounded-md border border-amber-200 shadow-2xs">
                        ${{ number_format($serv->precio, 0) }}
                    </span>
                </div>
            @empty
                <div class="py-2.5 px-3 text-center rounded-xl bg-gradient-to-br from-amber-500/10 via-amber-500/5 to-transparent border border-dashed border-amber-300/70">
                    <p class="text-xs font-semibold text-amber-900">Cortes clásicos & barba</p>
                    <p class="text-[10px] text-amber-700/80 font-medium mt-0.5">Catálogo completo al agendar</p>
                </div>
            @endforelse
        </div>
    </div>

    <button type="button" 
            onclick="seleccionarBarberoParaReserva({{ $barbero->id_usuario }})" 
            class="mt-4 w-full py-2.5 rounded-xl bg-[#0b0c10] hover:bg-[#1a1b22] text-white border border-[#1a1b22] hover:border-slate-700 text-xs font-semibold tracking-wide transition-all flex items-center justify-center gap-2 shadow-xs cursor-pointer">
        <i data-lucide="calendar-check" class="w-3.5 h-3.5 text-[#c5a059]"></i>
        <span>Elegir a {{ explode(' ', $barbero->nombre)[0] }}</span>
    </button>
</div>
