</div> <!-- Cierra el <div class="container mt-4"> del header.php -->
    
    <!-- Este es el script de JavaScript de Bootstrap. Siempre se carga primero. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para mostrar el modal de éxito automáticamente si existe en la página -->
    <script>
        // Espera a que todo el contenido de la página (DOM) esté completamente cargado.
        document.addEventListener('DOMContentLoaded', function() {
            
            // Busca si existe un elemento con el ID 'successModal' en la página.
            const successModalEl = document.getElementById('successModal');
            
            // Si el elemento existe (porque inicio.php lo imprimió), entonces lo mostramos.
            if (successModalEl) {
                const successModal = new bootstrap.Modal(successModalEl);
                successModal.show();
            }
        });
    </script>

</body>
</html>
