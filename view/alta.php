<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo coche</title>
    <!-- Enlace a la CDN de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Insertar un nuevo coche</h1>

        <!-- Formulario con clases de Bootstrap -->
        <form action="/proyectos/coches2/index.php/guardarCoche" method="post">
            <div class="mb-3">
                <label for="marca" class="form-label">Marca:</label>
                <input type="text" name="marca" id="marca" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo:</label>
                <input type="text" name="modelo" id="modelo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="color" class="form-label">Color:</label>
                <input type="text" name="color" id="color" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="propietario" class="form-label">Propietario:</label>
                <input type="text" name="propietario" id="propietario" class="form-control" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Insertar Coche</button>
            </div>
        </form>
    </div>

    <!-- Enlace al script de Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
