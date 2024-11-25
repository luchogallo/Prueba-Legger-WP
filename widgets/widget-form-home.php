
<div id="registro-container">
    <form id="registro-punto-venta">

        <div class="registro-heading">
            <span>1.</span>
            <p>Inscripción punto de venta</p>
        </div>

        <div class="container-input">
            <input type="text" id="nombre_cliente" name="nombre_cliente" pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$" placeholder="Nombre del cliente">
        </div>
        <div class="container-input">
            <input type="text" id="nit" name="nit" pattern="^[0-9]+$" placeholder="NIT">
        </div>
        <div class="container-input">
            <input type="text" id="nombre_punto" name="nombre_punto" placeholder="Nombre del punto">
        </div>
        <div class="container-input">
            <input type="text" id="nombre_equipo" name="nombre_equipo" placeholder="Nombre del equipo">
        </div>

        <select name="ciudad">
            <option value="">Ciudad</option>
            <option value="Bogotá">Bogotá</option>
            <option value="Medellín">Medellín</option>
        </select>

        <input type="text" name="promotor" placeholder="Promotor">
        <input type="text" name="rtc" value="<?php echo isset($_GET['rtc']) ? esc_attr($_GET['rtc']) : ''; ?>" readonly placeholder="RTC">
        <input type="text" name="capitan_usuario" pattern="^[a-z]+$" placeholder="Capitán o Usuario">
        <input type="hidden" name="action" value="guardar_lead">

        <div class="container-checkbox">
            <input type="checkbox" name="tratamiento_datos" required>
            <label>He leído y acepto las políticas de tratamiento de datos</label>
        </div>

        <button class="button-form" type="submit">Siguiente</button>
    </form>

    <div id="mensaje-gracias" style="display: none; text-align: center;">
        <h2>¡Gracias por registrarte!</h2>
        <p>Tu información ha sido guardada exitosamente.</p>
    </div>
</div>