<?php include("components/carrito/lib_carrito.php"); ?>

<?php include("bd.php"); ?>

<header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="img/logo.png" alt=""></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="img/logo.png" alt=""> caja<b>LUZ</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" onclick="quitar_clases_barra_lateral_izq();">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <?php if (isset($_SESSION["cliente"])) { ?>
                    <!-- Messages: style can be found in dropdown.less

                    LOS CIERRES DE COMENTARIOS SE HAN ELIMINADO
                    SI QUIERES USAR ESTE TROZO DE CÓDIGO PON EL CIERRE DE COMENTARIO EN CADA LÍNEA DONDE VEAS <!--

                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the messages
                                <ul class="menu">
                                    <li>
                                        <!-- start message
                                        <a href="#">
                                            <div class="pull-left">
                                                <!-- User Image
                                                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                            </div>
                                            <!-- Message title and timestamp
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <!-- The message
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message
                                </ul>
                                <!-- /.menu
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
                    <!-- /.messages-menu

                    <!-- Notifications Menu
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- Inner Menu: contains the notifications
                                <ul class="menu">
                                    <li>
                                        <!-- start notification
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                    <!-- end notification
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <!-- Tasks Menu -->
                <li class="dropdown tasks-menu" style="<?php if ($_SERVER["REQUEST_URI"] == "/tienda/pagina_carrito.php" || $_SERVER["REQUEST_URI"] == "/tienda/rellenar_datos_cliente.php") { echo "display:none"; } ?>">

                    <!-- Llamada al modal del carrito -->
                    <a href="#" class="dropdown-toggle" data-toggle="modal" data-target="#carrito" onclick="cargar_numero_productos()">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="cantidad_productos" class="label label-danger"><?php $_SESSION["ocarrito"]->cantidad_productos(); ?></span>
                    </a>
                </li>
                <!-- INICIAR SESIÓN O REGISTRARSE -->
                <?php if (!isset($_SESSION["cliente"])) { ?>

                    <li class="user user-menu"><a href="login.php">Iniciar sesión</a></li>
                    <li class="user user-menu"><a href="registro.php">Regístrate</a></li>

                <?php } else { ?>

                    <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a id="nombre_usuario" href="#" class="dropdown-toggle">
                        <!-- The user image in the navbar-->
                        <img src="img/cliente.jpg" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?php echo $_SESSION["cliente"][0]["nombre_cliente"] ?></span>
                    </a>
                    <ul id="menu_usuario" class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="img/cliente.jpg" class="img-circle" alt="User Image">

                            <p>
                                Bienvenido <?php echo $_SESSION["cliente"][0]["nombre_cliente"] ?>
                                <small>Esperamos que todo sea de tu agrado</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="pagina_perfil_cliente.php" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="cerrar_sesion.php" class="btn btn-default btn-flat">Cerrar sesión</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <?php } ?>
        <!--
                <!-- User Account Menu
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar
                        <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears.
                        <span class="hidden-xs">Alexander Pierce</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu
                        <li class="user-header">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                            <p>
                                Alexander Pierce - Web Developer
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>
                            <!-- /.row
                        </li>
                        <!-- Menu Footer
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="#" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
        -->
            </ul>
        </div>
    </nav>
</header>
<!-- Fin header -->
<!-- Modal del carrito -->
<div class="modal fade" id="carrito">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Artículos en el carrito</h4>
            </div>
            <div class="modal-body">
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
                <span id="mostrar_productos"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <a id="ir_a_pagina_carrito" href="pagina_carrito.php" type="button" class="btn btn-primary pull-right">Pasar por caja</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
