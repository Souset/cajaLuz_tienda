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

                <h4 class="login-box-msg">Inicia sesión para continuar</h4>

                <form action="javascript:comprobar_login()" method="post">
                    <div class="form-group has-feedback">
                        <input id="usuario" name="usuario" type="text" class="form-control" placeholder="Email o Usuario">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="contrasenya" name="contrasenya" type="password" class="form-control" placeholder="Contraseña">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-7">
                            <div class="checkbox icheck">
                                <label>
                                    <input class="chek_azul" type="checkbox"> Recuérdame
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-5">
                            <span id="cargando">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar Sesión</button>
                            </span>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center">
                    <p>- O -</p>
                        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Iniciar sesión usando Facebook</a>
                        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Iniciar sesión usando Google+</a>
                </div>
                <!-- /.social-auth-links -->

                <a href="olvido_contrasenya.php">Olvidé mi contraseña</a><br>
                <a href="registro.php" class="text-center">Crear una nueva Cuenta</a>

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
