<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <!-- Importa Bulma CSS para estilos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <style>
        .hero {
            background-color: #f5f5f5;
            padding: 3rem 1.5rem;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .hero-title {
            color: #4a4a4a;
        }
        .hero-subtitle {
            color: #7a7a7a;
        }
    </style>
</head>
<body>
    <!-- Contenedor principal -->
    <div class="container is-fluid mb-6">
        <h1 class="title">Clientes</h1>
        <h2 class="subtitle">Lista de clientes</h2>
    </div>

    <div class="container pb-6 pt-6">
        <?php
            require_once "./php/main.php";

            # Eliminar cliente #
            if (isset($_GET['cliente_id_del'])) {
                require_once "./php/cliente_eliminar.php";
            }

            if (!isset($_GET['page'])) {
                $pagina = 1;
            } else {
                $pagina = (int) $_GET['page'];
                if ($pagina <= 1) {
                    $pagina = 1;
                }
            }

            $pagina = limpiar_cadena($pagina);
            $url = "index.php?vista=cliente_list&page="; /* <== */
            $registros = 15;
            $busqueda = "";

            # Paginador cliente #
            require_once "./php/clientes_lista.php";
        ?>
    </div>
</body>
</html>
