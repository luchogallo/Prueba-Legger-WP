document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.getElementById('registro-punto-venta');
    const inputNombreCliente = document.querySelector('#nombre_cliente');
    const inputNit = document.querySelector('#nit');
    const mensajeGracias = document.getElementById('mensaje-gracias');

    [inputNombreCliente, inputNit].forEach(input => {
        input.addEventListener('input', function () {
            validarCampo(input);
        });
    });

    function validarCampo(input) {
        if (input.value.trim() === '') {
            mostrarAlerta(`El campo ${input.id.replace('_', ' ')} es obligatorio`, input.parentElement);
        } else {
            limpiarAlerta(input.parentElement);
        }
    }

    function mostrarAlerta(mensaje, contenedor) {
        limpiarAlerta(contenedor);

        const alerta = document.createElement('p');
        alerta.textContent = mensaje;
        alerta.classList.add('custom-alert');
        contenedor.appendChild(alerta);
    }

    function limpiarAlerta(contenedor) {
        const alertaExistente = contenedor.querySelector('.custom-alert');
        if (alertaExistente) {
            alertaExistente.remove();
        }
    }

    formulario.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!validarFormulario()) {
            return;
        }

        const formData = new FormData(formulario);
        enviarFormulario(formData);
    });

    // Validar los campos obligatorios
    function validarFormulario() {
        let esValido = true;

        [inputNombreCliente, inputNit].forEach(input => {
            if (input.value.trim() === '') {
                validarCampo(input);
                esValido = false;
            }
        });

        return esValido;
    }

    // Envia formulario a través de AJAX
    function enviarFormulario(formData) {
        fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                if (data === 'success') {
                    formulario.style.display = 'none';
                    mensajeGracias.style.display = 'block';
                } else {
                    alert('Hubo un error al enviar los datos. Por favor, inténtalo nuevamente.');
                }
            })
            .catch(error => console.error('Error:', error));
    }
});