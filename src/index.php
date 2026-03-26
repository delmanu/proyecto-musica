<?php
require 'conexion.php';

// LÓGICA DE BÚSQUEDA
$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($busqueda !== '') {
    $stmt = $pdo->prepare("SELECT * FROM registros 
                           WHERE nombre LIKE :query 
                           OR artista_favorito LIKE :query 
                           ORDER BY fecha DESC");
    $termino = "%$busqueda%";
    $stmt->execute(['query' => $termino]);
} else {
    $stmt = $pdo->query("SELECT * FROM registros ORDER BY fecha DESC");
}

$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gustos Musicales</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            line-height: 1.6;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin: 8px 0 16px;
            box-sizing: border-box;
        }

        button {
            background: #6200ea;
            color: white;
            padding: 10px 24px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
        }

        button:hover {
            background: #4500b5;
        }

        /* Estilos para el área de búsqueda */
        .busqueda-container {
            background: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 40px;
        }

        .btn-limpiar {
            display: inline-block;
            margin-left: 10px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #6200ea;
            color: white;
        }

        .no-results {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>

<body>
<h1>Registro de Gustos Musicales</h1>

<form action="registro.php" method="POST">
    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Género favorito:</label>
    <select name="genero_favorito" required>
        <option value="">-- Selecciona --</option>
        <option>Rock</option>
        <option>Pop</option>
        <option>Hip-Hop</option>
        <option>Electrónica</option>
        <option>Reggaeton</option>
        <option>Jazz</option>
        <option>Clásica</option>
        <option>Metal</option>
    </select>

    <label>Artista favorito:</label>
    <input type="text" name="artista_favorito" required>

    <label>Canción favorita:</label>
    <input type="text" name="cancion_favorita" required>

    <button type="submit">Guardar registro</button>
</form>

<div class="busqueda-container">
    <h3>Buscar un nombre o artista</h3>
    <form action="index.php" method="GET">
        <input type="text" name="q" placeholder="Nombre o artista..." value="<?= htmlspecialchars($busqueda) ?>">
        <button type="submit" style="background: #03dac6; color: #000;">Filtrar</button>

        <?php if ($busqueda !== ''): ?>
            <a href="index.php" class="btn-limpiar">✖ Limpiar búsqueda</a>
        <?php endif; ?>
    </form>
</div>

<h2>Registros guardados</h2>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Género</th>
        <th>Artista</th>
        <th>Canción</th>
        <th>Fecha</th>
    </tr>
    </thead>
    <tbody>
    <?php if (count($registros) > 0): ?>
        <?php foreach ($registros as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['nombre']) ?></td>
                <td><?= htmlspecialchars($r['genero_favorito']) ?></td>
                <td><?= htmlspecialchars($r['artista_favorito']) ?></td>
                <td><?= htmlspecialchars($r['cancion_favorita']) ?></td>
                <td><?= $r['fecha'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" class="no-results">No se encontraron coincidencias para "<strong><?= htmlspecialchars($busqueda) ?></strong>".</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>