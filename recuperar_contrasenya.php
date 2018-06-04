<?php

    //  RECOGO DE LA URL (CON GET) EL ID DEL CLIENTE Y LA CONTRASEÑA TEMPORAL ENVIADA AL E-MAIL DEL CLIENTE
    if (isset($_GET["id_cliente"], $_GET["contrasenya_aleatoria"]) && $_GET["id_cliente"] != "" && $_GET["contrasenya_aleatoria"] != "") {
        $id_cliente = $_GET["id_cliente"];
        $contrasenya_aleatoria = $_GET["contrasenya_aleatoria"];

        include("bd.php");

        //  CONSULTO EN LA BASE DE DATOS SI EXISTE ESE CLIENTE Y ESA CONTRASEÑA ENCRIPTADA
        $sql = "SELECT *
                FROM recuperar_contrasenya
                WHERE id_cliente = '$id_cliente' AND contrasenya_aleatoria = '$contrasenya_aleatoria'";
        $cliente_y_contrasenya = Query($sql);

        //  SI EXISTE UN REGISTRO CON ESE ID Y ESA CONTRASEÑA ENCRIPTADA...
        if (is_array($cliente_y_contrasenya)) {

            $sql = "SELECT usuario_cliente
                    FROM clientes
                    WHERE id_cliente = '$id_cliente'";
            $cliente = Query($sql);

?>


<!DOCTYPE html>
<html lang="es">

    <?php include_once("head.php"); ?>

    <body class="hold-transition login-page">
        <div class="alert alert-danger">
            <i class="fas fas fa-exclamation-circle"></i>
            <span id="mensaje"></span>
        </div>
        <div class="login-box ">
            <!-- Logo -->
            <div class="login-logo efecto_aparecer">
                <a href="index.php" class="logo">
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><img src="img/logo.png" alt=""> caja<b>LUZ</b></span>
                </a>
            </div>

            <!-- /.login-logo -->
            <div class="login-box-body efecto_opacidad">

                <h4 class="login-box-msg"><strong><?php echo $cliente[0]["usuario_cliente"] ?></strong> ingresa tu nueva contraseña</h4>
                <br>

                <form action="javascript:comprobar_contrasenya_nueva()" method="post">
                    <input id="id" name="id" type="hidden" value="<?php echo $cliente_y_contrasenya[0]["id_cliente"] ?>">
                    <div class="form-group has-feedback">
                        <input id="contrasenya" name="contrasenya" type="password" class="form-control" placeholder="Nueva ontraseña">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="contrasenya2" name="contrasenya2" type="password" class="form-control" placeholder="Repetir contraseña">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                    <br>
                    <div class="row">
                        <center>
                            <span id="cargando">
                                <button type="submit" class="btn btn-primary btn-flat">Actualizar contraseña</button>
                            </span>
                        </center>
                    </div>
                </form>

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 3 -->
        <script src="components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js"></script>

        <!-- NUESTROS SCRIPTS -->
        <script src="dist/js/login_registro.js"></script>
    </body>
</html>


<?php

        }
    }

?>
