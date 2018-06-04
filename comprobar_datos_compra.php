<?php
sleep(1);

include_once("components/carrito/lib_carrito.php");
include("bd.php");

if(isset($_POST["telefono"], $_POST["fechaNacimiento"], $_POST["direccion"], $_POST["cp"], $_POST["ciudad"], $_POST["provincia"], $_POST["pais"])) {
    $id = $_SESSION["cliente"][0]["id_cliente"];
    $telefono = $_POST["telefono"];
    $fechaNacimiento = $_POST["fechaNacimiento"];
    $direccion = $_POST["direccion"];
    $cp = $_POST["cp"];
    $ciudad = $_POST["ciudad"];
    $provincia = $_POST["provincia"];
    $pais = $_POST["pais"];
    $info = $_POST["info"];

    $correcto = true;

    //  EXPRESIONES REGULARES PARA COMPROBAR LOS CAMPOS
    $expR_telefono = "/^[0-9]{9}$/";
    $expR_direccion = "/^[\/0-9A-Za-zÁÉÍÓÚáéíóúÑñ,.º\s]{1,100}$/";
    $expR_cp = "/^[0-9]{5}$/";
    $expR_ciudad = "/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,15}$/";
    $expR_provincia = "/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,15}$/";
    $expR_pais = "/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,15}$/";

    //  COMPROBACIÓN DE TODOS LOS CAMPOS
    if (!preg_match($expR_telefono, $telefono) || !preg_match($expR_direccion, $direccion) || !preg_match($expR_cp, $cp) || !preg_match($expR_ciudad, $ciudad) || !preg_match($expR_provincia, $provincia) || !preg_match($expR_pais, $pais)) {
        $correcto = false;
    }

    //  ACTUALIZO CAMPOS EN LA BASE DE DATOS
    if ($correcto == true) {
        $sql = "UPDATE clientes
                SET telefono_cliente = '$telefono',
                    fechaNacimiento_cliente = '$fechaNacimiento',
                    direccion_cliente = '$direccion',
                    cp_cliente = '$cp',
                    ciudad_cliente = '$ciudad',
                    provincia_cliente = '$provincia',
                    pais_cliente = '$pais',
                    info_cliente = '$info'
                WHERE id_cliente = '$id'";
        $resultado = QueryAccion($sql);

        //  ACTUALIZO LA VARIABLE DE SESIÓN CON LOS DATOS ACTUALIZADOS
        $sql = "SELECT *
                FROM clientes
                WHERE id_cliente = '$id'";
        $cliente = Query($sql);
        $_SESSION["cliente"] = $cliente;

        //  VUELTA A AJAX
        echo "todo correcto";
    }
}


?>
