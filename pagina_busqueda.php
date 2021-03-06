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


        if(isset($_GET["buscar"])){
            $termino_buscar = $_GET["buscar"];

            /*$sql = "SELECT * FROM productos WHERE titulo LIKE '%termino_buscar%'";
            $productos = Query($sql);*/

            $sql = "SELECT id
                    FROM productos
                    WHERE titulo LIKE '%$termino_buscar%' OR subtitulo LIKE '%$termino_buscar%' OR codigo LIKE '$termino_buscar'";
            $productos = Query($sql);

            if (is_array($productos)) {
                $total_productos = count($productos);
                $productos_pagina = 16;

                if(isset($_GET["pagina"])){
                    $pagina=$_GET["pagina"];
                    $inicio = ($pagina - 1) * $productos_pagina;
                } else {
                    $inicio = 0;
                    $pagina = 1;
                }

                $sql = "SELECT id, titulo, imagen, PVP
                        FROM productos
                        WHERE titulo LIKE '%$termino_buscar%' OR subtitulo LIKE '%$termino_buscar%' OR codigo LIKE '$termino_buscar'
                        LIMIT $inicio, $productos_pagina";
                $productos = Query($sql);

                $total_paginas = ceil($total_productos / $productos_pagina);
            }

        }


        include_once("barra_lateral_izq.php");
        include_once("barra_lateral_derecha.php");
    ?>

    <div class="wrapper">

        <!-- Contenedor del contenido. Contiene el contenido de la página -->
        <div class="content-wrapper">
            <!--  Contiene el encabezado y el contenido de la página. -->
            <section class="content-header efecto_aparecer3">
                <h1>
                    <b>RESULTADOS</b> DE LA BÚSQUEDA
                    <small><?php echo date("d-m-Y"); ?></small>
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

                <div class="row efecto_aparecer">
                    <?php if (is_array($productos)) { ?>
                        <?php $contador=0; ?>
                        <?php for($i=0; $i<count($productos); $i++) { ?>
                            <?php $contador++; ?>
                            <div class="col-xs-6 col-md-3">
                                <div class="mas_detalles">
                                    <a href="pagina_producto.php?id=<?php echo $productos[$i]["id"] ?>">
                                        <div class="thumbnail">
                                            <img src="<?php echo $productos[$i]["imagen"] ?>">
                                            <div class="caption">
                                                <?php
                                                    if (strpos($productos[$i]["titulo"], ", regulable")) {
                                                        $titulo_tonalidad = substr($productos[$i]["titulo"], 0, strpos($productos[$i]["titulo"], ", regulable"));
                                                    } else {
                                                        $titulo_tonalidad = $productos[$i]["titulo"];
                                                    }
                                                    if (strpos($titulo_tonalidad, ", Blanco ")) {
                                                        $titulo = substr($titulo_tonalidad, 0, strpos($titulo_tonalidad, ", Blanco "));
                                                        $tonalidad = substr($titulo_tonalidad, strpos($titulo_tonalidad, ", Blanco "));
                                                    } elseif (strpos($titulo_tonalidad, " + Blanco ")) {
                                                        $titulo = substr($titulo_tonalidad, 0, strpos($titulo_tonalidad, " + Blanco "));
                                                        $tonalidad = substr($titulo_tonalidad, strpos($titulo_tonalidad, " + Blanco "));
                                                    } else {
                                                        $titulo = $titulo_tonalidad;
                                                        $tonalidad = "";
                                                    }
                                                    switch ($tonalidad) {
                                                        case " + Blanco neutro":
                                                            $tonalidad = ", Blanco neutro";
                                                            break;
                                                        case " + Blanco frío":
                                                            $tonalidad = ", Blanco frío";
                                                            break;
                                                        case " + Blanco cálido":
                                                            $tonalidad = ", Blanco cálido";
                                                            break;
                                                    }
                                                ?>
                                                <h5 class="targeta_titulo"><?php echo $titulo ?><small><?php echo $tonalidad ?></small></h5>
                                                <p class="targeta_precio"><b><?php echo $productos[$i]["PVP"] ?> €</b></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php if ($contador == 4) { echo "<div style='clear:both'></div>"; $contador = 0; } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="container">
                            <div class="alert alert-warning col-sm-9 centrado" role="alert">
                                <h2><i class="fas fa-exclamation-triangle"></i>  No se han encontrado resultados</h2>
                            </div>
                        </div>
                    <?php } ?>
               </div>

                <div class="col-xs-12 centrado <?php if ($total_productos <= $productos_pagina) { echo "ocultar"; } else { echo "efecto_aparecer3"; } ?>">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="<?php if ($pagina == 1) { echo "disabled"; } ?>">
                                <a href="<?php if ($pagina > 1) { echo "pagina_busqueda.php?buscar=$termino_buscar&pagina=" . ($pagina - 1); } else { echo "#"; } ?>" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php if ($total_paginas < 10) { ?>
                                <?php for ($j=1; $j<=$total_paginas; $j++) { ?>
                                    <li class="<?php if ($pagina == $j) { echo "active"; } ?>">
                                        <a href="<?php if ($pagina != $j) { echo "pagina_busqueda.php?buscar=$termino_buscar&pagina=" . $j; } else { echo "#"; } ?>">
                                            <?php echo $j?>
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } elseif ($total_paginas - $pagina < 10) { ?>
                                <?php for ($j=$total_paginas-9; $j<=$total_paginas; $j++) { ?>
                                    <li class="<?php if ($pagina == $j) { echo "active"; } ?>">
                                        <a href="<?php if ($pagina != $j) { echo "pagina_busqueda.php?buscar=$termino_buscar&pagina=" . $j; } else { echo "#"; } ?>">
                                            <?php echo $j?>
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } else { ?>
                                <?php for ($j=$pagina; $j<$pagina+10; $j++) { ?>
                                    <?php if ($j <= $total_paginas) { ?>
                                        <li class="<?php if ($pagina == $j) { echo "active"; } ?>">
                                            <a href="<?php if ($pagina != $j) { echo "pagina_busqueda.php?buscar=$termino_buscar&pagina=" . $j; } else { echo "#"; } ?>">
                                                <?php echo $j?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <li class="<?php if ($pagina == $total_paginas) { echo "disabled"; } ?>">
                                <a href="<?php if ($pagina < $total_paginas) { echo "pagina_busqueda.php?buscar=$termino_buscar&pagina=" . ($pagina + 1); } else { echo "#"; } ?>" aria-label="Siguiente">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                        <div>
                            <form action="javascript:busqueda_ir_a_pagina(<?php echo $total_paginas . ", '" . $termino_buscar . "'" ?>)">
                                <label for="pagina">Pagina </label>
                                <input id="pagina" name="pagina" value="<?php echo $pagina ?>" type="text" autocomplete="off">
                                <label>de <?php echo $total_paginas ?></label>
                                <button id="pagina_boton" type="button" onclick="busqueda_ir_a_pagina(<?php echo $total_paginas . ", '" . $termino_buscar . "'" ?>)">Ir</button>
                            </form>
                        </div>
                    </nav>
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
</body>

</html>
