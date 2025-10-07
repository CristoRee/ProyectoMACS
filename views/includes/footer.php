</div> <?php if (isset($_SESSION['id_usuario'])): ?>

<div class="chat-launcher" id="chat-launcher">
    <span id="launcher-text">Chats Activos</span>
    <button id="toggle-chat-list"><i class="fas fa-chevron-up"></i></button>
</div>

<div class="chat-list" id="chat-list">
    <div class="chat-list-header">Mis Conversaciones</div>
    <ul class="chat-list-body" id="chat-list-body">
        </ul>
</div>

<div id="chat-ventana" class="chat-ventana-oculta">
    <div class="chat-header">
        <span id="chat-titulo">Chat del Ticket #</span>
        <div>
            <button id="info-chat" type="button" data-bs-toggle="popover" data-bs-placement="left" title="Información del Ticket">
                <i class="fas fa-info-circle"></i>
            </button>
            <button id="cerrar-chat" type="button">&times;</button>
        </div>
    </div>
    <div class="chat-cuerpo" id="chat-cuerpo"></div>
    <div class="chat-footer">
        <form id="form-enviar-mensaje" autocomplete="off">
            <input type="hidden" name="id_conversacion" id="chat-id-conversacion">
            <input type="hidden" name="id_receptor" id="chat-id-receptor">
            <input type="text" name="contenido" id="chat-input-mensaje" placeholder="Escribe un mensaje..." required>
            <button type="submit"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
</div>

<style>
/* --- Estilos para el Lanzador y Lista de Chats --- */
.chat-launcher {
    position: fixed; bottom: 20px; right: 20px;
    background-color: #0d6efd; color: white;
    padding: 10px; 
    border-radius: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    display: flex;
    justify-content: center; 
    align-items: center; cursor: pointer;
    z-index: 1001;
    transition: transform 0.4s ease-in-out, width 0.4s ease-in-out;
    width: 160px; height: 45px; 
}
.chat-launcher.moved {
    transform: translateX(-370px);
    width: 50px; 
}
.chat-launcher span {
    transition: opacity 0.2s, width 0.2s, margin-right 0.2s;
    white-space: nowrap;
    overflow: hidden;
    margin-right: 10px; 
}
.chat-launcher.moved span {
    opacity: 0;
    width: 0;
    margin-right: 0;
}
.chat-launcher button {
    background: none; border: none; color: white;
    transition: transform 0.3s;
    padding: 0; margin: 0; 
    line-height: 1; 
}
.chat-launcher button.open { transform: rotate(180deg); }

.chat-list {
    position: fixed; bottom: 70px; right: 20px;
    width: 300px; background: white; border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    overflow: hidden; display: none; z-index: 1000;
}
.chat-list-header { font-weight: bold; padding: 10px; background: #f8f9fa; border-bottom: 1px solid #ddd;}
.chat-list-body { list-style: none; margin: 0; padding: 0; max-height: 300px; overflow-y: auto; }
.chat-list-item { padding: 12px; border-bottom: 1px solid #eee; cursor: pointer; }
.chat-list-item:hover { background: #f1f1f1; }
.chat-list-item small { color: #6c757d; }

/* --- Estilos para la Ventana de Chat --- */
#chat-ventana {
    position: fixed; bottom: 20px; right: 20px;
    width: 350px; height: 450px; background-color: white;
    border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    display: flex; flex-direction: column;
    transition: transform 0.3s ease-in-out, opacity 0.3s;
    z-index: 1000;
}
.chat-ventana-oculta { transform: scale(0); opacity: 0; transform-origin: bottom right; }
.chat-header {
    background-color: #0d6efd; color: white; padding: 10px 15px;
    border-top-left-radius: 10px; border-top-right-radius: 10px;
    display: flex; justify-content: space-between; align-items: center;
}
.chat-header div { display: flex; align-items: center; }
#info-chat { background: none; border: none; color: white; font-size: 18px; cursor: pointer; margin-right: 10px; }
.chat-header #cerrar-chat { background: none; border: none; color: white; font-size: 20px; cursor: pointer; }
.chat-cuerpo { flex-grow: 1; padding: 15px; overflow-y: auto; background-color: #f4f7f9; }
.chat-footer { padding: 10px; border-top: 1px solid #ddd; }
#form-enviar-mensaje { display: flex; }
#chat-input-mensaje {
    flex-grow: 1; border: 1px solid #ccc; border-radius: 20px;
    padding: 8px 15px; margin-right: 10px;
}
#form-enviar-mensaje button {
    background-color: #0d6efd; color: white; border: none; border-radius: 50%;
    width: 40px; height: 40px; cursor: pointer;
}

/* --- Estilos para los Mensajes y Roles --- */
.mensaje { margin-bottom: 10px; display: flex; flex-direction: column; }
.mensaje-contenido {
    padding: 8px 12px; border-radius: 15px;
    max-width: 80%; word-wrap: break-word;
}
.mensaje-info { display: flex; align-items: center; margin-bottom: 4px; }
.mensaje-emisor-nombre { font-weight: bold; font-size: 0.9em; }
.role-badge {
    font-size: 0.7em; padding: 2px 6px; border-radius: 5px;
    margin-left: 8px; color: white;
}
.role-badge.admin { background-color: #ffc107; color: #343a40 !important; }
.role-badge.tecnico { background-color: #0dcaf0; }

/* Colores de los globos de chat */
.mensaje.emisor .mensaje-contenido { background-color: #0d6efd; color: white; }
.mensaje.receptor .mensaje-contenido.cliente { background-color: #e9ecef; color: #212529; }
.mensaje.receptor .mensaje-contenido.tecnico { background-color: #cff4fc; color: #055160; }
.mensaje.receptor .mensaje-contenido.administrador { background-color: #fff3cd; color: #664d03; }

/* === REGLAS DE CSS QUE FALTABAN === */
.mensaje.emisor, .mensaje.receptor { width: 100%; }
.mensaje.emisor { align-items: flex-end; }
.mensaje.receptor { align-items: flex-start; }
</style>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Solo ejecuta el script de chat si los elementos existen
    if(document.getElementById('chat-ventana')) {
        const chatLauncher = document.getElementById('chat-launcher');
        const toggleBtn = document.getElementById('toggle-chat-list');
        const chatList = document.getElementById('chat-list');
        const chatVentana = document.getElementById('chat-ventana');
        const chatCuerpo = document.getElementById('chat-cuerpo');
        const formEnviarMensaje = document.getElementById('form-enviar-mensaje');
        const cerrarChatBtn = document.getElementById('cerrar-chat');
        let infoPopover = null;
        
        // ---- Lógica del Lanzador y Lista de Chats ----
        chatLauncher.addEventListener('click', async function() {
            const isListOpen = chatList.style.display === 'block';
            if (isListOpen) {
                chatList.style.display = 'none';
                toggleBtn.classList.remove('open');
            } else {
                chatList.style.display = 'block';
                toggleBtn.classList.add('open');
                
                const response = await fetch('index.php?accion=cargarListaChats');
                const conversaciones = await response.json();
                const listBody = document.getElementById('chat-list-body');
                listBody.innerHTML = '';
                if (conversaciones.length > 0) {
                    conversaciones.forEach(conv => {
                        const listItem = document.createElement('li');
                        listItem.className = 'chat-list-item';
                        listItem.innerHTML = `<div>${conv.otro_participante || 'Técnico no asignado'}</div><small>Ticket #${conv.id_ticket}</small>`;
                        listItem.onclick = () => {
                            abrirChat(conv.id_ticket);
                            chatList.style.display = 'none';
                            toggleBtn.classList.remove('open');
                        };
                        listBody.appendChild(listItem);
                    });
                } else {
                    listBody.innerHTML = '<li class="chat-list-item text-muted">No tienes conversaciones activas.</li>';
                }
            }
        });

        // ---- Lógica de la Ventana de Chat ----
        window.abrirChat = async function(id_ticket, target = 'ticket') {
            chatLauncher.classList.add('moved');
            chatList.style.display = 'none';
            toggleBtn.classList.remove('open');
            chatVentana.classList.remove('chat-ventana-oculta');
            
            let tituloChat = (target === 'tecnico') 
                ? `Chat Privado (Técnico) - Ticket #${id_ticket}` 
                : `Chat del Ticket #${id_ticket}`;
            document.getElementById('chat-titulo').textContent = tituloChat;
            
            chatCuerpo.innerHTML = '<p class="text-center">Cargando...</p>';
            try {
                const response = await fetch(`index.php?accion=cargarChat&id_ticket=${id_ticket}&target=${target}`);
                if (!response.ok) throw new Error('Error al cargar datos del chat.');
                const data = await response.json();
                
                document.getElementById('chat-id-conversacion').value = data.id_conversacion;
                document.getElementById('chat-id-receptor').value = data.id_receptor;
                
                const infoBtn = document.getElementById('info-chat');
                const popoverContent = `<b>Cliente:</b> ${data.info.nombre_cliente}<br><b>Dispositivo:</b> ${data.info.tipo_producto} ${data.info.marca}`;
                if(infoPopover) infoPopover.dispose();
                infoBtn.setAttribute('data-bs-content', popoverContent);
                infoPopover = new bootstrap.Popover(infoBtn, {html: true});
                
                const esCliente = <?php echo ($_SESSION['rol'] ?? 0) == 3 ? 'true' : 'false'; ?>;
                
                if (esCliente && !data.tecnico_asignado) {
                    chatCuerpo.innerHTML = '<p class="text-center text-muted p-3">Un técnico será asignado a tu solicitud en breve. Podrás contactarlo por este medio una vez que tome tu caso.</p>';
                    formEnviarMensaje.style.display = 'none';
                } else {
                    formEnviarMensaje.style.display = 'flex';
                    mostrarMensajes(data.mensajes);
                }
                
            } catch (error) {
                chatCuerpo.innerHTML = `<p class="text-center text-danger">${error.message}</p>`;
            }
        }

        function mostrarMensajes(mensajes) {
            chatCuerpo.innerHTML = '';
            let ultimoEmisorId = null;
            if(mensajes.length === 0) {
                 const esCliente = <?php echo ($_SESSION['rol'] ?? 0) == 3 ? 'true' : 'false'; ?>;
                 const hayTecnico = document.getElementById('chat-id-receptor').value > 0;
                 if (esCliente && !hayTecnico) {
                    chatCuerpo.innerHTML = '<p class="text-center text-muted p-3">Un técnico será asignado a tu solicitud en breve. Podrás contactarlo por este medio una vez que tome tu caso.</p>';
                 } else {
                    chatCuerpo.innerHTML = '<p class="text-center text-muted">Aún no hay mensajes. ¡Sé el primero en escribir!</p>';
                 }
                return;
            }
            mensajes.forEach(msg => {
                const esEmisor = (msg.id_emisor == <?php echo $_SESSION['id_usuario']; ?>);
                const rolClase = msg.nombre_rol.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                
                const mensajeDiv = document.createElement('div');
                mensajeDiv.className = `mensaje ${esEmisor ? 'emisor' : 'receptor'}`;

                let contenidoHTML = '';
                if (msg.id_emisor !== ultimoEmisorId && !esEmisor) {
                    let badgeHTML = '';
                    if (rolClase === 'administrador') badgeHTML = '<span class="role-badge admin">Admin</span>';
                    if (rolClase === 'tecnico') badgeHTML = '<span class="role-badge tecnico">Técnico</span>';
                    contenidoHTML += `<div class="mensaje-info"><span class="mensaje-emisor-nombre">${msg.emisor}</span>${badgeHTML}</div>`;
                }
                
                contenidoHTML += `<div class="mensaje-contenido ${rolClase}">${msg.contenido}</div>`;
                mensajeDiv.innerHTML = contenidoHTML;
                chatCuerpo.appendChild(mensajeDiv);
                
                ultimoEmisorId = msg.id_emisor;
            });
            chatCuerpo.scrollTop = chatCuerpo.scrollHeight;
        }

        cerrarChatBtn.addEventListener('click', () => {
            chatVentana.classList.add('chat-ventana-oculta');
            chatLauncher.classList.remove('moved');
        });

        formEnviarMensaje.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const inputMensaje = document.getElementById('chat-input-mensaje');
            if (inputMensaje.value.trim() === '') return;
            
            await fetch('index.php?accion=enviarMensaje', {
                method: 'POST',
                body: formData
            });

            const titulo = document.getElementById('chat-titulo').textContent;
            const id_ticket = titulo.match(/\d+/)[0];
            const target = titulo.includes('Privado') ? 'tecnico' : 'ticket';
            
            inputMensaje.value = '';
            abrirChat(id_ticket, target);
        });
    }

    const successModalEl = document.getElementById('successModal');
    if (successModalEl) {
        const successModal = new bootstrap.Modal(successModalEl);
        successModal.show();
    }
});
</script>

</body>
</html>