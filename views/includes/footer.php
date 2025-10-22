</div> <?php if (isset($_SESSION['id_usuario'])): ?>

<div class="chat-launcher" id="chat-launcher">
    <span id="launcher-text"><?php echo __('active_chats'); ?></span>
    <button id="toggle-chat-list"><i class="fas fa-chevron-up"></i></button>
</div>

<div class="chat-list" id="chat-list">
    <div class="chat-list-header"><?php echo __('my_conversations'); ?></div>
    <ul class="chat-list-body" id="chat-list-body">
    </ul>
</div>

<div id="chat-ventana" class="chat-ventana-oculta">
    <div class="chat-header">
        <span id="chat-titulo">Chat del Ticket #</span>
        <div>
            <button id="info-chat" type="button" data-bs-toggle="popover" data-bs-placement="left" title="<?php echo __('ticket_information'); ?>">
                <i class="fas fa-info-circle"></i>
            </button>
            <button id="cerrar-chat" type="button">&times;</button>
        </div>
    </div>
    <div class="chat-cuerpo" id="chat-cuerpo"></div>
    <div class="chat-footer">
        <form id="form-enviar-mensaje" autocomplete="off">
            <input type="hidden" name="id_ticket" id="chat-id-ticket">
            <input type="hidden" name="target" id="chat-target">
            <input type="hidden" name="id_conversacion" id="chat-id-conversacion">
            <input type="hidden" name="id_receptor" id="chat-id-receptor">
            <input type="text" name="contenido" id="chat-input-mensaje" placeholder="<?php echo __('chat_placeholder'); ?>" required>
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

.visto { font-size: 0.8em; margin-left: 5px; }
.visto-leido { color: #28a745; } /* Verde para visto */
.visto-no-leido { color: #6c757d; } /* Gris para no visto */

/* Colores de los globos de chat */
.mensaje.emisor .mensaje-contenido { background-color: #0d6efd; color: white; }
.mensaje.receptor .mensaje-contenido.cliente { background-color: #e9ecef; color: #212529; }
.mensaje.receptor .mensaje-contenido.tecnico { background-color: #cff4fc; color: #055160; }
.mensaje.receptor .mensaje-contenido.administrador { background-color: #fff3cd; color: #664d03; }

.mensaje.emisor, .mensaje.receptor { width: 100%; }
.mensaje.emisor { align-items: flex-end; }
.mensaje.receptor { align-items: flex-start; }
</style>

<?php endif; ?>

<?php
$accion = $_GET['accion'] ?? 'inicio';
$showManualButton = true; // Mostrar siempre

if ($showManualButton): ?>
<a href="Documentos/Manual_Usuario_ProyectoMACS_Usuario.php" id="manual-flotante" class="manual-flotante" title="<?php echo __('user_manual'); ?>" target="_blank" rel="noopener">
    <i class="fas fa-book me-1"></i><?php echo __('manual'); ?>
</a>
<?php endif; ?>

<script>
    const traducciones = {
        loading: '<?php echo addslashes(__('loading')); ?>',
        new_message: '<?php echo addslashes(__('new_message')); ?>',
        error_loading_chat: '<?php echo addslashes(__('error_loading_chat')); ?>',
        technician_assigned_soon: '<?php echo addslashes(__('technician_assigned_soon')); ?>',
        active_chats: '<?php echo addslashes(__('active_chats')); ?>',
        no_active_conversations: '<?php echo addslashes(__('no_active_conversations')); ?>',
        chat_with_admin: '<?php echo addslashes(__('chat_with_admin')); ?>',
        private_chat: '<?php echo addslashes(__('private_chat')); ?>',
        chat_of_ticket: '<?php echo addslashes(__('chat_of_ticket')); ?>',
        be_first_to_write: '<?php echo addslashes(__('be_first_to_write')); ?>',
        private: '<?php echo addslashes(__('private')); ?>'
    };
</script>

<script>
    let ultimoConteoMensajes = -1;
    let chatAbierto = false;
    let ultimoTiempoNotificacion = 0;

    async function chequearMensajesNuevos() {
        try {
            const response = await fetch('index.php?accion=cargarListaChats');
            if (!response.ok) return;
            const conversaciones = await response.json();
            
            let totalMensajesNoLeidos = 0;
            conversaciones.forEach(conv => {
                totalMensajesNoLeidos += conv.mensajes_no_leidos || 0;
            });
            
            actualizarConteoLauncher(totalMensajesNoLeidos);
            
            if (!chatAbierto && ultimoConteoMensajes >= 0 && totalMensajesNoLeidos > ultimoConteoMensajes && (Date.now() - ultimoTiempoNotificacion > 5000)) {
                mostrarNotificacion(`${traducciones.new_message} (${totalMensajesNoLeidos})`);
                ultimoTiempoNotificacion = Date.now();
            }
            ultimoConteoMensajes = totalMensajesNoLeidos;
        } catch (error) {
            console.error('Error chequeando mensajes nuevos:', error);
        }
    }

    function actualizarConteoLauncher(total) {
        const text = total > 0 ? `${traducciones.active_chats} (${total})` : traducciones.active_chats;
        document.getElementById('launcher-text').textContent = text;
    }

    // Iniciar polling global cada 10 segundos si hay usuario logueado
    <?php if (isset($_SESSION['id_usuario'])): ?>
    setInterval(chequearMensajesNuevos, 8000);
    // Inicializar conteo al cargar
    chequearMensajesNuevos();
    <?php endif; ?>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- Lógica del Chat ---
    if(document.getElementById('chat-ventana')) {
        const chatLauncher = document.getElementById('chat-launcher');
        const toggleBtn = document.getElementById('toggle-chat-list');
        const chatList = document.getElementById('chat-list');
        const chatVentana = document.getElementById('chat-ventana');
        const chatCuerpo = document.getElementById('chat-cuerpo');
        const formEnviarMensaje = document.getElementById('form-enviar-mensaje');
        const inputMensaje = document.getElementById('chat-input-mensaje');
        const cerrarChatBtn = document.getElementById('cerrar-chat');
        let infoPopover = null;
        
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
                        
                        let nombreChat = conv.otro_participante || 'Técnico no asignado';
                        let tipoTarget = conv.target || 'ticket';

                        if(tipoTarget === 'privado') {
                           nombreChat += ` <span class="badge bg-info text-dark">${traducciones.private}</span>`;
                        }

                        let unreadBadge = conv.mensajes_no_leidos > 0 ? `<span class="badge bg-danger">${conv.mensajes_no_leidos}</span>` : '';

                        listItem.innerHTML = `<div>${nombreChat} ${unreadBadge}</div><small>Ticket #${conv.id_ticket}</small>`;
                        
                        listItem.onclick = () => {

                            if (tipoTarget === 'privado') {

                                abrirChat(conv.id_conversacion, tipoTarget);

                            } else {

                                abrirChat(conv.id_ticket, tipoTarget);

                            }

                            chatList.style.display = 'none';

                            toggleBtn.classList.remove('open');

                        };
                        listBody.appendChild(listItem);
                    });
                } else {
                    listBody.innerHTML = `<li class="chat-list-item text-muted">${traducciones.no_active_conversations}</li>`;
                }

                // Agregar opción para chat privado si es técnico
                if (<?php echo ($_SESSION['rol'] ?? 0) == 2 ? 'true' : 'false'; ?>) {
                    const privateItem = document.createElement('li');
                    privateItem.className = 'chat-list-item';
                    privateItem.innerHTML = traducciones.chat_with_admin;
                    privateItem.onclick = async () => {
                        try {
                            const response = await('index.php?accion=cargarChat&target=privado');
                            const data = await response.json();
                            abrirChat(data.id_conversacion, 'privado');
                            chatList.style.display = 'none';
                            toggleBtn.classList.remove('open');
                        } catch (error) {
                            console.error('Error iniciando chat privado:', error);
                        }
                    };
                    listBody.appendChild(privateItem);
                } else if (<?php echo ($_SESSION['rol'] ?? 0) == 1 ? 'true' : 'false'; ?>) {
                    // Para admin, mostrar lista de técnicos
                    try {
                        const response = await fetch('index.php?accion=cargarTecnicos');
                        const tecnicos = await response.json();
                        tecnicos.forEach(tecnico => {
                            const tecnicoItem = document.createElement('li');
                            tecnicoItem.className = 'chat-list-item';
                            tecnicoItem.innerHTML = `Chat con ${tecnico.nombre_usuario}`;
                            tecnicoItem.onclick = async () => {
                                try {
                                    const response = await fetch(`index.php?accion=cargarChat&target=privado&id_tecnico=${tecnico.id_usuario}`);
                                    const data = await response.json();
                                    abrirChat(data.id_conversacion, 'privado');
                                    chatList.style.display = 'none';
                                    toggleBtn.classList.remove('open');
                                } catch (error) {
                                    console.error('Error iniciando chat con técnico:', error);
                                }
                            };
                            listBody.appendChild(tecnicoItem);
                        });
                    } catch (error) {
                        console.error('Error cargando técnicos:', error);
                    }
                }
            }
        });

        window.abrirChat = async function(id, target = 'ticket') {
            chatAbierto = true;
            chatLauncher.classList.add('moved');
            chatVentana.classList.remove('chat-ventana-oculta');
            
            let tituloChat = (target === 'privado') 
                ? traducciones.private_chat 
                : `${traducciones.chat_of_ticket}${id}`;
            document.getElementById('chat-titulo').textContent = tituloChat;
            
            chatCuerpo.innerHTML = `<p class="text-center">${traducciones.loading}</p>`;
            try {
                let url = (target === 'privado') 
                    ? `index.php?accion=cargarChat&id_conversacion=${id}&target=privado`
                    : `index.php?accion=cargarChat&id_ticket=${id}&target=${target}`;
                const response = await fetch(url);
                if (!response.ok) throw new Error('Error al cargar datos del chat.');
                const data = await response.json();
                
                document.getElementById('chat-id-conversacion').value = data.id_conversacion;
                document.getElementById('chat-id-receptor').value = data.id_receptor;
                document.getElementById('chat-id-ticket').value = id; // for private, not used
                document.getElementById('chat-target').value = target;
                
                const infoBtn = document.getElementById('info-chat');
                const tecnicoAsignado = data.info.nombre_tecnico || 'Sin asignar';
                const popoverContent = (target === 'privado') 
                    ? `<b>Chat Privado:</b> ${data.info.nombre_cliente}`
                    : `<b>Cliente:</b> ${data.info.nombre_cliente}<br><b>Dispositivo:</b> ${data.info.tipo_producto} ${data.info.marca}<br><b>Técnico:</b> ${tecnicoAsignado}`;
                
                if(infoPopover) infoPopover.dispose();
                infoBtn.setAttribute('data-bs-content', popoverContent);
                infoPopover = new bootstrap.Popover(infoBtn, {html: true});
                
                const esCliente = <?php echo ($_SESSION['rol'] ?? 0) == 3 ? 'true' : 'false'; ?>;
                
                if (esCliente && !data.tecnico_asignado) {
                    chatCuerpo.innerHTML = `<p class="text-center text-muted p-3">${traducciones.technician_assigned_soon}</p>`;
                    formEnviarMensaje.style.display = 'none';
                } else {
                    formEnviarMensaje.style.display = 'flex';
                    mostrarMensajes(data.mensajes);
                }
                
                // Iniciar polling para actualizar mensajes cada 5 segundos
                if (window.chatInterval) clearInterval(window.chatInterval);
                window.chatInterval = setInterval(() => actualizarMensajes(id, target), 500);
                
            } catch (error) {
                chatCuerpo.innerHTML = `<p class="text-center text-danger">${traducciones.error_loading_chat}</p>`;
            }
        }

        function mostrarMensajes(mensajes, append = false) {
            const chatCuerpo = document.getElementById('chat-cuerpo');
            let ultimoEmisorId = null;
            
            if (!append) {
                // Remover mensajes optimistas antes de recargar
                chatCuerpo.querySelectorAll('.mensaje-optimista').forEach(el => el.remove());
                
                chatCuerpo.innerHTML = '';
                
                if(mensajes.length === 0) {
                     const esCliente = <?php echo ($_SESSION['rol'] ?? 0) == 3 ? 'true' : 'false'; ?>;
                     const hayTecnico = document.getElementById('chat-id-receptor').value && document.getElementById('chat-id-receptor').value != <?php echo $_SESSION['id_usuario'] ?? 0; ?>;
                     if (esCliente && !hayTecnico) {
                        chatCuerpo.innerHTML = '<p class="text-center text-muted p-3">Un técnico será asignado a tu solicitud en breve...</p>';
                        formEnviarMensaje.style.display = 'none';
                     } else {
                        chatCuerpo.innerHTML = `<p class="text-center text-muted">${traducciones.be_first_to_write}</p>`;
                     }
                    return;
                }
            } else {
                // Para append, obtener el último emisor del chat existente
                const lastMessage = chatCuerpo.querySelector('.mensaje:last-child');
                if (lastMessage) {
                    ultimoEmisorId = lastMessage.dataset.emisorId;
                }
            }

            mensajes.forEach(msg => {
                const esEmisor = (msg.id_emisor == <?php echo $_SESSION['id_usuario'] ?? 0; ?>);
                const rolClase = msg.nombre_rol.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                
                const mensajeDiv = document.createElement('div');
                mensajeDiv.className = `mensaje ${esEmisor ? 'emisor' : 'receptor'}`;
                mensajeDiv.dataset.emisorId = msg.id_emisor;
                let contenidoHTML = '';
                if (msg.id_emisor !== ultimoEmisorId && !esEmisor) {
                    let badgeHTML = '';
                    if (rolClase === 'administrador') badgeHTML = '<span class="role-badge admin">Admin</span>';
                    if (rolClase === 'tecnico') badgeHTML = '<span class="role-badge tecnico">Técnico</span>';
                    contenidoHTML += `<div class="mensaje-info"><span class="mensaje-emisor-nombre">${msg.emisor}</span>${badgeHTML}</div>`;
                }
                contenidoHTML += `<div class="mensaje-contenido ${rolClase}">${msg.contenido}`;
                if (esEmisor) {
                    contenidoHTML += `<span class="visto ${msg.leido ? 'visto-leido' : 'visto-no-leido'}">${msg.leido ? '✓✓' : '✓'}</span>`;
                }
                contenidoHTML += `</div>`;
                mensajeDiv.innerHTML = contenidoHTML;
                chatCuerpo.appendChild(mensajeDiv);
                ultimoEmisorId = msg.id_emisor;
            });
            chatCuerpo.scrollTop = chatCuerpo.scrollHeight;
        }

        async function actualizarMensajes(id_ticket, target) {
            try {
                let url = (target === 'privado') 
                    ? `index.php?accion=cargarChat&id_conversacion=${id_ticket}&target=${target}`
                    : `index.php?accion=cargarChat&id_ticket=${id_ticket}&target=${target}`;
                const response = await fetch(url);
                if (!response.ok) return;
                const data = await response.json();
                
                const mensajesActuales = data.mensajes;
                const chatCuerpo = document.getElementById('chat-cuerpo');
                const mensajesAnteriores = chatCuerpo.querySelectorAll('.mensaje').length;
                
                if (mensajesActuales.length > mensajesAnteriores) {
                    // Remover mensajes optimistas
                    chatCuerpo.querySelectorAll('.mensaje-optimista').forEach(el => el.remove());
                    
                    // Hay mensajes nuevos
                    const nuevosMensajes = mensajesActuales.slice(mensajesAnteriores);
                    mostrarMensajes(nuevosMensajes, true);
                    
                    // Mostrar notificación
                    mostrarNotificacion(traducciones.new_message);
                }
            } catch (error) {
                console.error('Error al actualizar mensajes:', error);
            }
        }

        function mostrarMensajeOptimista(contenido) {
            const chatCuerpo = document.getElementById('chat-cuerpo');
            const mensajeDiv = document.createElement('div');
            mensajeDiv.className = 'mensaje emisor mensaje-optimista';
            mensajeDiv.innerHTML = `<div class="mensaje-contenido">${contenido}<span class="visto visto-no-leido">⏳</span></div>`;
            chatCuerpo.appendChild(mensajeDiv);
            chatCuerpo.scrollTop = chatCuerpo.scrollHeight;
        }

        function crearToastContainer() {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.style.zIndex = '1056';
            document.body.appendChild(container);
            return container;
        }

        cerrarChatBtn.addEventListener('click', () => {
            chatAbierto = false;
            chatVentana.classList.add('chat-ventana-oculta');
            chatLauncher.classList.remove('moved');
            if (window.chatInterval) {
                clearInterval(window.chatInterval);
                window.chatInterval = null;
            }
        });

        formEnviarMensaje.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const contenido = inputMensaje.value.trim();
            if (contenido === '') return;
            
            const id_ticket = document.getElementById('chat-id-ticket').value;
            const target = document.getElementById('chat-target').value;
            
            inputMensaje.value = '';
            
            // Mostrar mensaje inmediatamente
            mostrarMensajeOptimista(contenido);
            
            // Enviar en background
            fetch('index.php?accion=enviarMensaje', { method: 'POST', body: formData })
                .then(() => {
                    // Después de enviar exitosamente, actualizar para confirmar estado
                    actualizarMensajes(id_ticket, target);
                })
                .catch(error => {
                    console.error('Error al enviar mensaje:', error);
                    // Si falla, mostrar error
                    mostrarNotificacion('Error al enviar mensaje');
                });
        });
    }

    // --- Lógica del Modal de Éxito ---
    const successModalEl = document.getElementById('successModal');
    if (successModalEl) {
        const successModal = new bootstrap.Modal(successModalEl);
        successModal.show();
    }

    // =============================================
    // INICIO: CÓDIGO PARA EL MODO OSCURO
    // =============================================
    const darkModeSwitch = document.getElementById('darkModeSwitch');
    const body = document.body;

    const enableDarkMode = () => {
        body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark');
        if (darkModeSwitch) darkModeSwitch.checked = true;
    }

    const disableDarkMode = () => {
        body.classList.remove('dark-mode');
        localStorage.setItem('theme', 'light');
        if (darkModeSwitch) darkModeSwitch.checked = false;
    }

    if (localStorage.getItem('theme') === 'dark') {
        enableDarkMode();
    }

    if (darkModeSwitch) {
        darkModeSwitch.addEventListener('change', () => {
            if (darkModeSwitch.checked) {
                enableDarkMode();
            } else {
                disableDarkMode();
            }
        });
    }
    // =============================================
    // FIN: CÓDIGO PARA EL MODO OSCURO
    // =============================================
});
</script>

<style>
body.dark-mode {
    background-color: #121212;
    color: #e0e0e0;
}
.dark-mode .card, 
.dark-mode .modal-content, 
.dark-mode .table,
.dark-mode .list-group-item,
.dark-mode .chat-list,
.dark-mode .chat-list-header {
    background-color: #1e1e1e;
    color: #e0e0e0;
    border-color: #2c2c2c;
}
.dark-mode .table-dark th {
    background-color: #000 !important;
    border-color: #32383e;
}
.dark-mode .form-control, .dark-mode .form-select {
    background-color: #2c2c2c;
    color: #e0e0e0;
    border-color: #444;
}
.dark-mode .form-control:focus, .dark-mode .form-select:focus {
    background-color: #2c2c2c;
    color: #e0e0e0;
    border-color: #0d6efd;
    box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
}
.dark-mode .text-muted {
    color: #888 !important;
}
.dark-mode .border, .dark-mode .border-bottom {
    border-color: #444 !important;
}
</style>

</body>
</html>