<?php
spl_autoload_register(function($clase) {
    require "$clase.php";
});
session_start();
$datos = $_SESSION['campos'];
$tabla = $_SESSION['tabla'];

if (isset($_POST['gestionar'])) {
    foreach ($datos as $campo => $v) {
        $valoresNuevos[$campo] = $_POST[$campo];
    }
    $bd = new BBDD();
    $bd->edit($valoresNuevos, $datos);
    header("Location:index.php");
    exit();
}

function showValuesEditar($valores) {
    echo "<form action='editar.php' method='POST'>";
    foreach ($valores as $campo => $valor) {
        echo "<label>$campo</label>";
        echo "<input type='text' name='$campo' value='$valor'></br>";
        //echo"<input type='hidden' name='datosNuevos[$campo]' value='$valor'>";
    }
    echo"<input type='submit' name='gestionar' value='editar'>";
    echo"</form>";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BBDD</title>
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>
    </head>
    <body>
        <?php showValuesEditar($datos) ?>
    </body>
</html>
