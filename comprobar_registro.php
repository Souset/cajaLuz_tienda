<?php
    sleep(1);

    include("bd.php");

    if (isset($_POST["nombre"], $_POST["usuario"], $_POST["nif"], $_POST["email"], $_POST["contrasenya"], $_POST["contrasenya2"]) && $_POST["nombre"] != "" && $_POST["usuario"] != "" && $_POST["nif"] != "" && $_POST["email"] != "" && $_POST["contrasenya"] != "" && $_POST["contrasenya2"] != "") {
        $nombre = $_POST["nombre"];
        $usuario = $_POST["usuario"];
        $nif = $_POST["nif"];
        $email = $_POST["email"];
        $contrasenya = $_POST["contrasenya"];
        $contrasenya2 = $_POST["contrasenya2"];

        $correcto = true;

        //  EXPRESIONES REGULARES PARA COMPROBAR LOS CAMPOS
        $expR_nombre = "/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{1,20}\s[A-Za-zA-Za-zÁÉÍÓÚáéíóúÑñ]{1,20}(\s[A-Za-zA-Za-zÁÉÍÓÚáéíóúÑñ]{1,20})?$/";
        $expR_usuario = "/^[A-Za-z0-9]{6,50}$/";
        $expR_nif = "/^[0-9]{8}[A-Za-z]{1}$/";
        $expR_email = "/^[A-Za-z0-9._-]{1,50}\@[A-Za-z0-9._-]{1,50}\.[a-z]{1,10}$/";
        $expR_contrasenya = "/^[A-Za-z0-9]{6,12}$/";

        //  COMPROBACIÓN DE TODOS LOS CAMPOS
        if (!preg_match($expR_nombre, $nombre) || !preg_match($expR_usuario, $usuario) || !preg_match($expR_nif, $nif) || !preg_match($expR_email, $email) || !preg_match($expR_contrasenya, $contrasenya) || $contrasenya != $contrasenya2) {
            $correcto = false;
        }

        //  BUSQUEDA DEL USUARIO EN LA BASE DE DATOS
        if ($correcto == true) {
            $sql = "SELECT *
                    FROM clientes
                    WHERE usuario_cliente = '$usuario'";
            $usuario_encontrado = Query($sql);

            $sql = "SELECT *
                    FROM clientes
                    WHERE email_cliente = '$email'";
            $email_encontrado = Query($sql);

            $sql = "SELECT *
                    FROM clientes
                    WHERE nif_cliente = '$nif'";
            $nif_encontrado = Query($sql);

            //  COMPROBAR SI EL USUARIO ESTÁ REGISTRADO
            if (is_array($email_encontrado)) {
                echo "Este E-Mail ya está registrado";
            } elseif (is_array($usuario_encontrado)) {
                echo "Usuario ya en uso, ingrese otro";
            } elseif (is_array($nif_encontrado)) {
                echo "Ese NIF pertenece a un usuario ya registrado";
            } else {
                //  ENCRIPTAR LA CONTRASEÑA
                $contrasenya_encriptada = password_hash($contrasenya, PASSWORD_BCRYPT) . "infop3r22";

                //  INSERCIÓN EN LA BASE DE DATOS
                $sql = "INSERT INTO clientes (nombre_cliente, usuario_cliente, nif_cliente, email_cliente, contrasenya_cliente)
                        VALUES ('$nombre','$usuario','$nif','$email','$contrasenya_encriptada')";
                $respuesta = QueryAccion($sql);

                echo "todo correcto";
            }
        }
    }
?>
