<?php
// Conexión a la base de datos (ajusta estos valores según tu configuración)
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "inventario";

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los valores del formulario
    $factura = $_POST['valorFactura'];
    $codigo = $_POST['valorCodigo'];
    $nombre = $_POST['valorNombre'];
    $fechaEntrada = $_POST['valorFechaEntrada'];
    $cantidadEntrada = $_POST['valorCantidadEntrada'];
    $fechaSalida = !empty($_POST['valorFechaSalida']) ? $_POST['valorFechaSalida'] : NULL;  // Si no se proporciona, asignar NULL
    $cantidadSalida = !empty($_POST['valorCantidadSalida']) ? $_POST['valorCantidadSalida'] : 0;  // Si no se proporciona, asignar 0
    $proveedor = $_POST['valorProveedor'];
    $ubicacion = $_POST['valorUbicacion'];
    $observaciones = $_POST['valorObservaciones'];

    // Usar sentencia preparada para insertar los datos en la base de datos
    $stmt = $conn->prepare("INSERT INTO registros (factura, codigo, nombre_producto, fecha_entrada, cantidad_entrada, fecha_salida, cantidad_salida, proveedor, ubicacion, observaciones) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Enlazar los parámetros a la sentencia preparada
    $stmt->bind_param("ssssiiisss", $factura, $codigo, $nombre, $fechaEntrada, $cantidadEntrada, $fechaSalida, $cantidadSalida, $proveedor, $ubicacion, $observaciones);
    
    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo "<script>alert('Registro Exitoso!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    // Cerrar la conexión y la sentencia
    $stmt->close();
    $conn->close();
}
?>



<html>
<html>
<head>
    <title>Registro Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .carousel {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%; 
            z-index: 0;
        }

        .carousel-item img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
        }

        .header {
            background-color: black;
            height: 100px; 
            width: 100%; 
            position: absolute; 
            top: 0;
            left: 0;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-left: 20px;
        }

        .header img {
            height: 100px; 
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            padding-top: 150px; /* Separar el formulario del fondo negro */
            z-index: 2; /* Asegura que el formulario esté encima del fondo */
            position: relative;
            background-color: rgba(255, 255, 255, 0.4); /* Fondo blanco con transparencia */
            padding: 20px;
            border-radius: 8px; /* Bordes redondeados para el formulario */
            margin-top: 105px; /* Aumentar la separación con el fondo negro */
        }
        
        h1 {
            color: ##050505;
            text-align: center;
            font-weight: bold;
        }

        .container .row .col-3 {
            font-weight: bold;
            white-space: nowrap;
        }
        select {
            -webkit-appearance: none; /* Eliminar la apariencia predeterminada */
            -moz-appearance: none;
            appearance: none;
            background: url('https://img.icons8.com/ios-filled/50/000000/chevron-down.png') no-repeat right 10px center; /* Flecha a la derecha pero movida ligeramente hacia la izquierda */
            background-size: 15px 15px; /* Ajusta el tamaño de la flecha */
            padding-right: 60px; /* Espacio adicional a la derecha para que la flecha no se sobreponga */
        }
    </style>
</head>
<body>
    <!-- Carrusel -->
    <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="3000">
                <img src="img/Inventario.png" class="d-block w-100" alt="Fondo 1">
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="img/Imagen2.png" class="d-block w-100" alt="Fondo 2">
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="img/Imagen3.png" class="d-block w-100" alt="Fondo 3">
            </div>
        </div>
    </div>

    <!-- Fondo negro en la parte superior -->
    <div class="header">
        <img src="img/Logo.png" alt="Logo">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Registro Inventario</h1>
            </div>
        </div>

        <!-- Formulario -->
        <form method="POST">
            <div class="row" style="margin-top: 10px;">
                <div class="col-3">*Número de Factura</div>
                <div class="col-9">
                    <div class="input-group">
                        <span class="input-group-text">#</span>
                        
                        <input type="text" name="valorFactura" class="form-control" required>
                   </div>
                </div>
            </div>
        
            <div class="row" style="margin-top: 10px;">
                <div class="col-3">*Código</div>
                <div class="col-9">
                    <div class="input-group">
                        <span class="input-group-text">#</span>
                        <input type="text" name="valorCodigo" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 10px;">
                <div class="col-3">*Nombre Producto</div>
                <div class="col-9">
                    <select name="valorNombre" class="form-control" required>
                        <option value="" disabled selected>Seleccione material</option>
                        <option value="CAJA RATWELT 5800 3/4">CAJA RATWELT 5800 3/4</option>
                        <option value="TOMA DE INCRUSTAR CODELCA 50A/250V BIFASICA">TOMA DE INCRUSTAR CODELCA 50A/250V BIFASICA </option>
                        <option value="CABLE No 8 DESNUDO">CABLE No 8 DESNUDO</option>
                        <option value="CABLE ENCAUCHETADO 3 X 14">CABLE ENCAUCHETADO 3 X 14</option>
                        <option value="BREAKER ENCHUFABLE LEGRAN 1 X 20 A">BREAKER ENCHUFABLE LEGRAN 1 X 20 A</option>
                        <option value="TERMINAL PVC 1">TERMINAL PVC 1</option>
                    </select>
                </div>
            </div>

            <div class="row" style="margin-top: 10px;">
                <div class="col-3">*Fecha de Entrada</div>
                <div class="col-9">
                    <input type="date" name="valorFechaEntrada" class="form-control" required>
                </div>
            </div>

            <div class="row" style="margin-top: 10px;">
                <div class="col-3">*Cantidad de Entrada</div>
                <div class="col-9">
                    <input type="number" name="valorCantidadEntrada" class="form-control" min="1" required>
                </div>
            </div>

            <div class="row" style="margin-top: 10px;">
                <div class="col-3">*Fecha de Salida</div>
                <div class="col-9">
                    <input type="date" name="valorFechaSalida" class="form-control">
                </div>
            </div>

            <div class="row" style="margin-top: 10px;">
                <div class="col-3">*Cantidad de Salida</div>
                <div class="col-9">
                    <input type="number" name="valorCantidadSalida" class="form-control" min="0">
                </div>
            </div>

            <div class="row" style="margin-top: 10px;">
                <div class="col-3">*Proveedor</div>
                <div class="col-9">
                    <select name="valorProveedor" class="form-control" required>
                        <option value="" disabled selected>Seleccione el proveedor</option>
                        <option value="ELECTRICOS HR">ELECTRICOS HR</option>
                        <option value="FERRELECTRICOS DIEGO NOVOA">FERRELECTRICOS DIEGO NOVOA</option>
                        <option value="MEM">MEM</option>
                        <option value="NACIONAL DE ELECTRICOS HH">NACIONAL DE ELECTRICOS HH</option>
                        <option value="GRUPO ELECTRICO PERSA">GRUPO ELECTRICO PERSA  GEP SAS</option>
                    </select>
                </div>
            </div>

            <div class="row" style="margin-top: 10px;">
                <div class="col-3">*Sede</div>
                <div class="col-9">
                    <select name="valorUbicacion" class="form-control" required>
                        <option value="" disabled selected>Seleccione una sede</option>
                        <option value="Almacen">Almacen</option>
                        <option value="Compensar">Compensar</option>
                        <option value="Jardines">Jardines</option>
                        <option value="Comedores">Comedores</option>
                        <option value="Otros Clientes">Otros Clientes</option>
                    </select>
                </div>
            </div>

            <div class="row" style="margin-top: 10px;">
                <div class="col-3">*Observaciones</div>
                <div class="col-9">
                    <textarea name="valorObservaciones" class="form-control"></textarea>
                </div>
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="col-12">
                    <button type="submit" style="width: 100%;" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
