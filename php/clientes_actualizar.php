<?php
    require_once "main.php";

    /*== Almacenando id ==*/
    $id = limpiar_cadena($_POST['cliente_id']);

    /*== Verificando cliente ==*/
    $check_cliente = conexion();
    $check_cliente = $check_cliente->query("SELECT * FROM clientes WHERE cliente_id='$id'");

    if ($check_cliente->rowCount() <= 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El cliente no existe en el sistema
            </div>
        ';
        exit();
    } else {
        $datos = $check_cliente->fetch();
    }
    $check_cliente = null;

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

    /*== Verificando nombre ==*/
    if ($nombre != $datos['nombre']) {
        $check_nombre = conexion();
        $check_nombre = $check_nombre->query("SELECT nombre FROM clientes WHERE nombre='$nombre'");
        if ($check_nombre->rowCount() > 0) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
                </div>
            ';
            exit();
        }
        $check_nombre = null;
    }

    /*== Actualizar datos ==*/
    $actualizar_cliente = conexion();
    $actualizar_cliente = $actualizar_cliente->prepare("UPDATE clientes SET nombre=:nombre, apellido=:apellido, email=:email, telefono=:telefono WHERE cliente_id=:id");

    $marcadores = [
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":email" => $email,
        ":telefono" => $telefono,
        ":id" => $id
    ];

    if ($actualizar_cliente->execute($marcadores)) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡CLIENTE ACTUALIZADO!</strong><br>
                El cliente se actualizó con éxito
            </div>
        ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo actualizar el cliente, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_cliente = null;
?>
