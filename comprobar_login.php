<?php
    sleep(1);

    include("components/carrito/lib_carrito.php");
    include("bd.php");


    if (isset($_POST["usuario"], $_POST["contrasenya"]) && $_POST["usuario"] != "" && $_POST["contrasenya"] != "") {
        $usuario = $_POST["usuario"];
        $contrasenya = $_POST["contrasenya"];

        $sql = "SELECT *
                FROM clientes
                WHERE usuario_cliente = '$usuario' OR email_cliente = '$usuario'";
        $cliente_encontrado = Query($sql);

        if (is_array($cliente_encontrado)) {

            $sql = "SELECT contrasenya_cliente
                    FROM clientes
                    WHERE usuario_cliente = '$usuario' OR email_cliente = '$usuario'";
            $contrasenya_encontrada = Query($sql);
            $contrasenya_encriptada = $contrasenya_encontrada[0]["contrasenya_cliente"];
            $contrasenya_encriptada = substr($contrasenya_encriptada, 0, -9);

            if (password_verify($contrasenya, $contrasenya_encriptada)) {

                echo "todo correcto";

                //si no esta creada la variable de sesión, la creo
                if (!isset($_SESSION["cliente"])){
                    $_SESSION["cliente"] = $cliente_encontrado;
                }
            } else {
                echo "Contraseña incorrecta";
            }
        } else {
            echo "Usuario no registrado";
        }
    }
?>
