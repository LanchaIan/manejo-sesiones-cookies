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
?>
<html>
    <form action="" method="post">
        <label for="cod">Nombre:</label><br>
        <input type="text" id="Nombre" name="Nombre" value="nombre"><br>
        <label for="Nombre">Nombre corto:</label><br>
        <input type="text" id="Nombre_corto" name="Nombre_corto" value="Nombre_corto"><br>
        <label for="cod">Descripción:</label><br>
        <input type="text" id="Descripcion" name="Descripcion" value="Descripcion"><br>
        <label for="Nombre">pvp:</label><br>
        <input type="text" id="pvp" name="pvp" value="pvp"><br>
        <label for="Nombre">familia:</label><br>
        <select multiple name="familia">
            <option value="CAMARA">Cámaras digitales</option>
            <option value="CONSOL">Consolas</option>
            <option value="EBOOK">Libros electrónicos</option>
            <option value="IMPRES">Impresoras</option>
            <option value="MEMFLA">Memorias flash</option>
            <option value="MP3">Consolas</option>
            <option value="MULTIF">Equipos multifunción</option>
            <option value="NETBOK">Netbooks</option>
            <option value="ORDENA">Ordenadores</option>
            <option value="PORTAT">Ordenadores portátiles</option>
            <option value="ROUTER">Routers</option>
            <option value="SAI">Sistemas de alimentación ininterrumpida</option>
            <option value="SOFTWA">Software</option>
            <option value="TV">Televisores</option>
            <option value="VIDEOC">Videocámaras</option>
        </select><br>
        <input type="submit" name="Enviar" value="Enviar"/>
    </form>
    <form action="listado.php" method="post">
        <input type='submit' name='boton' value='Volver'/>
    </form>
</html>
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
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

function insertar(){
    global $conProyecto;
    $Nombre = $_POST["Nombre"];
    $Nombre_corto = $_POST["Nombre_corto"];
    $Descripcion = $_POST["Descripcion"];
    $pvp = $_POST["pvp"];
    $familia = $_POST["familia"];

    $sql = $conProyecto->prepare("INSERT INTO productos (nombre,nombre_corto,descripcion,pvp,familia)
    values
    (:Nombre,:Nombre_corto,:Descripcion,:pvp,:familia)");
     $sql->bindParam(':Nombre',$Nombre);
     $sql->bindParam(':Nombre_corto',$Nombre_corto);
     $sql->bindParam(':Descripcion',$Descripcion);
     $sql->bindParam(':pvp',$pvp);
     $sql->bindParam(':familia',$familia);
     $sql->execute();

}

if (isset($_POST['Enviar'])){
    insertar();
}
?>

