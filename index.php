<?php
spl_autoload_register(function($clase) {
    require "$clase.php";
});
session_start();
if (isset($_POST["submit"])) {
    $name = $_POST["list"];
    $_SESSION['tabla'] = $_POST["list"];

    $bd = new BBDD();
    if ($bd->checkState()) {
        $productos = $bd->selectQuery("select * from producto where familia='$name'");
    }
    $bd->cerrarConexion();
}

if (isset($_POST['editar'])) {

    $_SESSION['campos'] = $_POST['datos'];
    header("Location:editar.php");
    exit();
}

function showFamily() {
    $bd = new BBDD();
    if ($bd->checkState()) {
        $result = $bd->selectQuery("select cod from familia");
        foreach ($result as $res) {
            foreach ($res as $r) {
                echo "<option value='$r'>$r</option>";
            }
        }
    } else {
        echo "hola";
    }
    $bd->cerrarConexion();
}

function showProductos($productos) {
    foreach ($productos as $producto) {
        echo "<tr>";
        foreach ($producto as $pr) {
            echo"<td>$pr</td>";
        }
        echo "</tr>";
    }
}

function showTabla($productos) {

    echo "<table>";
    echo "<tr>";
    $bd = new BBDD();
    $campos = $bd->nombresCampos("producto");
    foreach ($campos as $campo) {
        echo"<th>$campo</th>";
    }
    echo "</tr>";
    foreach ($productos as $producto) {
        echo "<tr><form action='index.php' method='POST'>";
        $i = 0;
        foreach ($producto as $pr) {
            echo"<td>$pr";
            echo "<input type='hidden' name='datos[" . $campos[$i] . "]' value='$pr'</td>";
            $i++;
        }
        echo "<td><input type='submit' name='editar' value='editar'</td></form>";
        echo "</tr>";
    }
    echo "</table>";
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
        <form action="index.php" method="POST">
            <select name="list" id = "list">
                <?php showFamily() ?>
            </select>

            <input type="submit" name="submit" value="show">
        </form>
        <?php
        if (isset($_POST['submit']))
            showTabla($productos)
            ?>         

    </body>
</html>
