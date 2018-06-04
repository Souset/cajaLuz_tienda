<?php
    include("components/carrito/lib_carrito.php");
    include("bd.php");
    $ob_ses = $_SESSION["ocarrito"];

    $ref_factura = date("YmdHis");
    $fecha = date("Y-m-d");
    $hora = date("H:i:s");
    $id_cliente = $_SESSION["cliente"][0]["id_cliente"];

    $sql = "INSERT INTO ventas (id_venta, fn_id_cliente, fecha_venta, hora_venta, total_venta, gastos_envio)
            VALUES ('$ref_factura','$id_cliente','$fecha','$hora','$ob_ses->suma_total','$ob_ses->gastos_envio')";
    $resultado = QueryAccion($sql);

    for ($i=0;$i<$ob_ses->num_productos;$i++) {
        if ($ob_ses->array_id_prod[$i]!=0) {
            $cantidad_vendida = $ob_ses->array_cantidad_prod[$i];
            $id_producto = $ob_ses->array_id_prod[$i];
            $titulo_producto = $ob_ses->array_nombre_prod[$i];
            $pvp_producto = $ob_ses->array_precio_prod[$i];
            $cantidad_producto = $ob_ses->array_cantidad_prod[$i];
            $sql = "UPDATE productos
                    SET stock = stock - '$cantidad_vendida'
                    WHERE id = '$id_producto'";
            $resultado = QueryAccion($sql);

            $sql = "INSERT INTO productos_vendidos (fn_id_venta, fn_id_producto, titulo_producto, PVP_producto, cantidad)
                    VALUES ('$ref_factura','$id_producto','$titulo_producto','$pvp_producto','$cantidad_producto')";
            $resultado = QueryAccion($sql);
        }
    }

    include("crear_factura.php");

    include("components/phpmailer/generar.php");

    unlink('facturas/' . $ref_factura . '.pdf');

    unset($_SESSION["ocarrito"]);
?>
<!DOCTYPE html>
<html lang="es">

    <?php include_once("head.php"); ?>

    <body class="hold-transition login-page">
        <div class="alert alert-danger">
            <i class="fas fas fa-exclamation-circle"></i>
            <span id="mensaje"></span>
        </div>
        <div class="login-box">
            <!-- Logo -->
            <div class="login-logo efecto_aparecer">
                <a href="index.php" class="logo">
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><img src="img/logo.png" alt=""> caja<b>LUZ</b></span>
                </a>
            </div>

            <!-- /.login-logo -->
            <div class="login-box-body efecto_opacidad">

                <h2 class="login-box-msg"><b>Compra realizada con éxito</b></h2>

                <center>
                    <p><i class="far fa-thumbs-up" style="font-size: 5em; color: green;"></i></p>
                    <br>
                    <h4>Gracias, vuelve pronto</h4>
                    <br>
                </center>

                <a href="index.php" type="button" class="btn btn-lg btn-block btn-primary">Volver a la tienda</a>

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
