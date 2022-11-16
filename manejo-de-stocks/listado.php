<style>
    table{
        border-style: solid;
    }

    td{
        border-style: solid;
        text-align: center;
    }

</style>

<?php

// PDO
$host = "localhost";
$db = "proyecto";
$user = "ian";
$pass = "1234";
$dsn = "mysql:host=$host;dbname=$db;";
// $dsn = "pgsql:host=$host;dbname=$db;";

try {
    $conProyecto = new PDO($dsn, $user, $pass);
    echo "<h1>Manejo del proyecto</h1>";
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

$result = $conProyecto->query(
"SELECT productos.id, 
        productos.nombre
 FROM 
        productos");


$resultado = $result->fetch(PDO::FETCH_OBJ);

echo"<form action='crear.php' method='post'>";
    echo"<input type='submit' name='crear' value='crear'/>";
echo"</form>";
echo "<table class='default'>";
        echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nombre</th>";
            echo "<th>Detalles</th>";
            echo "<th>Borrar</th>";
            echo "<th>Editar</th>";
            echo "<th>Mover stock</th>";
        echo "</tr>";

while ($resultado != null) {
        echo "<tr>";
            echo "<td>$resultado->id</td>";
            echo "<td>$resultado->nombre</td>";
            echo '<form action="detalle.php" method="post">';
                echo "<input type='hidden' name='id' value='$resultado->id'/>";
                echo "<td><input type='submit' name='boton' value='Detalles'/></td>";
            echo '</form>';
            echo '<form action="borrar.php" method="post">';
                echo "<input type='hidden' name='id' value='$resultado->id'/>";
                echo "<td><input type='submit' name='boton' value='Borrar'/></td>";
            echo '</form>';
            echo '<form action="update.php" method="post">';
                echo "<input type='hidden' name='id' value='$resultado->id'/>";
                echo "<td><input type='submit' name='boton' value='Editar'/></td>";
            echo '</form>';
            echo '<form action="muevestock.php" method="post">';
                echo "<input type='hidden' name='id' value='$resultado->id'/>";
                echo "<td><input type='submit' name='boton' value='Stock'/></td>";
            echo '</form>';
        echo "</tr>";
    echo "</table";

    $resultado = $result->fetch(PDO::FETCH_OBJ);
}

$conProyecto = null;
?>
