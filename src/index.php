<?php require 'conexion.php'; ?>
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
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
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

  <h2>Registros guardados</h2>
  <?php
  $stmt = $pdo->query("SELECT * FROM registros ORDER BY fecha DESC");
  $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <table>
    <tr>
      <th>#</th>
      <th>Nombre</th>
      <th>Género</th>
      <th>Artista</th>
      <th>Canción</th>
      <th>Fecha</th>
      <th>Acción</th>
    </tr>
    <?php foreach ($registros as $r): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['nombre']) ?></td>
        <td><?= htmlspecialchars($r['genero_favorito']) ?></td>
        <td><?= htmlspecialchars($r['artista_favorito']) ?></td>
        <td><?= htmlspecialchars($r['cancion_favorita']) ?></td>
        <td><?= $r['fecha'] ?></td>
        <td>
            <a href="editar.php?id=<?= $r['id'] ?>" style="color: #6200ea; text-decoration: none; font-weight: bold;">Editar</a>
        </td>
	<td><a href="eliminar.php?id=<?= $r['id'] ?>" onclick="return confirm('¿Eliminar registro?')" style="color:red;">Eliminar</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>

</html>
