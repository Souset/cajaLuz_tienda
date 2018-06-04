<?php
sleep(1);

include("bd.php");

if (isset($_POST["usuario"]) && $_POST["usuario"] != "") {
    $usuario = $_POST["usuario"];

    //  BUSCAMOS USUARIO O E-MAIL EN LA BASE DE DATOS
    $sql = "SELECT *
            FROM clientes
            WHERE usuario_cliente = '$usuario' OR email_cliente = '$usuario'";
    $cliente_encontrado = Query($sql);

    //  SI EL USUARIO O E-MAIL EXISTE...
    if (is_array($cliente_encontrado)) {

        $id_cliente = $cliente_encontrado[0]["id_cliente"];

        //  BUSCAMOS EN LA BASE DE DATOS SI YA HAY UNA CONTRASEÑA TEMPORAL PARA ESTE USUARIO
        $sql = "SELECT *
                FROM recuperar_contrasenya
                WHERE id_cliente = '$id_cliente'";
        $hay_contrasenya = Query($sql);

        //  COMPROBAMOS SI HAY UNA CONTRASEÑA TEMPORAL
        if (is_array($hay_contrasenya)) {

            //  CALCULAMOS CUANTOS DÍAS HAN PASADO DESDE QUE EL USUARIO SOLICITÓ UNA NUEVA CONTRASEÑA
            $fecha_actual = new DateTime(date("Y-m-d"));
            $fecha_recuperacion = new DateTime($hay_contrasenya[0]["fecha"]);
            $intervalo = $fecha_recuperacion->diff($fecha_actual);
            $intervalo =  $intervalo->format('%a');

            //  SI HA PASADO MÁS DE UN DÍA, NO SE CAMBIA LA CONTRASEÑA
            if ($intervalo > 1) {
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

            //  SI HA PASADO MENOS DE UN DÍA DESDE QUE SOLICITÓ UNA NUEVA CONTRASEÑA NO LE MANDAMOS OTRA
            } elseif ($intervalo <= 1) {
                echo "Ya has solicitado un cambio de contraseña, revisa tu E-Mail";
            }
        } else {

            //  CREAMOS LA CONTRASEÑA TEMPORAL DE FORMA ALEATORIA Y ENCRIPTADA
            //$contrasenya_aleatoria = md5(microtime() . $usuario) . "infop3r22";

            //  posibles caracteres a usar
            $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";

            //  numero de letras para generar el texto
            $numero_caracteres=12;

            //  variable para almacenar la cadena generada
            $contrasenya_aleatoria = "";
            for($i=0;$i<$numero_caracteres;$i++)
            {
                //  Extraemos 1 caracter de los caracteres entre el rango 0 a Numero de letras que tiene la cadena
                $contrasenya_aleatoria .= substr($caracteres,rand(0,strlen($caracteres)),1);
            }
            $contrasenya_aleatoria = password_hash($contrasenya_aleatoria, PASSWORD_BCRYPT) . "infop3r22";
            $fecha_actual = date("Y-m-d");

            //  INSERCIÓN EN LA TABLA
            $sql = "INSERT INTO recuperar_contrasenya (contrasenya_aleatoria, fecha, id_cliente)
                    VALUES ('$contrasenya_aleatoria', '$fecha_actual', '$id_cliente')";
            $insercion = QueryAccion($sql);


            //  MANDAMOS EL E-MAIL AL CLIENTE CON LAS INSTRUCCIONES PARA LA RECUPERACIÓN DE CONTRASEÑA
            //  YA FUNCIONA (LLEGAN LOS MAILS)
            //  PERO PARA QUE FUNCION EN LOCALHOST HAY QUE SEGUIR LOS PASOS QUE INDICA ESTE VIDEO
            //  https://www.youtube.com/watch?v=b1pSWq9NFlc
            //  Y ACTIVAR EL ACCESO PARA LAS APLICACIONES MENOS SEGURAS EN GMAIL
            //  https://support.google.com/accounts/answer/6010255
            //  https://myaccount.google.com/lesssecureapps

            $url_recuperacion_contrasenya = "http://localhost/tienda/recuperar_contrasenya.php?id_cliente=$id_cliente&contrasenya_aleatoria=$contrasenya_aleatoria";

            $para = $cliente_encontrado[0]["email_cliente"];
            $asunto = 'Recuperación contraseña';
            $mensaje =  "
                <html>
                <head>
                    <style type='text/css'>
                        @font-face {
                            font-family: 'Open Sans';
                            font-style: normal;
                            font-weight: 400;
                            src: local('Open Sans'), local('OpenSans'), url(http://themes.googleusercontent.com/static/fonts/opensans/v6/cJZKeOuBrn4kERxqtaUH3T8E0i7KZn-EPnyo3HZu7kw.woff) format('woff');
                        }
                        body {
                            color: #333;
                            font-family: 'Open Sans', sans-serif;
                            margin: 0px;
                            font-size: 16px;
                        }
                        .pie {
                            font-size:12px;
                            color:#999797;
                        }
                        .centro {
                            font-size:16px;
                        }
                        .centro a{
                            text-decoration:none;
                            color: #0487b8;
                        }
                        .centro a:hover{
                            text-decoration: underline;
                            color: #0487b8;
                        }
                    </style>
                </head>
                <body>
                    <img src='https://lh3.googleusercontent.com/LwgSzB90l_eOi0BVkKn91kef8gJyOPfmFEieTUQPDU5wljuhiaH04GYoQwcA8UNtXSbZO3ge8NcXsh0gs8pr9zVFwIHzUhiSWOccixP7u4woAvfWAnC59wfADkT4OL_6Jp4z_l8ku6yQ0kDF_XmcOsD9SpNhmPCvgfo-Vp_G653min0ATwSTz6-R9WPLWF4kjTcPeXH1IqpU36PD0CW5c335rA7VBYW1TcI8p0V237l1hXqf4EObaMx8MtvySFObybAIHs9zD3aNra3L7-RhyWYoK_hD6ytUHklcY8qWjp1UHDX8ywUrj5dsD-yhrg1x7y5ts3DuAfr33eVcjnV_kHz-oPf6WpIV4I86lt4Wk1-wXlm0MgfdFdq6zZyIDP4kIXJG1kM-CHkayHVASmZ_8MC4UEEDEsi1rKT9XuPdvjkrFJMWPh6E0LCioCEOxP6unDXYXDD0sLpVjouuYWLiOMq_uAtecw5kldVO4hsZEqEUO6m3ZFkJL7VJCTjmuxVlGW-42entjIFFHGxkUO-fekaURIIolvVPxHXoBNF_YtH59s1cR229raTbscbYwRZrok-nv-RyK32o7BOhmBHyk3oM5yK07G3fZPYJhnbN=w800-h142-no' width='100%'>

                    <table width='593' height='324' border='0' align='center'>
                        <tr>
                            <td height='97' valign='top' class='centro'>
                                <h3>Recuperación contraseña</h3>
                                Para recuperar tu contraseña haz <a href='" . $url_recuperacion_contrasenya . "'>click aquí</a>
                            </td>
                        </tr>
                        <tr>
                            <td height='17'></td>
                        </tr>
                        <tr>
                            <td height='27' class='pie'>Este email es una notificaci&oacute;n autom&aacute;tica</td>
                        </tr>
                    </table>
                </body>
                </html>
            ";

            // Cabecera que especifica que es un HMTL
            $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
            $cabeceras .= "Content-type: text/html\r\n";
            $cabeceras .= 'From: cajaLuz' . "\r\n" . //poner el domn
                'Reply-To: no_contestar@cajaluz.com' . "\r\n";

            mail($para, $asunto, $mensaje, $cabeceras);


            echo '<script type="text/javascript">window.location="revisa_correo.php";</script>';

            echo "todo correcto";
        }
    } else {
        echo "Usuario no registrado";
    }
}

?>






