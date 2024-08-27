// JavaScript para manejar la acción de Aprobar o Rechazar usando AJAX
$(document).ready(function() {
    // Manejar el clic en el botón Aprobar
    $('.btn-success').click(function(e) {
        e.preventDefault();
        var idReceptor = $(this).data('idReceptor'); // Obtener el ID del receptor desde el botón
        
        // Llamar a aceptar-dona.php usando AJAX
        $.ajax({
            url: 'aceptar-dona.php',
            method: 'POST', // O 'GET' dependiendo de cómo manejes la seguridad y los datos
            data: { idReceptor: idReceptor },
            success: function(response) {
                // Actualizar la tabla o mostrar mensaje de éxito
                // Por ejemplo, recargar la página después de aceptar
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error al procesar la solicitud: ' + error);
                alert('Error al procesar la solicitud. Inténtalo de nuevo.');
            }
        });
    });

    // Manejar el clic en el botón Rechazar
    $('.btn-danger').click(function(e) {
        e.preventDefault();
        var idReceptor = $(this).data('Idreceptor'); // Obtener el ID del receptor desde el botón
        
        // Llamar a rechazar-dona.php usando AJAX
        $.ajax({
            url: 'rechazar-dona.php',
            method: 'POST', // O 'GET' dependiendo de cómo manejes la seguridad y los datos
            data: { idReceptor: idReceptor },
            success: function(response) {
                // Actualizar la tabla o mostrar mensaje de éxito
                // Por ejemplo, recargar la página después de rechazar
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error al procesar la solicitud: ' + error);
                alert('Error al procesar la solicitud. Inténtalo de nuevo.');
            }
        });
    });
});
