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

if(isset($_POST['id'])){
    $variable = $_POST['id'];
    echo "<a>$variable</a>";
}
?>