<?php
// 1) Conexion
$conexion = mysqli_connect("127.0.0.1", "root", "");
mysqli_select_db($conexion, "upestudio");

// 2) Almacenamos el ID del artículo a editar del envío GET
$id = $_GET['id'];

// 3) Preparar la consulta SQL para obtener los datos del artículo a editar
$consulta = "SELECT * FROM productos WHERE id=$id";
$respuesta = mysqli_query($conexion, $consulta);

// 4) Verificar si se encontró el registro y obtener los datos
if ($datos = mysqli_fetch_array($respuesta)) {
    $articulo = $datos["articulo"];
    $marca = $datos["marca"];
    $categoria = $datos["categoria"];
    $precio = $datos["precio"];
    $pago = $_POST['pago'] ?? '';
    $imagen = $datos['imagen'];
    $imagen2 =$datos ['imagen_  2'];
} else {
    die("El artículo con ID $id no fue encontrado.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Artículo</title>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <header><h2>Editar Artículo</h2></header>

    <nav class="nav">
        <a class="nav-link active" aria-current="page" href="index.php"><button type="button" class="btn btn-outline-warning">Home</button></a>
        <a class="nav-link" href="listar.php"><button type="button" class="btn btn-outline-warning">Lista de Artículos</button></a>
        <a class="nav-link" href="agregar.html"><button type="button" class="btn btn-outline-warning">Agregar Artículo</button></a>
    </nav>

    <p>Ingrese los nuevos datos del artículo.</p>
    
    <form action="editar.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <label for="">Tipo de Artículo</label>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Artículo</span>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="articulo" placeholder="Ej. Remera, Buzo, etc." required value="<?php echo $articulo; ?>">
        </div>
        <label for="">Marca</label>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Marca</span>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="marca" placeholder="Ej. Nike, Adidas, etc" required value="<?php echo $marca; ?>">
        </div>
        <label for="">Categoría</label>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Categoría</span>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="categoria" placeholder="Ej. xl, m, s, etc" required value="<?php echo $categoria; ?>">
        </div>
        <label for="">Precio</label>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Precio</span>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="precio" id="precio" placeholder="Ej. 2000" required value="<?php echo $precio; ?>">
        </div>
        <hr>
        </div>
        <label for="">Link de pago</label>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Ingresar URL del pago</span>
            <input type="text" class="form-control" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="pago" placeholder="Ej. 2000" required>
        </div>
        <hr>
        <h4>Imagenes:</h4>
            
            </div>
            <label for="">Selecciona una imagen</label>
            <div>
                <input type="file" name="imagen">
            </div>
        </div>
        <label for="">Selecciona una imagen</label>
        <div>
            <input type="file" name="imagen2">
        </div>
            <hr>
            <button type="submit" class="btn btn-outline-warning">Agregar Artículo</button>
        <hr>
        <div class="col-12">
            <button class="btn btn-outline-warning" type="submit" value="submit" name="guardar_cambios">Guardar Cambios</button>
            <a class="btn btn-outline-danger" href="listar.php">Cancelar</a>
        </div>
    </form>

    <?php
    // Si se envió el formulario para guardar cambios
    if (isset($_POST['guardar_cambios'])) {
        // Reabrir la conexión para actualizar los datos
        $conexion = mysqli_connect("127.0.0.1", "root", "");
        mysqli_select_db($conexion, "upestudio");

        // 2') Almacenamos los datos actualizados del envío POST
        $articulo = $_POST['articulo'];
        $marca = $_POST['marca'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        
        // Manejo de la imagen, si se desea actualizar
        if ($_FILES['imagen']['tmp_name']) {
            $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
            $consulta_actualizacion = "UPDATE productos SET articulo='$articulo', marca='$marca', categoria='$categoria', precio='$precio', imagen='$imagen' WHERE id=$id";
        } else {
            $consulta_actualizacion = "UPDATE productos SET articulo='$articulo', marca='$marca', categoria='$categoria', precio='$precio' WHERE id=$id";
        }

        // 4') Ejecutar la orden y actualizamos los datos
        if (mysqli_query($conexion, $consulta_actualizacion)) {
            // Redirigir a la página de listar después de la actualización exitosa
            header('location: listar.php');
            exit;
        } else {
            // Manejar error en la actualización
            die("Error al actualizar los datos: " . mysqli_error($conexion));
        }

        // Cerrar la conexión
        mysqli_close($conexion);
    }
    ?>
</body>
</html>

