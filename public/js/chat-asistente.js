/**
 * Asistente Virtual BarberShop - Lógica de Conversación y Puente WhatsApp Business
 * Versión compacta, minimizable y armónica con el sitio web
 */

const WHATSAPP_NUMERO = "573138763227"; // Número oficial de BarberShop Neiva

document.addEventListener("DOMContentLoaded", function () {
    // Mostrar teaser con animación sutil tras 3.5s si el chat no está abierto
    setTimeout(() => {
        const teaser = document.getElementById("asistente-teaser");
        const container = document.getElementById("asistente-virtual-container");
        if (teaser && container && !container.classList.contains("is-active")) {
            teaser.style.display = "flex";
        }
    }, 3500);
});

/**
 * Abre o cierra la ventana del Asistente Virtual
 */
function toggleAsistenteChat() {
    const container = document.getElementById("asistente-virtual-container");
    const windowEl = document.getElementById("asistente-window");
    const teaser = document.getElementById("asistente-teaser");

    if (!container || !windowEl) return;

    const isActive = container.classList.toggle("is-active");

    if (teaser) {
        teaser.style.display = "none";
    }

    if (isActive) {
        windowEl.classList.remove("is-minimized");
        const minBtn = document.getElementById("btn-minimizar-chat");
        if (minBtn) {
            minBtn.setAttribute("title", "Minimizar para ver la página");
            minBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>`;
        }
        windowEl.setAttribute("aria-hidden", "false");
        const input = document.getElementById("asistente-user-input");
        if (input) {
            setTimeout(() => input.focus(), 250);
        }
        scrollChatToBottom();
    } else {
        windowEl.setAttribute("aria-hidden", "true");
    }
}

/**
 * Minimiza la ventana a una barra compacta para no tapar contenido de la página
 */
function toggleMinimizarAsistente() {
    const windowEl = document.getElementById("asistente-window");
    if (!windowEl) return;

    windowEl.classList.toggle("is-minimized");
    const isMin = windowEl.classList.contains("is-minimized");
    const minBtn = document.getElementById("btn-minimizar-chat");

    if (minBtn) {
        minBtn.setAttribute("title", isMin ? "Expandir chat" : "Minimizar");
        minBtn.innerHTML = isMin 
            ? `<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>`
            : `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>`;
    }

    if (!isMin) {
        scrollChatToBottom();
    }
}

/**
 * Cierra manualmente el teaser informativo
 */
function cerrarTeaser() {
    const teaser = document.getElementById("asistente-teaser");
    if (teaser) {
        teaser.style.display = "none";
    }
}

/**
 * Conecta al usuario con WhatsApp Business del negocio
 * @param {string} mensaje 
 */
function enviarMensajeWhatsapp(mensaje) {
    const textoCodificado = encodeURIComponent(mensaje || "¡Hola BarberShop! Deseo información personalizada sobre sus servicios.");
    const url = `https://wa.me/${WHATSAPP_NUMERO}?text=${textoCodificado}`;
    window.open(url, "_blank", "noopener,noreferrer");
}

/**
 * Auto-scroll hacia el final del historial
 */
function scrollChatToBottom() {
    const chatBody = document.getElementById("asistente-chat-body");
    if (chatBody) {
        setTimeout(() => {
            chatBody.scrollTop = chatBody.scrollHeight;
        }, 40);
    }
}

/**
 * Control del indicador de tipeo
 * @param {boolean} mostrar 
 */
function setTyping(mostrar) {
    const typingEl = document.getElementById("chat-typing");
    if (!typingEl) return;
    
    typingEl.style.display = mostrar ? "flex" : "none";
    if (mostrar) {
        scrollChatToBottom();
    }
}

/**
 * Agrega el mensaje del usuario al chat
 * @param {string} texto 
 */
function agregarMensajeUsuario(texto) {
    const chatBody = document.getElementById("asistente-chat-body");
    const typingEl = document.getElementById("chat-typing");

    const messageDiv = document.createElement("div");
    messageDiv.className = "chat-message message-user";
    messageDiv.innerHTML = `
        <div class="message-bubble">
            <p>${escaparHTML(texto)}</p>
            <span class="message-timestamp">Tú</span>
        </div>
    `;

    chatBody.insertBefore(messageDiv, typingEl);
    scrollChatToBottom();
}

/**
 * Agrega la respuesta del Asistente Virtual
 * @param {string} htmlContent 
 */
function agregarMensajeBot(htmlContent) {
    const chatBody = document.getElementById("asistente-chat-body");
    const typingEl = document.getElementById("chat-typing");

    const messageDiv = document.createElement("div");
    messageDiv.className = "chat-message message-bot";
    messageDiv.innerHTML = `
        <div class="message-bubble">
            ${htmlContent}
            <span class="message-timestamp">Asistente</span>
        </div>
    `;

    chatBody.insertBefore(messageDiv, typingEl);
    scrollChatToBottom();
}

/**
 * Acciones rápidas (chips)
 * @param {string} tipo 
 */
function seleccionarOpcionRapida(tipo) {
    let tituloUsuario = "";
    let respuestaBot = "";

    switch (tipo) {
        case "servicios":
            tituloUsuario = "Servicios y Precios";
            respuestaBot = `
                <p>💈 <strong>Tarifas de Servicios:</strong></p>
                <div class="message-card-list">
                    <div class="chat-service-item">
                        <span class="chat-service-title">Corte de Cabello</span>
                        <span class="chat-service-price">$23.000</span>
                    </div>
                    <div class="chat-service-item">
                        <span class="chat-service-title">Arreglo de Barba</span>
                        <span class="chat-service-price">$30.000</span>
                    </div>
                    <div class="chat-service-item">
                        <span class="chat-service-title">Afeitado Clásico</span>
                        <span class="chat-service-price">$15.000</span>
                    </div>
                    <div class="chat-service-item">
                        <span class="chat-service-title">Servicio Premium VIP</span>
                        <span class="chat-service-price">$60.000</span>
                    </div>
                    <div class="chat-service-item">
                        <span class="chat-service-title">Asesoría de Imagen</span>
                        <span class="chat-service-price">$115.000</span>
                    </div>
                </div>
                <a href="/login" class="chat-btn-action btn-action-cita">
                    <span>📅 Agendar Cita en Línea</span>
                </a>
                <button type="button" class="chat-btn-action btn-action-wsp" onclick="enviarMensajeWhatsapp('¡Hola! Me gustaría consultar disponibilidad para un corte de cabello o servicio.')">
                    <span>💬 Consultar Disponibilidad</span>
                </button>
            `;
            break;

        case "horarios":
            tituloUsuario = "Horarios de Atención";
            respuestaBot = `
                <p>⏰ <strong>Horarios de BarberShop:</strong></p>
                <div class="message-card-list">
                    <div class="chat-service-item">
                        <span class="chat-service-title">Lunes a Viernes</span>
                        <span class="chat-service-price">9:00 AM - 8:00 PM</span>
                    </div>
                    <div class="chat-service-item">
                        <span class="chat-service-title">Sábados</span>
                        <span class="chat-service-price">9:00 AM - 6:00 PM</span>
                    </div>
                    <div class="chat-service-item">
                        <span class="chat-service-title">Domingos</span>
                        <span class="chat-service-price" style="color: #ef4444;">Cerrado</span>
                    </div>
                </div>
                <a href="/login" class="chat-btn-action btn-action-cita">
                    <span>📅 Reservar Cita en Este Horario</span>
                </a>
            `;
            break;

        case "ubicacion":
            tituloUsuario = "Ubicación y Dirección";
            respuestaBot = `
                <p>📍 <strong>Estamos ubicados en:</strong></p>
                <p style="margin: 4px 0 8px; color: #f0f0f0;">Calle 83 A 2 a 10, Neiva, Huila.</p>
                <a href="https://www.google.com/maps?q=Calle+83+A+2+a+10+Neiva+Huila" target="_blank" rel="noopener" class="chat-btn-action btn-action-cita">
                    <span>🗺️ Ver en Google Maps</span>
                </a>
            `;
            break;

        case "agendar":
            tituloUsuario = "Agendar Cita en Línea";
            respuestaBot = `
                <p>📅 Puedes agendar tu turno directamente desde nuestro portal de clientes:</p>
                <a href="/login" class="chat-btn-action btn-action-cita">
                    <span>🚀 Iniciar Sesión para Agendar</span>
                </a>
                <button type="button" class="chat-btn-action btn-action-wsp" onclick="enviarMensajeWhatsapp('¡Hola BarberShop! Deseo agendar una cita para hoy o esta semana.')">
                    <span>💬 Agendar Asistido por WhatsApp</span>
                </button>
            `;
            break;

        case "asesor":
            tituloUsuario = "Hablar con un Asesor";
            respuestaBot = `
                <p>💬 <strong>Atención Personalizada</strong></p>
                <p>Te conectamos directamente con nuestro equipo de atención al cliente:</p>
                <button type="button" class="chat-btn-action btn-action-wsp" onclick="enviarMensajeWhatsapp('¡Hola BarberShop! Vengo desde el sitio web y me gustaría hablar con un asesor.')">
                    <span>💬 Abrir WhatsApp con un Asesor</span>
                </button>
            `;
            break;

        default:
            return;
    }

    agregarMensajeUsuario(tituloUsuario);
    setTyping(true);

    setTimeout(() => {
        setTyping(false);
        agregarMensajeBot(respuestaBot);
    }, 450);
}

/**
 * Enviar mensaje desde el formulario
 * @param {Event} event 
 */
function enviarMensajeUsuario(event) {
    if (event) event.preventDefault();

    const input = document.getElementById("asistente-user-input");
    if (!input) return;

    const texto = input.value.trim();
    if (!texto) return;

    input.value = "";
    agregarMensajeUsuario(texto);
    setTyping(true);

    setTimeout(() => {
        setTyping(false);
        procesarRespuestaInteligente(texto);
    }, 500);
}

/**
 * Procesamiento de preguntas del usuario
 * @param {string} consulta 
 */
function procesarRespuestaInteligente(consulta) {
    const texto = consulta.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

    // 1. Asesor / Contacto / Persona / WhatsApp
    if (texto.includes("whatsapp") || texto.includes("wsp") || texto.includes("wa") || 
        texto.includes("humano") || texto.includes("persona") || texto.includes("asesor") || 
        texto.includes("telefono") || texto.includes("celular") || texto.includes("contacto")) {
        
        const respuesta = `
            <p>Con gusto te comunicamos con nuestro equipo para asesorarte:</p>
            <button type="button" class="chat-btn-action btn-action-wsp" onclick="enviarMensajeWhatsapp('¡Hola! Tengo una consulta sobre: ${escaparAttr(consulta)}')">
                <span>💬 Contactar a un Asesor</span>
            </button>
        `;
        agregarMensajeBot(respuesta);
        return;
    }

    // 2. Precios y Servicios
    if (texto.includes("precio") || texto.includes("costo") || texto.includes("vale") || 
        texto.includes("cuanto") || texto.includes("tarifa") || texto.includes("corte") || 
        texto.includes("barba") || texto.includes("afeitado") || texto.includes("servicio")) {
        
        const respuesta = `
            <p>✂️ <strong>Precios de Servicios:</strong></p>
            <div class="message-card-list">
                <div class="chat-service-item">
                    <span class="chat-service-title">Corte de Cabello</span>
                    <span class="chat-service-price">$23.000</span>
                </div>
                <div class="chat-service-item">
                    <span class="chat-service-title">Arreglo de Barba</span>
                    <span class="chat-service-price">$30.000</span>
                </div>
                <div class="chat-service-item">
                    <span class="chat-service-title">Afeitado Clásico</span>
                    <span class="chat-service-price">$15.000</span>
                </div>
                <div class="chat-service-item">
                    <span class="chat-service-title">Servicio Premium VIP</span>
                    <span class="chat-service-price">$60.000</span>
                </div>
            </div>
            <a href="/login" class="chat-btn-action btn-action-cita">
                <span>📅 Agendar Turno Online</span>
            </a>
        `;
        agregarMensajeBot(respuesta);
        return;
    }

    // 3. Horarios
    if (texto.includes("hora") || texto.includes("horario") || texto.includes("abren") || 
        texto.includes("cierran") || texto.includes("abierto") || texto.includes("domingo")) {
        
        const respuesta = `
            <p>⏰ <strong>Horarios de Atención:</strong></p>
            <p style="font-size: 0.80rem; margin: 4px 0;">• Lun - Vie: 9:00 AM a 8:00 PM<br>• Sábados: 9:00 AM a 6:00 PM<br>• Domingos: Cerrado</p>
            <a href="/login" class="chat-btn-action btn-action-cita">
                <span>📅 Agendar Cita</span>
            </a>
        `;
        agregarMensajeBot(respuesta);
        return;
    }

    // 4. Ubicación
    if (texto.includes("donde") || texto.includes("ubicacion") || texto.includes("direccion") || 
        texto.includes("llegar") || texto.includes("mapa") || texto.includes("queda")) {
        
        const respuesta = `
            <p>📍 Nos encontramos en <strong>Calle 83 A 2 a 10, Neiva, Huila</strong>.</p>
            <a href="https://www.google.com/maps?q=Calle+83+A+2+a+10+Neiva+Huila" target="_blank" rel="noopener" class="chat-btn-action btn-action-cita">
                <span>🗺️ Ver en Google Maps</span>
            </a>
        `;
        agregarMensajeBot(respuesta);
        return;
    }

    // 5. Citas / Reservas
    if (texto.includes("cita") || texto.includes("turno") || texto.includes("reserva") || 
        texto.includes("agendar") || texto.includes("apartar")) {
        
        const respuesta = `
            <p>📅 Puedes reservar tu turno con el barbero de tu preferencia en nuestra plataforma:</p>
            <a href="/login" class="chat-btn-action btn-action-cita">
                <span>🚀 Agendar Cita Online</span>
            </a>
        `;
        agregarMensajeBot(respuesta);
        return;
    }

    // 6. Saludos
    if (texto.includes("hola") || texto.includes("buenas") || texto.includes("buen dia") || 
        texto.includes("tardes") || texto.includes("noches") || texto.includes("hey")) {
        
        const respuesta = `
            <p>¡Hola! Un gusto saludarte. ¿En qué servicio o consulta podemos orientarte hoy?</p>
        `;
        agregarMensajeBot(respuesta);
        return;
    }

    // 7. Agradecimientos
    if (texto.includes("gracias") || texto.includes("muchas gracias") || texto.includes("excelente") || 
        texto.includes("perfecto") || texto.includes("vale") || texto.includes("ok")) {
        
        const respuesta = `
            <p>¡Con mucho gusto! Siempre a tu orden en <strong>BARBERSHOP</strong> 💈</p>
        `;
        agregarMensajeBot(respuesta);
        return;
    }

    // 8. Fallback
    const respuestaFallback = `
        <p>Para brindarte la información más exacta sobre tu consulta, con gusto puedes escribirle directamente a un asesor:</p>
        <button type="button" class="chat-btn-action btn-action-wsp" onclick="enviarMensajeWhatsapp('¡Hola BarberShop! Consulta desde la web: ${escaparAttr(consulta)}')">
            <span>💬 Hablar con un Asesor</span>
        </button>
    `;
    agregarMensajeBot(respuestaFallback);
}

/**
 * Escapar HTML
 */
function escaparHTML(str) {
    if (!str) return "";
    return str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

/**
 * Escapar atributos
 */
function escaparAttr(str) {
    if (!str) return "";
    return str.replace(/'/g, "\\'").replace(/"/g, "&quot;");
}
