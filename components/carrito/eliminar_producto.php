<?php
    include("lib_carrito.php");
    $_SESSION["ocarrito"]->elimina_producto($_POST["linea"]);
    echo $_SESSION["ocarrito"]->cantidad_productos();
?>
