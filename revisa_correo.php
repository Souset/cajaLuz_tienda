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

                <h4 class="login-box-msg">Contraseña temporal enviada</h4>
                <br>
                <p>Te emos enviado un E-Mail para configurar una nueva contraseña. Revisa tu bandeja de entrada.</p>
                <br>
                <div class="row">
                    <center>
                        <span id="cargando">
                            <a href="index.php" class="btn btn-primary btn-flat">Volver</a>
                        </span>
                    </center>
                </div>
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
