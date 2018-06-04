<?php
    session_start(); $cliente = $_SESSION["cliente"];

    $fecha = new DateTime($cliente[0]["fechaNacimiento_cliente"]);
    $fecha_nacimiento = $fecha->format("d-m-Y");
?>

<div>
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
