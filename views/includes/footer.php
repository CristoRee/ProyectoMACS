<link href="assets/css/footerChat.css" rel="stylesheet">
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


<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if(document.getElementById('chat-ventana')) {
        const chatLauncher = document.getElementById('chat-launcher');
        const toggleBtn = document.getElementById('toggle-chat-list');
        const chatList = document.getElementById('chat-list');
        const chatVentana = document.getElementById('chat-ventana');
        const chatCuerpo = document.getElementById('chat-cuerpo');
        const formEnviarMensaje = document.getElementById('form-enviar-mensaje');
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