
document.getElementById('registro-punto-venta').addEventListener('submit', function (e) {
    e.preventDefault(); 

    const form = e.target;
    const formData = new FormData(form);

    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                document.getElementById('registro-punto-venta').style.display = 'none';
                document.getElementById('mensaje-gracias').style.display = 'block';
            } else {
                alert('Hubo un error al enviar los datos. Por favor, inténtalo nuevamente.');
            }
        })
        .catch(error => console.error('Error:', error));
});