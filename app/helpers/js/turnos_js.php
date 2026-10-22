<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputFecha = document.getElementById('fecha');
    if (inputFecha) {
        inputFecha.addEventListener('change', function() {
            const diaSeleccionado = new Date(this.value).getUTCDay();
            // 0 es Domingo (si la estética no abre los domingos)
            if (diaSeleccionado === 0) {
                alert('La estética no atiende los días domingos. Por favor selecciona otra fecha.');
                this.value = '';
            }
        });
    }
});
</script>