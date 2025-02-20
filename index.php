<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Conciliación Bancaria</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Bienvenido al Sistema de Conciliación Bancaria</h1>
    
      
    <hr>
    
    <!-- Panel de Gestión de Conciliaciones -->
    <h2>Gestión de Conciliaciones</h2>
    <form action="" method="POST">
        <input type="text" name="nombre" placeholder="Nombre Usuario" required>
        <input type="email" name="correo" placeholder="Correo Usuario" required>
        <button type="submit" name="agregar_usuario">Agregar Usuario</button>
    </form>

    <?php
    if (isset($_POST['agregar_usuario'])) {
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];

        $sql = "INSERT INTO usuarios (nombre, correo) VALUES ('$nombre', '$correo')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Usuario agregado con éxito.</p>";
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
    
    <hr>
    
    <!-- Panel de Conciliaciones -->
    <h2>Conciliaciones Bancarias</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Diferencia</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php
        $sql = "SELECT c.id, u.nombre, c.fecha, c.diferencia, c.estado FROM conciliaciones c JOIN usuarios u ON c.usuario_id = u.id";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['fecha']}</td>
                        <td>\${$row['diferencia']}</td>
                        <td>{$row['estado']}</td>
                        <td>
                            <a href='editar.php?id={$row['id']}'>✏️ Editar</a>
                            <a href='eliminar.php?id={$row['id']}' onclick='return confirm(\"¿Eliminar?\")'>❌ Eliminar</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay conciliaciones registradas.</td></tr>";
        }
        ?>
    </table>
    
    <!-- Formulario para Agregar Conciliación -->
    <h2>Agregar Conciliación</h2>
    <form action="" method="POST">
        <input type="text" name="usuario_id" placeholder="ID Usuario" required>
        <input type="date" name="fecha" required>
        <input type="number" step="0.01" name="diferencia" placeholder="Diferencia" required>
        <select name="estado">
            <option value="Pendiente">Pendiente</option>
            <option value="Aprobada">Aprobada</option>
            <option value="Rechazada">Rechazada</option>
        </select>
        <button type="submit" name="agregar">Agregar</button>
    </form>
    
    <?php
    if (isset($_POST['agregar'])) {
        $usuario_id = $_POST['usuario_id'];
        $fecha = $_POST['fecha'];
        $diferencia = $_POST['diferencia'];
        $estado = $_POST['estado'];

        $sql = "INSERT INTO conciliaciones (usuario_id, fecha, diferencia, estado) VALUES ('$usuario_id', '$fecha', '$diferencia', '$estado')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Conciliación agregada con éxito.</p>";
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
    
    <hr>
    
    <!-- Sección de Reportes -->
    <h2>Reportes</h2>
    <a href="reportes.php">📄 Generar y Ver Reportes</a>
</body>
</html>