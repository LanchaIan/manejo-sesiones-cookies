<style>
    table{
        border-style: solid;
    }

    td{
        border-style: solid;
        text-align: center;
    }

    tr{
        background-color: white;
    }
    

</style>

<?php
session_start();

if (isset($_SESSION["Nombre"])){
    cambiar_style();
    echo "<h2>Sesion iniciada</h2>";  
}
if (!isset($_SESSION["Nombre"])){
    header("Location: login.php");
    echo "<h3>Sesión no iniciada</h3>";
}

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

echo"<form method='post'>";
    echo"<input type='submit' name='borrar' value='borrar sesión'/>";
echo"</form>";

function cambiar_style(){
    global $conProyecto;
    $nombre = $_SESSION['Nombre'];
    $result = $conProyecto->query(
        "SELECT usuarios_pagina.colorfondo, 
                usuarios_pagina.tipoletra
         FROM 
                usuarios_pagina
        where 
        usu");
        
        
        $resultado = $result->fetch(PDO::FETCH_OBJ);

    echo "<body style=background-color:'$resultado->colorfondo'/>";
    echo "<body style=font-family:'$resultado->tipoletra'/>";
        
}

if (isset($_POST["borrar"])){
    echo "<h2>Borrada con éxito?</h2>"; 
    borrar();  
}
function borrar(){
    if (isset($_SESSION["Nombre"])){
        session_destroy();
        echo "<h2>Borrada con éxito</h2>";  
    }
    if (!isset($_SESSION["Nombre"])){
        echo "No puedes borrar sesión si no la has iniciado";
    }
}

$conProyecto = null;
?>

