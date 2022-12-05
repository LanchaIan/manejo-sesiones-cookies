<style>

    body{
        background-color:<?=$color_fondo?>;
        font-family:<?=$tipo_letra?>;
    }
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

if (isset($_SESSION["Nombre"])){
    cambiar_style();
    echo "<h2>Sesion iniciada</h2>";  
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

function cambiar_style(){
    global $conProyecto;
    $nombre = $_SESSION['Nombre'];
    $resulta = $conProyecto->query(
    "SELECT usuarios_pagina.usuario,
            usuarios_pagina.colorfondo, 
            usuarios_pagina.tipoletra
    FROM 
            usuarios_pagina");

    $resultado_usuarios = $resulta->fetch(PDO::FETCH_OBJ);
        
    while ($resultado_usuarios != null){
        $usuario = $resultado_usuarios->usuario;
        if ($usuario == $nombre){
            echo "<h3>es el mismooo</h3>";
            $color_fondo = $resultado_usuarios->colorfondo;
            $tipo_letra = $resultado_usuarios->tipoletra;
            echo "<h3>es el mismooo</h3>";
        }
        $resultado_usuarios = $resulta->fetch(PDO::FETCH_OBJ);
    }

        
}

if (isset($_POST["borrar"])){
    echo "<h2>Borrada con éxito?</h2>"; 
    borrar();  
}
function borrar(){
    echo "<h2>pillado</h2>";  
    if (isset($_SESSION["Nombre"])){
        echo "<h2>Borrando</h2>";  
        session_destroy();
        echo "<h2>Borrada con éxito</h2>";  
    }
    if (!isset($_SESSION["Nombre"])){
        echo "No puedes borrar sesión si no la has iniciado";
    }
}


$conProyecto = null;
?>

<html>
    <body>
        <form method='post'>
            <input type='submit' id="borrar" name='borrar' value='borrar sesión'/>
        </form>
    </body>
</html>
