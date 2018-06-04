<?php
    include("lib_carrito.php");
    include("../../bd.php");
    $id = $_POST["id"];
    $cantidad = $_POST["cantidad"];
    if (isset($_POST["cambiando_cantidad"])) {
        //  CUANDO CAMBIO LA CANTIDAD EN LA pagina_carrito.php
        $_SESSION["ocarrito"]->modifica_producto($id, $cantidad);
    } else {
        //  CUANDO AÑADO PRODUCTO AL CARRITO EN LA pagina_producto.php
        $sql = "SELECT *
                FROM productos
                WHERE id = '$id'";
        $producto = Query($sql);
        $_SESSION["ocarrito"]->introduce_producto($id, $producto[0]["codigo"], $producto[0]["titulo"], $producto[0]["PVP"], $cantidad, $producto[0]["imagen"], $producto[0]["stock"]);
    }
    //  CAMBIA LA CANTIDAD DE PRODUCTOS QUE SE VE EN EL header.php
    echo $_SESSION["ocarrito"]->cantidad_productos();
?>
