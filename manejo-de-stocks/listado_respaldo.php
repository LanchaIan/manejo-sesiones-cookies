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

function  registrar() {
    echo '<form method="post">';

    echo '</form>';

}

if(isset($_POST['registrar'])){
    registrar();
}

echo "<table class='default'>";
        echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nombre</th>";
            echo "<th>Editar</th>";
            echo "<th>Borrar</th>";
        echo "</tr>";

while ($resultado != null) {
        echo "<tr>";
            echo "<td>$resultado->id</td>";
            echo "<td>$resultado->nombre</td>";
            echo '<form method="post">';
                echo '<td><input type="submit" name="mostrar" value="mostrar"/></td>';
            echo '</form>';
        echo "</tr>";
    echo "</table";

    $resultado = $result->fetch(PDO::FETCH_OBJ);
}

$conProyecto = null;
?>
<html>
        <a href="crear.php"><input type="botton" value="Crear"/></a>
    </form>
</html>
