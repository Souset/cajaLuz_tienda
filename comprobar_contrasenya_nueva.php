<?php
sleep(1);

include("bd.php");

if (isset($_POST["id"], $_POST["contrasenya"], $_POST["contrasenya2"]) && $_POST["contrasenya"] != "" && $_POST["contrasenya2"] != "") {
    $id = $_POST["id"];
    $contrasenya = $_POST["contrasenya"];
    $contrasenya2 = $_POST["contrasenya2"];

    $correcto = true;

    //  EXPRESION REGULAR PARA COMPROBAR LAS CONTRASEÑAS
    $expR_contrasenya = "/^[A-Za-z0-9]{6,12}$/";

    //  COMPROBACIÓN DE LOS CAMPOS
    if (!preg_match($expR_contrasenya, $contrasenya) || $contrasenya != $contrasenya2) {
        $correcto = false;
    } else {

        //  COMPROBAR SI LA NUEVA CONTRASEÑA ES LA MISMA QUE TENÍA
        //  BUSCO LA CONTRASEÑA ANTIGUA EN LA TABLA CLIENTES
        $sql = "SELECT contrasenya_cliente
                FROM clientes
                WHERE id_cliente = '$id'";
        $contrasenya_encontrada = Query($sql);
        $contrasenya_encriptada = $contrasenya_encontrada[0]["contrasenya_cliente"];
        $contrasenya_encriptada = substr($contrasenya_encriptada, 0, -9);

        //  VERIFICO SI AL DESENCRIPTAR LA CONTRASEÑA ANTIGUA, COINCIDE CON LA NUEVA
        if (password_verify($contrasenya, $contrasenya_encriptada)) {
            $correcto = false;
            echo "Has introducido tu anterior contraseña. Introduce otra";
        }

        //  COMPROBAMOS CUANDO SOLICITÓ UNA NUEVA CONTRASEÑA
        $sql = "SELECT *
                FROM recuperar_contrasenya
                WHERE id_cliente = '$id'";
        $hay_contrasenya = Query($sql);

        //  CALCULAMOS CUANTOS DÍAS HAN PASADO
        $fecha_actual = new DateTime(date("Y-m-d"));
        $fecha_recuperacion = new DateTime($hay_contrasenya[0]["fecha"]);
        $intervalo = $fecha_recuperacion->diff($fecha_actual);
        $intervalo =  $intervalo->format('%a');

        //  SI HA PASADO MÁS DE UN DÍA, NO SE CAMBIA LA CONTRASEÑA
        if($intervalo > 1) {
            $correcto = false;
            echo 'Hace más de 24h que solicitaste el cambio de contraseña. Vuelve a hacer click en "Olvidé mi contraseña" y te enviaremos otro E-Mail';

            //  Y BORRAMOS ESE REGISTRO DE LA TABLA RECUPERAR CONTRASENYA
            $sql = "DELETE FROM recuperar_contrasenya WHERE id_cliente = '$id'";
            $respuesta = QueryAccion($sql);

            //  COMPRUEBO SI EXISTEN MAS REGISTROS EN LA TABLA RECUPERAR CONTRASENYA
            $sql = "SELECT *
                FROM recuperar_contrasenya";
            $total_registros = Query($sql);

            //  SI NO HAY NINGÚN REGISTRO MÁS, HAGO UN TRUNCATE DE LA TABLA RECUPERAR CONTRASENYA
            if (!is_array($total_registros)) {
                $sql = "TRUNCATE TABLE recuperar_contrasenya";
                $respuesta = QueryAccion($sql);
            }
        }

    }

    //  SI TODO ES CORRECTO...
    if ($correcto == true) {

        //  ENCRIPTAR LA NUEVA CONTRASEÑA
        $contrasenya_encriptada = password_hash($contrasenya, PASSWORD_BCRYPT) . "infop3r22";

        //  MODIFICACIÓN EN LA BASE DE DATOS
        $sql = "UPDATE clientes
                SET contrasenya_cliente = '$contrasenya_encriptada'
                WHERE id_cliente = '$id'";
        $respuesta = QueryAccion($sql);

        //  BORRAR EL REGISTRO ACTUAL DE LA TABLA RECUPERAR CONTRASENYA
        $sql = "DELETE FROM recuperar_contrasenya WHERE id_cliente = '$id'";
        $respuesta = QueryAccion($sql);

        //  COMPRUEBO SI EXISTEN MAS REGISTROS EN LA TABLA RECUPERAR CONTRASENYA
        $sql = "SELECT *
                FROM recuperar_contrasenya";
        $total_registros = Query($sql);

        //  SI NO HAY NINGÚN REGISTRO MÁS, HAGO UN TRUNCATE DE LA TABLA RECUPERAR CONTRASENYA
        if (!is_array($total_registros)) {
            $sql = "TRUNCATE TABLE recuperar_contrasenya";
            $respuesta = QueryAccion($sql);
        }

        echo "todo correcto";
    }
}

?>
