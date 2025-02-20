<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Conciliación Bancaria</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Reportes de Conciliación Bancaria</h1>

    <!-- Generar Reporte -->
    <h2>Generar Reporte</h2>
    <form action="" method="POST">
        <select name="tipo_reporte">
            <option value="Conciliaciones">Conciliaciones</option>
            <option value="Aprobaciones">Aprobaciones</option>
            <option value="Auditorias">Auditorías</option>
        </select>
        <button type="submit" name="generar_reporte">Generar Reporte</button>
    </form>

    <?php
    if (isset($_POST['generar_reporte'])) {
        $tipo_reporte = $_POST['tipo_reporte'];

        echo "<h2>Reporte: $tipo_reporte</h2>";

        if ($tipo_reporte == "Conciliaciones") {
            $sql = "SELECT c.id, u.nombre, c.fecha, c.diferencia, c.estado 
                    FROM conciliaciones c 
                    JOIN usuarios u ON c.usuario_id = u.id";
        } elseif ($tipo_reporte == "Aprobaciones") {
            $sql = "SELECT a.id, u.nombre, a.estado, a.fecha_aprobacion 
                    FROM aprobaciones a 
                    JOIN usuarios u ON a.usuario_id = u.id";
        } elseif ($tipo_reporte == "Auditorias") {
            $sql = "SELECT aud.id, u.nombre, aud.resultado, aud.fecha 
                    FROM auditorias aud 
                    JOIN usuarios u ON aud.usuario_id = u.id";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <tr>";
            while ($field_info = $result->fetch_field()) {
                echo "<th>{$field_info->name}</th>";
            }
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No hay datos disponibles para este reporte.</p>";
        }
    }
    ?>
</body>
</html>
