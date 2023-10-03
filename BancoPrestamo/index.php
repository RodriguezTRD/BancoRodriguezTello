    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../BancoPrestamo/estilos/styles.css">
        <title>Banco Nacional Rodri</title>
    </head>

    <body>
        <!--Menu-->
    <header>
        <nav>
            <ul class="menu">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#clientes">Clientes</a></li>
                <li><a href="#registro">Registro de Usuarios</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
        </nav>
    </header>


    <section id="inicio">
        <div class="contenido">
            <div class="informacion">
                <h2>BANCO NACIONAL <span>RODRI</span></h2>
                <img src="../BancoPrestamo/img/rodri.jpg" alt="Imagen 1">
                <p>Bienvenido a tu Banco favorito a nivel Nacional, nuestra mision es garantizar préstamos rápidos, accesibles y seguro sin intervención de políticas y leyes que rigen pagar al deudor en su próxima cuota.</p>
            </div>
        </div>
    </section>


    <?php
    // Código eliminación de Clientes, nos permite validar el registro a la BD
    include_once 'conexion/conexion.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
        $eliminar_id = $_POST['eliminar_id'];

        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $eliminar_id);

        if ($stmt->execute()) {
            echo '<script>alert("Usuario eliminado correctamente.");</script>';
            echo '<script>window.location.href = "index.php";</script>';
        } else {
            echo '<script>alert("Error al eliminar usuario.");</script>';
        }
    }

    $sql = "SELECT * FROM usuarios";
    $resultado = $conn->query($sql);

    ?>

    <section id="clientes">
        <div class="contenido">
            <h2>Clientes</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Préstamo</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado->num_rows > 0) {
                        while ($fila = $resultado->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $fila['id'] . '</td>';
                            echo '<td>' . $fila['nombre'] . '</td>';
                            echo '<td>' . $fila['dni'] . '</td>';
                            echo '<td>' . $fila['prestamo'] . '</td>';
                            echo '<td>' . $fila['fecha'] . '</td>';
                            echo '<td>';
                            
                            // Creamos solicitud de eliminación
                            echo '<form method="post" style="display: inline-block;">';
                            echo '<input type="hidden" name="eliminar_id" value="' . $fila['id'] . '">';
                            echo '<button type="submit" onclick="return confirm(\'¿Estás seguro de eliminar este usuario?\')">Eliminar</button>';
                            echo '</form>';
                            
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6">No se encontraron registros.</td></tr>';
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>


    <section id="registro">
        <div class="contenido">
            <div class="formulario">
                <h2>Registro</h2>
                <?php
                $mensaje = "";

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
                    $dni = isset($_POST['dni']) ? $_POST['dni'] : "";
                    $prestamo = isset($_POST['prestamo']) ? $_POST['prestamo'] : "";

                    if (empty($nombre) || empty($dni) || empty($prestamo)) {
                        $mensaje = "Por favor, complete todos los campos.";
                    } else {
                        // Conexión a la base de datos
                        $conn = new mysqli("localhost", "root", "", "banco");

                        // Verificar la conexión
                        if ($conn->connect_error) {
                            die("Error de conexión: " . $conn->connect_error);
                        }

                        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, dni, prestamo) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $nombre, $dni, $prestamo);

                        if ($stmt->execute()) {
                            $mensaje = "El usuario se registró correctamente.";
                        } else {
                            $mensaje = "Error al registrar nuevo usuario: " . $conn->error;
                        }

                        $conn->close();
                    }
                }
                ?>
                <form action="index.php#registro" method="post">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Rodrigo Rodriguez" required pattern="[A-Za-z\s]+">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni" pattern="\d{8}" placeholder="12345678" required>
                    <label for="prestamo">Monto de Préstamo:</label>
                    <input type="number" id="prestamo" name="prestamo" placeholder="1 - 10000" required max="10000">
                    <button type="submit">Registrar</button>
                </form>
                <?php echo $mensaje; ?>
            </div>
        </div>
    </section>


    <?php
        $mensaje = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = isset($_POST['correo']) ? $_POST['correo'] : "";
            $asunto = isset($_POST['asunto']) ? $_POST['asunto'] : "";
            $mensaje_texto = isset($_POST['mensaje']) ? $_POST['mensaje'] : "";

            if (empty($correo) || empty($asunto) || empty($mensaje_texto)) {
                $mensaje = "Por favor, complete todos los campos.";
            } else {
                $mensaje = "Mensaje enviado correctamente. Espera respuesta en tu correo.";
            }
        }
    ?>
    <section id="contacto">
        <div class="contenido">
            <div class="formulario">
                <h2>Contacto</h2>
                <form action="index.php#contacto" method="post">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" placeholder="rodriguez@gmail.com" required>
                    <label for="asunto">Asunto:</label>
                    <input type="text" id="asunto" name="asunto" placeholder="..." required>
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" placeholder="..." required></textarea>
                    <button type="submit">Enviar</button>
                </form>
                <p><?php echo $mensaje; ?></p>
            </div>
        </div>
    </section>


    <footer>
        <p>&copy; 2023 Banco Nacional Rodri</p>
    </footer>
    </body>
    </html>
