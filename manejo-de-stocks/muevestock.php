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
    $existente = false;
    while ($resultado != null) {
        
        $tienda_comprobar = $resultado->tienda;
        if ($tienda_elegida == $tienda_comprobar){
            echo "<h2> a actualizar </h2>";
            $existente = true;
            actualizar();
        }
        $resultado = $result->fetch(PDO::FETCH_OBJ);
    }
    if ($existente == false) {
        echo "<h2> a insertar </h2>";
        insertar();
    }

}

function insertar(){
    echo "<h4>estoy insertando</h4>";

}

function actualizar(){
    echo"<h4>estoy actualizando</h4>";
}

if (isset($_POST['tienda_elegida'])){
    $tienda_elegida = $_POST['tienda_elegida'];
}

if (isset($_POST['tienda_original'])){
    $tienda_original = $_POST['tienda_original'];
}

if (isset($_POST['Mover'])){
    mover();
}



if (isset($_POST['brb'])){
    calcular_quitados();
}
?>

<?php

    $result = $conProyecto->query(
        "SELECT stocks.producto, 
                stocks.tienda,
                stocks.unidades
        FROM 
                stocks
        WHERE
        stocks.producto = $id");
    
    
    $resultado = $result->fetch(PDO::FETCH_OBJ);

    function insertar__(){
        global $conProyecto;
        $producto = $_POST["producto"];
        $tienda = $_POST["tienda"];
        $unidades = $_POST["unidades"];
    
        $sql = $conProyecto->prepare("INSERT INTO stocks (producto,tienda,unidades)
        values
        (:producto,:tienda,:unidades)");
         $sql->bindParam(':producto',$producto);
         $sql->bindParam(':tienda',$tienda);
         $sql->bindParam(':unidades',$unidades);
         $sql->execute();
    
    }
    
    if (isset($_POST['insertar__'])){
        insertar__();
    }
    
    function actualizar__(){
        global $conProyecto;
        global $id;
        $Nombre = $_POST["Nombre"];
        $Nombre_corto = $_POST["Nombre_corto"];
        $Descripcion = $_POST["Descripcion"];
        $pvp = $_POST["pvp"];
        $familia = $_POST["familia"];

        $sql = $conProyecto->prepare("UPDATE productos
        SET
        nombre=:Nombre, nombre_corto=:Nombre_corto, descripcion=:Descripcion, pvp=:pvp, familia=:familia
        where
        id=$id");
        $sql->bindParam(':Nombre',$Nombre);
        $sql->bindParam(':Nombre_corto',$Nombre_corto);
        $sql->bindParam(':Descripcion',$Descripcion);
        $sql->bindParam(':pvp',$pvp);
        $sql->bindParam(':familia',$familia);
        $sql->execute();

    }

    if (isset($_POST['actualizar__'])){
        actualizar__();
    }
    

    

    
    if (isset($_POST['Si'])){
        mover();
    }
    
    $conProyecto = null;
?>

