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

    $ob_ses = $_SESSION["ocarrito"];
    ?>

    <div class="wrapper">

        <!-- Contenedor del contenido. Contiene el contenido de la página -->
        <div class="content-wrapper">
            <!--  Contiene el encabezado y el contenido de la página. -->
            <section class="content-header efecto_aparecer3">
                <h1>
                    <b id="cantidad_productos_2">(<?php echo $ob_ses->cantidad_total ?>)</b> Productos en <b>tu cesta</b>
                </h1>
                <!--
                <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
                </ol>
                -->
            </section>

            <!-- Contenido Principal -->
            <section class="content container-fluid">

                <div class="row">
                    <div class="col-md-8 efecto_aparecer">
                        <div class="thumbnail">
                            <div class="row hidden-sm hidden-xs cabecera_carrito">
                                <div class="col-md-7">Producto</div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-xs-3">Precio</div>
                                        <div class="col-xs-4">Cantidad</div>
                                        <div class="col-xs-3">Total</div>
                                        <div class="col-xs-2"></div>
                                    </div>
                                </div>
                            </div>

                            <?php
                                $suma = 0;
                                for ($i=0; $i<$ob_ses->num_productos; $i++) {
                                    if ($ob_ses->array_id_prod[$i]!=0) {
                            ?>

                            <span id="fila_<?php echo $i ?>">
                                <div class="row">
                                    <!--Imagen / <Producto-->
                                    <div class="col-md-7">
                                        <a href="pagina_producto.php?id=<?php echo $ob_ses->array_id_prod[$i] ?>">
                                            <div class="row">
                                                <div class="col-xs-2">

                                                    <img class="borde_imagen" src="<?php echo $ob_ses->array_imagen_prod[$i] ?>" width="50px">

                                                </div>
                                                <div class="col-xs-10">

                                                    <?php echo $ob_ses->array_nombre_prod[$i] ?>

                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <!--Precio / Cantidad / Total-->
                                    <div class="col-md-5">
                                        <div class="row" style>
                                            <div class="col-xs-3 hidden-sm hidden-xs precios_productos_carrito">

                                                <?php echo $ob_ses->array_precio_prod[$i] ?>€

                                            </div>
                                            <div class="col-xs-4 padding_izq_30">

                                                <?php include("controlar_cantidad_pagina_carrito.php") ?>

                                            </div>
                                            <div class="col-xs-3 precios_productos_carrito">

                                                <span id="precio_total_<?php echo $i ?>"><?php echo $ob_ses->array_precio_prod[$i] * $ob_ses->array_cantidad_prod[$i] ?>€</span>

                                            </div>
                                            <div class="col-xs-2 col-sm-2">

                                                <a href="#" onclick="borrar_producto_carrito(<?php echo $i ?>)"><i style="font-size: 1.3em;" class="fas fa-trash-alt"></i></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </span>

                            <?php
                                        $suma += $ob_ses->array_precio_prod[$i] * $ob_ses->array_cantidad_prod[$i];
                                    }
                                }
                            ?>

                        </div>
                        <div class="row">
                            <div class="col-xs-6"><button id="vaciar_carrito" onclick="vaciar_carrito(<?php echo $ob_ses->num_productos ?>)" type="button" class="btn btn-default pull-left">Vaciar carrito</button></div>
                            <div class="col-xs-6"><a href="index.php" type="button" class="btn btn-primary pull-right">Seguir comprando</a></div>
                        </div>
                    </div>
                    <div class="col-md-4 efecto_aparecer2">
                        <div class="thumbnail">
                            <h2>Resumen del pedido</h2>
                            <table class="table-striped table-condensed tabla_carrito">
                                <tr>
                                    <th>Subtotal</th>
                                    <td id="suma_total" class="texto_azul_negrita"><?php echo $suma ?>€</td>
                                </tr>
                                <tr>
                                    <th>Gastos de envío</th>
                                    <td id="gastos_envio" class="texto_azul"><?php if ($suma > 60) { echo 0; } else { echo 10; } ?>€</td>
                                </tr>
                                <tr>
                                    <th>TOTAL</th>
                                    <td id="total" class="texto_azul_negrita_grande"><?php if ($suma > 60) { echo $suma; } else { echo $suma + 10; } ?>€</td>
                                </tr>
                            </table>
                            <form action="<?php if (!isset($_SESSION["cliente"])) { echo "login.php"; } else { echo "rellenar_datos_cliente.php"; } ?>" method="post">
                                <button id="btn-pago" type="submit" class="btn btn-lg btn-block btn-primary">Realizar pedido</button>
                            </form>
                        </div>
                    </div>
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
