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
session_start();
if (isset($_SESSION["Nombre"])){
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

if(isset($_POST['id'])){
    $id = $_POST['id'];
}

$result = $conProyecto->query(
"SELECT stocks.producto, 
        stocks.tienda,
        stocks.unidades
 FROM 
        stocks
    WHERE
    stocks.producto = $id");


$resultado = $result->fetch(PDO::FETCH_OBJ);

echo "<table class='default'>";
        echo "<tr>";
            echo "<th>Tienda</th>";
            echo "<th>Stock actual</th>";
            echo "<th>Nueva tienda</th>";
            echo "<th>Nº unidades</th>";
        echo "</tr>";

while ($resultado != null) {
    if ($resultado->unidades == 0){
        $sql = $conProyecto->prepare("Delete From stocks 
        Where stocks.tienda = $resultado->tienda
        AND producto = $id");
        $sql->execute();
    }
    else{
        $unidades_ = $resultado->unidades;
        $tienda = $resultado->tienda;
            echo "<tr>";
                echo "<td>$tienda</td>";
                echo "<td>$resultado->unidades</td>";
                echo '<form action="muevestock.php" method="post">';
                    echo '<td><select id="tienda_elegida" name="tienda_elegida">';
                        echo '<option value="1">CENTRAL</option>';
                        echo '<option value="2">SUCURSAL1</option>';
                        echo '<option value="3">SUCURSAL2</option>';
                    echo '</select></td>';
                    echo '<td><select id="unidades_movidas" name="unidades_movidas">';
                        while ($unidades_ != null) {
                            echo "<option value='$unidades_'>$unidades_</option>";
                            $unidades_ = $unidades_ - 1;
                        }
                    echo '</select></td>';
                    echo "<input type='hidden' name='tienda_original' value='$resultado->tienda'/>";
                    echo "<input type='hidden' name='id' value='$id'/>";
                    echo "<td><input type='submit' name='Mover' value='Mover'/></td>";
                echo '</form>';
            echo "</tr>";
        echo "</table";
    }
    

    $resultado = $result->fetch(PDO::FETCH_OBJ);
}

$result = $conProyecto->query(
    "SELECT stocks.producto, 
            stocks.tienda,
            stocks.unidades
     FROM 
            stocks
        WHERE
        stocks.producto = $id");

$resultado = $result->fetch(PDO::FETCH_OBJ);

function mover(){
    global $result;
    global $resultado;
    global $conProyecto;
    global $tienda_elegida;
    global $tienda_original;
    global $unidades_movidas;
    $existente = false;
    if ($tienda_elegida == $tienda_original){
        echo "NO SE PUEDE ENVIAR A LA MISMA TIENDA";
    }
    
    while ($resultado != null) {
        
        $tienda_comprobar = $resultado->tienda;
        if ($tienda_elegida == $tienda_comprobar){
            sumar();
            restar();
            $existente = true;
        }
        $resultado = $result->fetch(PDO::FETCH_OBJ);
    }
    if ($existente == false) {
        insertar();
        restar();
        echo "<h2> a insertar </h2>";
    }
    echo "<h2>Vuelva al listado para actualizar la información</h2>";

}

function insertar(){
    echo "<h4>estoy insertando</h4>";
    global $conProyecto;
    global $resultado;
    global $tienda_elegida;
    global $tienda_original;
    global $unidades_movidas;
    global $id;

    $result = $conProyecto->query(
        "SELECT stocks.producto, 
            stocks.tienda,
            stocks.unidades
        FROM 
            stocks
        WHERE
        stocks.tienda = $tienda_original
        AND producto = $id");
    
        $resultado = $result->fetch(PDO::FETCH_OBJ);
    
    $producto = $resultado->producto;
    $unidades = $unidades_movidas;

    $sql = $conProyecto->prepare("INSERT INTO stocks (producto,tienda,unidades)
    values
    (:producto,:tienda,:unidades)");
     $sql->bindParam(':producto',$producto);
     $sql->bindParam(':tienda',$tienda_elegida);
     $sql->bindParam(':unidades',$unidades);
     $sql->execute();
}

function sumar(){
    global $conProyecto;
    global $tienda_original;
    global $tienda_elegida;
    global $unidades_movidas;
    global $id;
    echo $id;
    $result = $conProyecto->query(
    "SELECT stocks.producto, 
        stocks.tienda,
        stocks.unidades
    FROM 
        stocks
    WHERE
    stocks.tienda = $tienda_elegida
    AND producto = $id");

    $resultado = $result->fetch(PDO::FETCH_OBJ);

    $producto = $resultado->producto;
    $unidades = $resultado->unidades;
    $unidades_finales = $unidades + $unidades_movidas;
    $sumar = $conProyecto->prepare("UPDATE stocks
        SET
        unidades=:unidades
        where
        tienda=$tienda_elegida
        AND producto = $producto");
        $sumar->bindParam(':unidades',$unidades_finales);
        $sumar->execute();
   
    echo "<p>relizado</p>";
}

function restar(){
    global $conProyecto;
    global $tienda_original;
    global $tienda_elegida;
    global $unidades_movidas;
    global $id;
    $result = $conProyecto->query(
    "SELECT stocks.producto, 
        stocks.tienda,
        stocks.unidades
    FROM 
        stocks
    WHERE
    stocks.tienda = $tienda_original
    AND producto = $id");

    $resultado = $result->fetch(PDO::FETCH_OBJ);

    $producto = $resultado->producto;
    $unidades = $resultado->unidades;
    $unidades_finales = $unidades - $unidades_movidas;

    $restar = $conProyecto->prepare("UPDATE stocks
        SET
        unidades=:unidades
        where
        tienda=$tienda_original
        AND producto = $producto");
        $restar->bindParam(':unidades',$unidades_finales);
        $restar->execute();
    
   
    echo "<p>relizado 2</p>";
}

if (isset($_POST['tienda_elegida'])){
    $tienda_elegida = $_POST['tienda_elegida'];
}

if (isset($_POST['tienda_original'])){
    $tienda_original = $_POST['tienda_original'];
}

if (isset($_POST['unidades_movidas'])){
    $unidades_movidas = $_POST['unidades_movidas'];
}

if (isset($_POST['brb'])){
    calcular_quitados();
}

?>

<html>
    <button onclick="mover()"> Borrar sesión </button>
<html>
