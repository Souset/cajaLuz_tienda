<!DOCTYPE html>
<!--
Esta es una página de plantilla inicial. Use esta página para comenzar su nuevo proyecto
rasguño. Esta página elimina todos los enlaces y proporciona solo el marcado necesario.
-->
<html lang="es">
    <?php include_once("head.php"); ?>

    <!--
BODY TAG OPTIONS:
=================
Aplicar una o más de las siguientes clases para obtener el
efecto deseado
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

    <body class="hold-transition skin-blue sidebar-mini">

        <?php
        include_once("header.php");

        include_once("barra_lateral_izq.php");
        include_once("barra_lateral_derecha.php");

        $cliente = $_SESSION["cliente"];
        ?>

        <div class="wrapper">

            <!-- Contenedor del contenido. Contiene el contenido de la página -->
            <div class="content-wrapper">
                <div class="alert2 alert-danger">
                    <i class="fas fas fa-exclamation-circle"></i>
                    <span id="mensaje"></span>
                </div>
                <!--  Contiene el encabezado y el contenido de la página. -->
                <section class="content-header efecto_aparecer3">
                    <h1>
                        Por favor <b><?php echo $cliente[0]["usuario_cliente"] ?></b>, comprueba que todos tus datos sean correctos
                    </h1>
                    <!--
                    <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                    <li class="active">Here</li>
                    </ol>
                    -->
                </section>

                <!-- Contenido Principal -->
                <section class="content container-fluid" style="font-size:1.3em">

                    <div class="efecto_aparecer">
                        <form action="javascript:comprobar_datos_cliente()" method="post">
                            <div class="thumbnail">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <center><img src="img/cliente.jpg"></center>
                                    </div>
                                    <div class="col-sm-7">
                                        <b>Nombre</b>
                                        <p><?php echo $cliente[0]["nombre_cliente"] ?></p>
                                        <b>E-Mail</b>
                                        <p><?php echo $cliente[0]["email_cliente"] ?></p>
                                        <div class="form-group has-feedback">
                                            <label class="control-label" for="telefono">Teléfono</label>
                                            <input id="telefono" name="telefono" type="text" class="form-control" value="<?php echo $cliente[0]["telefono_cliente"] ?>">
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label class="control-label" for="fechaNacimiento">Fecha de nacimiento</label>
                                            <input id="fechaNacimiento" name="fechaNacimiento" type="date" class="form-control" value="<?php echo $cliente[0]["fechaNacimiento_cliente"] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group has-feedback">
                                            <label class="control-label" for="telefono">Dirección</label>
                                            <input id="direccion" name="direccion" type="text" class="form-control" value="<?php echo $cliente[0]["direccion_cliente"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label" for="telefono">CP</label>
                                            <input id="cp" name="cp" type="text" class="form-control" value="<?php echo $cliente[0]["cp_cliente"] ?>">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group has-feedback">
                                            <label class="control-label" for="telefono">Ciudad</label>
                                            <input id="ciudad" name="ciudad" type="text" class="form-control" value="<?php echo $cliente[0]["ciudad_cliente"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label" for="telefono">Provincia</label>
                                            <input id="provincia" name="provincia" type="text" class="form-control" value="<?php echo $cliente[0]["provincia_cliente"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label" for="telefono">País</label>
                                            <input id="pais" name="pais" type="text" class="form-control" value="<?php echo $cliente[0]["pais_cliente"] ?>">
                                        </div>
                                    </div>
                                </div>
                                    <div class="form-group has-feedback">
                                        <label class="control-label" for="info">Información complementaria</label>
                                        <textarea id="info" name="info"><?php echo $cliente[0]["info_cliente"] ?></textarea>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <a href="pagina_carrito.php" class="btn btn-default pull-left">Volver</a>
                                </div>
                                <div class="col-xs-6">
                                    <span id="cargando">
                                        <button type="submit" class="btn btn-primary pull-right">Finalizar compra</button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                </section>
                <!-- Fin Paginación -->
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- INICIO FLECHAS QUE HACEN SCROLL SUAVE -->
            <div class="div_flecha_abajo">
                <i class="far fa-arrow-alt-circle-down"></i>
            </div>
            <div class="div_flecha_arriba">
                <i class="far fa-arrow-alt-circle-up"></i>
            </div>
            <!-- FIN FLECHAS QUE HACEN SCROLL SUAVE -->

            <?php include_once("footer.php")?>

        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 3 -->
        <script src="components/jquery/dist/jquery.min.js"></script>
        <!-- Popups -->
        <script src="components/toastr/toastr.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>

        <!-- NUESTROS SCRIPTS -->
        <script src="dist/js/general.js"></script>

        <!-- Opcionalmente, puede agregar complementos Slimscroll y FastClick.
        Se recomiendan estos dos complementos para mejorar el
        experiencia de usuario. -->
    </body>

</html>
