<!DOCTYPE html>
<html lang="es">

    <?php include_once("head.php") ?>

    <body class="hold-transition register-page">
        <div class="alert alert-danger">
            <i class="fas fas fa-exclamation-circle"></i>
            <span id="mensaje"></span>
        </div>
        <div class="register-box">
            <!-- Logo -->
            <div class="register-logo efecto_aparecer">
                <a href="index.php" class="logo">
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><img src="img/logo.png" alt=""> caja<b>LUZ</b></span>
                </a>
            </div>

            <div class="register-box-body efecto_opacidad">
                <h4 class="login-box-msg">Formulario de Registro</h4>

                <form action="javascript:comprobar_registro()" method="post">
                    <div class="form-group has-feedback">
                        <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre Completo">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="usuario" name="usuario" type="text" class="form-control" placeholder="Usuario">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="nif" name="nif" type="text" class="form-control" placeholder="NIF">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="email" name="email" type="email" class="form-control" placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="contrasenya" name="contrasenya" type="password" class="form-control" placeholder="Contraseña">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="contrasenya2" name="contrasenya2" type="password" class="form-control" placeholder="Repetir contraseña">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input class="chek_azul" type="checkbox"> Acepto <a href="#">términos y condiciones</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <span id="cargando">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Registrarse</button>
                            </span>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center">
                    <p>- O -</p>
                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Registrarse usando
                    Facebook</a>
                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Registrarse usando Google+</a>
                </div>

                <a href="login.php" class="text-center">Ya estoy registrado</a>
            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.register-box -->

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
