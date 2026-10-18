@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegación de páginas" class="inline-flex items-center gap-1.5">
        {{-- Enlace Página Anterior --}}
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" aria-label="Anterior" 
                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-slate-300 bg-slate-100/50 border border-slate-200/50 rounded-2xl cursor-not-allowed select-none">
                <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
                <span class="hidden sm:inline">Anterior</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Anterior" 
            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-slate-700 hover:text-slate-950 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-2xl shadow-2xs hover:shadow-xs transition-all active:scale-95 cursor-pointer">
                <i data-lucide="chevron-left" class="w-3.5 h-3.5 text-slate-500"></i>
                <span class="hidden sm:inline">Anterior</span>
            </a>
        @endif

        {{-- Segmented Controls para Páginas --}}
        <div class="inline-flex items-center gap-0.5 bg-slate-100/90 p-1 rounded-2xl border border-slate-200/70">
            @foreach ($elements as $element)
                {{-- Separador de puntos suspensivos --}}
                @if (is_string($element))
                    <span aria-disabled="true" class="w-7 h-7 flex items-center justify-center text-xs font-arial font-semibold text-slate-400 select-none">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array De Enlaces --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" 
                                  class="w-7 h-7 rounded-xl bg-slate-900 text-amber-400 font-extrabold text-xs font-arial shadow-xs border border-slate-800 flex items-center justify-center">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" 
                               class="w-7 h-7 rounded-xl text-slate-600 hover:text-slate-950 hover:bg-white/80 font-bold text-xs font-arial transition-all flex items-center justify-center cursor-pointer" 
                               aria-label="Ir a página {{ $page }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Enlace Página Siguiente --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Siguiente" 
               class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-slate-700 hover:text-slate-950 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-2xl shadow-2xs hover:shadow-xs transition-all active:scale-95 cursor-pointer">
                <span class="hidden sm:inline">Siguiente</span>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-500"></i>
            </a>
        @else
            <span aria-disabled="true" aria-label="Siguiente" 
                  class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-slate-300 bg-slate-100/50 border border-slate-200/50 rounded-2xl cursor-not-allowed select-none">
                <span class="hidden sm:inline">Siguiente</span>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            </span>
        @endif
    </nav>
@endif
