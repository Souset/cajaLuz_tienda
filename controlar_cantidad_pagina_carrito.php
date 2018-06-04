<div class="row sin_padding">
    <div class="col-xs-3">
        <button type="button" class="btn btn-default btn-block" onclick="restar1_carrito(<?php echo $i . ", " . $ob_ses->array_precio_prod[$i] . ", " . $ob_ses->array_stock_prod[$i] . ", " . $ob_ses->array_id_prod[$i] . ", " . $ob_ses->num_productos ?>)">-</button>
    </div>
    <div class="col-xs-6">
        <input id="cantidad_<?php echo $i ?>" class="form-control" type="text" value="<?php echo $ob_ses->array_cantidad_prod[$i] ?>" min="<?php if ($ob_ses->array_stock_prod[$i] == 0) { echo "0"; } else { echo "1"; } ?>" max="<?php echo $ob_ses->array_stock_prod[$i]; ?>" onkeyup="calcular_carrito(<?php echo $i . ", " . $ob_ses->array_precio_prod[$i] . ", " . $ob_ses->array_stock_prod[$i] . ", " . $ob_ses->array_id_prod[$i] . ", " . $ob_ses->num_productos ?>)" onblur="pierde_foco(<?php echo $i ?>); calcular_carrito(<?php echo $i . ", " . $ob_ses->array_precio_prod[$i] . ", " . $ob_ses->array_stock_prod[$i] . ", " . $ob_ses->array_id_prod[$i] . ", " . $ob_ses->num_productos ?>)">
    </div>
    <div class="col-xs-3">
        <button type="button" class="btn btn-default btn-block" onclick="sumar1_carrito(<?php echo $i . ", " . $ob_ses->array_precio_prod[$i] . ", " . $ob_ses->array_stock_prod[$i] . ", " . $ob_ses->array_id_prod[$i] . ", " . $ob_ses->num_productos ?>)">+</button>
    </div>
</div>
