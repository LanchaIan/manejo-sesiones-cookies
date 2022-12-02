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
    echo "<h1>Borrado con éxito</h1>";
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

if(isset($_POST['id'])){
    $id = $_POST['id'];
}

$sql = $conProyecto->prepare("Delete From productos Where id=$id");
$sql->execute();

?>
<html>
    <form action="listado.php" method="post">
        <input type='submit' name='boton' value='Volver'/>
    </form>
</html>