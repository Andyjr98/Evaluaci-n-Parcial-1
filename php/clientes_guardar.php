<?php
    require_once "main.php";

    /*== Almacenando datos ==*/
    $nombre = limpiar_cadena($_POST['cliente_nombre']);
    $apellido = limpiar_cadena($_POST['cliente_apellido']);
    $email = limpiar_cadena($_POST['cliente_email']);
    $telefono = limpiar_cadena($_POST['cliente_telefono']);

    /*== Verificando campos obligatorios ==*/
    if ($nombre == "" || $apellido == "" || $email == "" || $telefono == "") {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    /*== Verificando integridad de los datos ==*/
    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,50}", $nombre)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,50}", $apellido)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El APELLIDO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El EMAIL ingresado no es válido
            </div>
        ';
        exit();
    }

    if (verificar_datos("[0-9]{10,15}", $telefono)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El TELÉFONO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    /*== Verificando si el email ya está registrado ==*/
    $check_email = conexion();
    $check_email = $check_email->query("SELECT cliente_email FROM clientes WHERE cliente_email='$email'");
    if ($check_email->rowCount() > 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El EMAIL ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_email = null;

    /*== Guardando datos ==*/
    $guardar_cliente = conexion();
    $guardar_cliente = $guardar_cliente->prepare("INSERT INTO clientes(cliente_nombre, cliente_apellido, cliente_email, cliente_telefono) VALUES(:nombre, :apellido, :email, :telefono)");

    $marcadores = [
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":email" => $email,
        ":telefono" => $telefono
    ];

    $guardar_cliente->execute($marcadores);

    if ($guardar_cliente->rowCount() == 1) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡CLIENTE REGISTRADO!</strong><br>
                El cliente se registró con éxito
            </div>
        ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo registrar el cliente, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_cliente = null;
?>
