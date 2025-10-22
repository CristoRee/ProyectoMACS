
function confirmarBorrar() {
    return confirm('¿Estás seguro de que quieres borrar este producto?');
}


document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const nombre = form.querySelector('input[name="nombre"]');
            const precio = form.querySelector('input[name="precio"]');
            
            if (nombre && nombre.value.trim() === '') {
                e.preventDefault();
                alert('El nombre es obligatorio');
                return false;
            }
            
            if (precio && (precio.value.trim() === '' || isNaN(precio.value))) {
                e.preventDefault();
                alert('El precio debe ser un número válido');
                return false;
            }
        });
    });
});