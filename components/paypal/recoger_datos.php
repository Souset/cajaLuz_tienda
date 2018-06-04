<?php
    include_once("../carrito/lib_carrito.php");
    if (isset($_SESSION["cliente"], $_SESSION["ocarrito"], $_SESSION["cliente"][0]["fechaNacimiento_cliente"], $_SESSION["cliente"][0]["direccion_cliente"], $_SESSION["cliente"][0]["ciudad_cliente"], $_SESSION["cliente"][0]["provincia_cliente"], $_SESSION["cliente"][0]["cp_cliente"], $_SESSION["cliente"][0]["pais_cliente"], $_SESSION["cliente"][0]["telefono_cliente"])) {
        $ob_ses = $_SESSION["ocarrito"];
?>

    <div style="position: absolute; top: 50%; left: 50%; margin-top: -73px; margin-left: -76px;">
        <div class="loading"><center><img src="../../img/cargando.gif"></center></div>
        <br>
        <div class="loading">Conectando con PayPal</div>
    </div>

    <form id="realizarPago" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
        <input name="cmd" type="hidden" value="_cart">
        <input name="upload" type="hidden" value="1">
        <input name="business" type="hidden" value="tehashechokk-facilitator@hotmail.com">
        <input name="shopping_url" type="hidden" value="tienda/index.php">
        <input name="currency_code" type="hidden" value="EUR">
        <input name="return" type="hidden" value="http://localhost/tienda/venta_realizada.php">
        <input name="notify_url" type="hidden" value="">
        <input name="rm" type="hidden" value="2">
        <input name="shipping_1" type="hidden" value="<?php echo $ob_ses->gastos_envio ?>">

        <?php
            for ($i=0;$i<$ob_ses->num_productos;$i++) {
                if ($ob_ses->array_id_prod[$i]!=0) {
        ?>
        <input name="item_number_<?php echo $i + 1 ?>" type="hidden" value="<?php echo $ob_ses->array_codigo_prod[$i] ?>">
        <input name="item_name_<?php echo $i + 1 ?>" type="hidden" value="<?php echo $ob_ses->array_nombre_prod[$i] ?>">
        <input name="amount_<?php echo $i + 1 ?>" type="hidden" value="<?php echo $ob_ses->array_precio_prod[$i] ?>">
        <input name="quantity_<?php echo $i + 1 ?>" type="hidden" value="<?php echo $ob_ses->array_cantidad_prod[$i] ?>">
        <?php
                }
            }
        ?>

    </form>

    <!-- jQuery 3 -->
    <script src="../jquery/dist/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#realizarPago").submit();
        });
    </script>

<?php
    }
?>
