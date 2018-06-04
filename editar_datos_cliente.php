<?php session_start(); $cliente = $_SESSION["cliente"]; ?>

<div>
    <form action="javascript:comprobar_datos_perfil_cliente()" method="post">
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
                <button type="button" class="btn btn-default pull-left" onclick="recargar_datos_cliente()">Cancelar</button>
            </div>
            <div class="col-xs-6">
                <span id="cargando">
                    <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                </span>
            </div>
        </div>
    </form>
</div>
