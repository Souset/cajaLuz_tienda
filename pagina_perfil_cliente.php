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
        $id_cliente = $cliente[0]["id_cliente"];

        $sql = "SELECT *
                FROM ventas
                WHERE fn_id_cliente = '$id_cliente'";
        $ventas = Query($sql);

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
                        Perfil de <b><?php echo $cliente[0]["usuario_cliente"] ?></b>
                    </h1>
                    <!--
                    <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                    <li class="active">Here</li>
                    </ol>
                    -->
                </section>

                <?php
                    $fecha = new DateTime($cliente[0]["fechaNacimiento_cliente"]);
                    $fecha_nacimiento = $fecha->format("d-m-Y");
                ?>

                <!-- Contenido Principal -->
                <section id="perfil_cliente" class="content container-fluid" style="font-size:1.3em">

                    <div class="efecto_aparecer">
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

                                    <b>Teléfono</b>
                                    <p><?php echo $cliente[0]["telefono_cliente"] ?></p>

                                    <b>Fecha de nacimiento</b>
                                    <p><?php echo $fecha_nacimiento ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="thumbnail">
                            <div class="row">
                                <div class="col-sm-8">
                                    <b>Dirección</b>
                                    <p><?php echo $cliente[0]["direccion_cliente"] ?></p>
                                </div>
                                <div class="col-sm-4">
                                    <b>CP</b>
                                    <p><?php echo $cliente[0]["cp_cliente"] ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <b>Ciudad</b>
                                    <p><?php echo $cliente[0]["ciudad_cliente"] ?></p>
                                </div>
                                <div class="col-sm-4">
                                    <b>Provincia</b>
                                    <p><?php echo $cliente[0]["provincia_cliente"] ?></p>
                                </div>
                                <div class="col-sm-4">
                                    <b>País</b>
                                    <p><?php echo $cliente[0]["pais_cliente"] ?></p>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <b>Información complementaria</b>
                                <p><?php echo $cliente[0]["info_cliente"] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="cerrar_sesion.php" class="btn btn-default pull-left">Cerrar sesión</a>
                            </div>
                            <div class="col-xs-6">
                                <button type="button" class="btn btn-primary pull-right" onclick="modificar_datos_cliente()">Actualizar datos</button>
                            </div>
                        </div>
                    </div>

                </section>

                <section class="content container-fluid efecto_aparecer2" style="font-size:1.1em">
                    <h2>Facturas de compras anteriores</h2>
                        <div class="thumbnail">
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="tabla_facturas" class="table table-bordered table-striped">
                                    <thead style="background-color:#3C8DBC; color: whitesmoke">
                                        <tr>
                                            <th>Nº Factura</th>
                                            <th>Fecha</th>
                                            <th>Total Factura</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (is_array($ventas)) {
                                                for($i=count($ventas)-1; $i>=0; $i--) {
                                                    $fecha = new DateTime($ventas[$i]["fecha_venta"]);
                                                    $fecha_venta = $fecha->format("d-m-Y");
                                        ?>
                                            <tr>
                                                <td>
                                                    <a href="historico_facturas.php?id_cliente=<?php echo $id_cliente ?>&id_venta=<?php echo $ventas[$i]["id_venta"] ?>" target="_blank">
                                                        <?php echo $ventas[$i]["id_venta"]; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo $fecha_venta; ?>
                                                </td>
                                                <td>
                                                    <?php echo $ventas[$i]["total_venta"] + $ventas[$i]["gastos_envio"] . "€"; ?>
                                                </td>
                                            </tr>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </section>
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

        <!-- DataTables -->
        <script src="components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <!-- page script -->
        <script>
            $(function () {
                $('#tabla_facturas').DataTable({
                  'paging'      : true,
                  'lengthChange': true,
                  'searching'   : true,
                  'ordering'    : true,
                  'info'        : true,
                  'autoWidth'   : true
                })
            });

            $(document).ready(function() {
                var oTable = $('#tabla_facturas').dataTable();
                //  Ordena la columna 1 de forma descendiente
                //  (la última factura se muestra la primera)
                //  (las columnas están ordenadas del 0 al ...)
                oTable.fnSort( [ [1,'desc'] ] );
            });
        </script>
    </body>

</html>
