<?php require "./inc/session_start.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include "./inc/head.php"; ?>
    </head>
    <body>
        <?php

            // Definir la vista por defecto
            if (!isset($_GET['vista']) || $_GET['vista'] == "") {
                $_GET['vista'] = "login";
            }

            // Verificar que el archivo de la vista existe y no es una vista especial
            if (is_file("./vistas/" . $_GET['vista'] . ".php") && $_GET['vista'] != "login" && $_GET['vista'] != "404") {

                // Comprobar que la sesión está activa
                if ((!isset($_SESSION['id']) || $_SESSION['id'] == "") || (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")) {
                    include "./vistas/logout.php";
                    exit();
                }

                // Incluir la barra de navegación
                include "./inc/navbar.php";

                // Incluir el contenido de la vista
                include "./vistas/" . $_GET['vista'] . ".php";

                // Incluir scripts adicionales
                include "./inc/script.php";

            } else {
                // Verificar si la vista solicitada es login o 404
                if ($_GET['vista'] == "login") {
                    include "./vistas/login.php";
                } else {
                    include "./vistas/404.php";
                }
            }
        ?>
    </body>
</html>
