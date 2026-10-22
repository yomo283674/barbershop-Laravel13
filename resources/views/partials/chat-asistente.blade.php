{{-- Widget Asistente Virtual BarberShop - Diseño Compacto y Armónico con el Sitio Web --}}
<div id="asistente-virtual-container" class="asistente-container">
    
    {{-- Tooltip / Teaser flotante inicial sutil --}}
    <div id="asistente-teaser" class="asistente-teaser" onclick="toggleAsistenteChat()">
        <div class="teaser-avatar">
            <img src="{{ asset('images/asistente-icono.png') }}" alt="Asistente BarberShop" class="asistente-img-icon">
        </div>
        <div class="teaser-content">
            <span class="teaser-title">Asistente Virtual</span>
            <span class="teaser-text">¿En qué podemos ayudarte hoy?</span>
        </div>
        <button type="button" class="teaser-close" onclick="event.stopPropagation(); cerrarTeaser();" aria-label="Cerrar aviso">&times;</button>
    </div>

    {{-- Botón Flotante (Launcher / FAB) --}}
    <button id="asistente-fab" class="asistente-fab" onclick="toggleAsistenteChat()" aria-label="Abrir Asistente Virtual" title="Abrir Asistente Virtual">
        <span class="asistente-status-dot" title="En línea"></span>
        <div class="fab-icon fab-icon-open">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                <path d="M8 10h.01"/>
                <path d="M12 10h.01"/>
                <path d="M16 10h.01"/>
            </svg>
        </div>
        <div class="fab-icon fab-icon-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </div>
    </button>

    {{-- Ventana Compacta del Asistente --}}
    <div id="asistente-window" class="asistente-window" aria-hidden="true">
        
        {{-- Header del Chat --}}
        <div class="asistente-header">
            <div class="header-assistant-info" onclick="toggleMinimizarAsistente()" title="Clic para minimizar o expandir">
                <div class="assistant-avatar">
                    <img src="{{ asset('images/asistente-icono.png') }}" alt="Asistente Virtual" class="avatar-img-icon">
                </div>
                <div class="assistant-meta">
                    <h3 class="assistant-name">Asistente Virtual</h3>
                    <div class="assistant-status">
                        <span class="status-indicator"></span>
                        <span>En línea • BarberShop</span>
                    </div>
                </div>
            </div>

            <div class="header-actions">
                {{-- Botón Minimizar a barra compacta (evita ocultar la página) --}}
                <button type="button" id="btn-minimizar-chat" class="btn-header-action" onclick="toggleMinimizarAsistente()" title="Minimizar para ver la página" aria-label="Minimizar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                </button>

                {{-- Botón Cerrar --}}
                <button type="button" class="btn-header-action btn-header-close" onclick="toggleAsistenteChat()" aria-label="Cerrar chat" title="Cerrar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Cuerpo de Conversación (Historial de Mensajes) --}}
        <div id="asistente-chat-body" class="asistente-body">
            
            {{-- Mensaje Inicial de Bienvenida --}}
            <div class="chat-message message-bot">
                <div class="message-bubble">
                    <p>¡Hola! Bienvenido a <strong>BARBERSHOP</strong> 💈</p>
                    <p>Soy tu <strong>Asistente Virtual</strong>. ¿En qué podemos asesorarte hoy?</p>
                    <span class="message-timestamp">Ahora</span>
                </div>
            </div>

            {{-- Opciones Rápidas (Chips de Interacción) --}}
            <div class="quick-options-container" id="quick-options">
                <span class="quick-options-label">Opciones frecuentes:</span>
                <div class="quick-chips-grid">
                    <button type="button" class="quick-chip" onclick="seleccionarOpcionRapida('servicios')">
                        <span class="chip-icon">✂️</span>
                        <span class="chip-text">Servicios y Precios</span>
                    </button>
                    <button type="button" class="quick-chip" onclick="seleccionarOpcionRapida('horarios')">
                        <span class="chip-icon">⏰</span>
                        <span class="chip-text">Horarios de Atención</span>
                    </button>
                    <button type="button" class="quick-chip" onclick="seleccionarOpcionRapida('ubicacion')">
                        <span class="chip-icon">📍</span>
                        <span class="chip-text">Ubicación y Dirección</span>
                    </button>
                    <button type="button" class="quick-chip" onclick="seleccionarOpcionRapida('agendar')">
                        <span class="chip-icon">📅</span>
                        <span class="chip-text">Agendar Cita en Línea</span>
                    </button>
                    <button type="button" class="quick-chip chip-asesor" onclick="seleccionarOpcionRapida('asesor')">
                        <span class="chip-icon">💬</span>
                        <span class="chip-text">Hablar con un Asesor</span>
                    </button>
                </div>
            </div>

            {{-- Indicador de Tipeo (Escribiendo...) --}}
            <div id="chat-typing" class="chat-typing-indicator" style="display: none;">
                <div class="typing-bubble">
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                </div>
                <span class="typing-label">Escribiendo...</span>
            </div>

        </div>

        {{-- Footer de Input y Envío --}}
        <div class="asistente-footer">
            <form id="asistente-input-form" onsubmit="enviarMensajeUsuario(event)" class="asistente-form">
                <div class="input-wrapper">
                    <input type="text" id="asistente-user-input" placeholder="Escribe tu pregunta aquí..." autocomplete="off">
                </div>
                <button type="submit" id="asistente-btn-send" class="btn-send-message" aria-label="Enviar mensaje" title="Enviar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                </button>
            </form>
        </div>

    </div>
</div>
