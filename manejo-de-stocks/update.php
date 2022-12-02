<style>
    table{
        border-style: solid;
    }

    td{
        border-style: solid;
        text-align: center;
    }

    .texto{
        padding: 150px;
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
    "SELECT productos.id, 
            productos.nombre,
            productos.nombre_corto,
            productos.descripcion,
            productos.pvp,
            productos.familia
     FROM 
            productos
    WHERE
            id = $id");
    
    
    $resultado = $result->fetch(PDO::FETCH_OBJ);

?>
<html>
    <form method="post">
        <label for="cod">Nombre:</label><br>
        <input type="text" id="Nombre" name="Nombre" value="<?php echo $resultado->nombre;?>"><br>
        <label for="Nombre">Nombre corto:</label><br>
        <input type="text" id="Nombre_corto" name="Nombre_corto" value="<?php echo $resultado->nombre_corto;?>"><br>
        <label for="cod">Descripción:</label><br>
        <textarea id="Descripcion" name="Descripcion"><?php echo $resultado->descripcion;?>
        </textarea><br>
        <label for="Nombre">pvp:</label><br>
        <input type="text" id="pvp" name="pvp" value="<?php echo $resultado->pvp;?>"><br>
        <label for="Nombre">pvp:</label><br>
        <select id="familia" name="familia">
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
        <input type='hidden' name='id' value="<?php echo $resultado->id;?>"/>
        <input type="submit" name="Enviar" value="Enviar"/>
    </form>
    <form action="listado.php" method="post">
        <input type='submit' name='boton' value='Volver'/>
    </form>
</html>
<?php
    function insertar(){
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

    if (isset($_POST['Enviar'])){
        insertar();
    }
    
    $conProyecto = null;
?>