<?php
    /*== Almacenando datos ==*/
    $cliente_id_del = limpiar_cadena($_GET['cliente_id_del']);

    /*== Verificando cliente ==*/
    $check_cliente = conexion();
    $check_cliente = $check_cliente->query("SELECT cliente_id FROM clientes WHERE cliente_id='$cliente_id_del'");

    if ($check_cliente->rowCount() == 1) {

        /*== Verificando si el cliente tiene órdenes o productos asociados ==*/
        $check_asociados = conexion();
        $check_asociados = $check_asociados->query("SELECT cliente_id FROM ordenes WHERE cliente_id='$cliente_id_del' LIMIT 1");

        if ($check_asociados->rowCount() <= 0) {

            /*== Eliminar cliente ==*/
            $eliminar_cliente = conexion();
            $eliminar_cliente = $eliminar_cliente->prepare("DELETE FROM clientes WHERE cliente_id=:id");

            $eliminar_cliente->execute([":id" => $cliente_id_del]);

            if ($eliminar_cliente->rowCount() == 1) {
                echo '
                    <div class="notification is-info is-light">
                        <strong>¡CLIENTE ELIMINADO!</strong><br>
                        Los datos del cliente se eliminaron con éxito
                    </div>
                ';
            } else {
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        No se pudo eliminar el cliente, por favor intente nuevamente
                    </div>
                ';
            }
            $eliminar_cliente = null;
        } else {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    No podemos eliminar el cliente ya que tiene órdenes asociadas
                </div>
            ';
        }
        $check_asociados = null;
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El CLIENTE que intenta eliminar no existe
            </div>
        ';
    }
    $check_cliente = null;
?>
