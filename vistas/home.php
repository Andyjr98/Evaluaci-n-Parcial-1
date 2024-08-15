<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
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
    <div class="container is-fluid">
        <!-- Sección de bienvenida -->
        <section class="hero">
            <h1 class="title hero-title">Inicio</h1>
            <h2 class="subtitle hero-subtitle">¡Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']) . " " . htmlspecialchars($_SESSION['apellido']); ?>!</h2>
        </section>
    </div>

    <!-- Incluye la biblioteca de Bulma JavaScript si es necesario -->
    <script src="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css"></script>
</body>
</html>
