//  AL CARGAR EL DOCUMENTO
    $(document).ready(function() {
        $(".efecto_aparecer").show(500, "swing", function(){
            $(".efecto_opacidad").fadeTo(500,1);
        });
        /*$(".efecto_opacidad").animate({opacity:"1"}, 1000, "linear", function(){
            $(".efecto_aparecer").show(500, "swing");
        });*/
    });

//  login.php
    function comprobar_login() {
        //  DESUPUÉS DE OCULTAR EL MENSAJE DE ALERTA SE EJECUTA LA FUNCIÓN QUE COMPRUEBA EL LOGIN
        $(".alert").slideUp(200, function() {

            //  DECLARACIÓN DE VARIABLES
            var correcto = true;
            var usuario = $("#usuario");
            var contrasenya = $("#contrasenya");

            //  CUANDO UN INPUT TIENE EL FOCO SE LE QUITA LA CLASE DE ERROR
            $("input").focus(function(){
                $(this).parent().removeClass("has-error");
                $(this).siblings("span").css("color", "#777777");
            });

            //  COMPROBACIÓN DEL USUARIO
            if (usuario.val() == "") {
                error_input(usuario);
            }

            //  COMPROBACIÓN DE LA CONTRASEÑA
            if (contrasenya.val() == "") {
                error_input(contrasenya);
            }

            //  FUNCIÓN QUE DA A LOS INPUT LA CLASE DE ERROR, PONE LA VARIABLE CORRECTO EN FALSE Y MUESTRA EL MENSAJE DE ERROR
            function error_input(input) {
                input.parent("div").addClass("has-error");
                input.siblings("span").css("color", "#a94442");
                correcto = false;
            }

            //  SI TODOS LOS DATOS SON CORRECTOS SE MANDAN CON AJAX
            if (correcto == true) {
                //  PONER EL GIF DE CARGANDO...
                $("#cargando").html("<center><img src='img/cargando.gif' width='30'></center>");

                //  INICIO DE AJAX
                var parametros = {
                    "usuario" : usuario.val(),
                    "contrasenya" : contrasenya.val()
                };
                $.ajax({
                    data:  parametros,
                    url:   'comprobar_login.php',
                    type:  'post',
                    success:  function (respuesta) {
                        //  SE VUELVE A CARGAR EL BOTON DE INICIAR SESIÓN
                        $("#cargando").html("<button type='submit' class='btn btn-primary btn-block btn-flat'>Iniciar sesión</button>");
                        if (respuesta == "todo correcto") {
                            //  SI TODO ES CORRECTO SE REDIRECCIONA AL INDEX
                            window.location.replace('index.php');
                        } else {
                            //  SI ALGUN DATO NO ES CORRECTO, SE MUESTRA EL MENSAJE DE ERROR
                            $("#mensaje").html(respuesta);
                            $(".alert").slideDown(200);
                        }
                    }
                });
                //  FIN DE AJAX
            } else {
                //  SI ALGUN DATO NO ES CORRECTO, SE MUESTRA EL MENSAJE DE ERROR
                $(".alert").slideDown(200);
                $("#mensaje").html("Rellena todos los campos");
            }
        });
    }

//  registro.php
    function comprobar_registro() {
        //  DESUPUÉS DE OCULTAR EL MENSAJE DE ALERTA SE EJECUTA LA FUNCIÓN QUE COMPRUEBA EL REGISTRO
        $(".alert").slideUp(200, function() {

            //  DECLARACIÓN DE VARIABLES
            var correcto = true;
            var mensaje = "";
            var nombre = $("#nombre");
            var usuario = $("#usuario");
            var nif = $("#nif");
            var email = $("#email");
            var contrasenya = $("#contrasenya");
            var contrasenya2 = $("#contrasenya2");

            //  CUANDO UN INPUT TIENE EL FOCO SE LE QUITA LA CLASE DE ERROR
            $("input").focus(function(){
                $(this).parent().removeClass("has-error");
                $(this).siblings('span').css("color", "#777777");
            });

            //  EXPRESIONES REGULARES PARA COMPROBAR LOS CAMPOS
            var expR_nombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{1,20}\s[A-Za-zA-Za-zÁÉÍÓÚáéíóúÑñ]{1,20}(\s[A-Za-zA-Za-zÁÉÍÓÚáéíóúÑñ]{1,20})?$/;
            var expR_usuario = /^[A-Za-z0-9]{6,50}$/;
            var expR_nif = /^[0-9]{8}[A-Za-z]{1}$/;
            var expR_email = /^[A-Za-z0-9._-]{1,50}\@[A-Za-z0-9._-]{1,50}\.[a-z]{1,10}$/;
            var expR_contrasenya = /^[A-Za-z0-9]{6,12}$/;

            //  COMPROBACIÓN DEL NOMBRE
            if (nombre.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(nombre);
            } else if (!expR_nombre.test(nombre.val())) {
                mensaje = "Introduce tu nombre y al menos un apellido";
                error_input(nombre);
            }

            //  COMPROBACIÓN DEL USUARIO
            if (usuario.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(usuario);
            } else if (!expR_usuario.test(usuario.val())) {
                mensaje = "Usuario no válido (6 - 50 caracteres) solo letras y números";
                error_input(usuario);
            }

            //  COMPROBACIÓN DEL NIF
            if (nif.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(nif);
            } else if (!expR_nif.test(nif.val())) {
                mensaje = "NIF no válido";
                error_input(nif);
            }

            //  COMPROBACIÓN DEL EMAIL
            if (email.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(email);
            } else if (!expR_email.test(email.val())) {
                mensaje = "E-Mail no válido";
                error_input(email);
            }

            //  COMPROBACIÓN DE LA CONTRASEÑA
            if (contrasenya.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(contrasenya);
            } else if (!expR_contrasenya.test(contrasenya.val())) {
                mensaje = "Contraseña no válida (6 - 12 caracteres) solo letras y números";
                error_input(contrasenya);
            }

            //  COMPROBACIÓN DE LA CONTRASEÑA 2
            if (contrasenya2.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(contrasenya2);
            } else if (contrasenya.val() != contrasenya2.val()) {
                mensaje = "Las contraseñas no coinciden";
                error_input(contrasenya2);
            }

            //  FUNCIÓN QUE DA A LOS INPUT LA CLASE DE ERROR Y PONE LA VARIABLE CORRECTO EN FALSE
            function error_input(input) {
                input.parent("div").addClass("has-error");
                input.siblings("span").css("color", "#a94442");
                correcto = false;
            }

            //  SI TODOS LOS DATOS SON CORRECTOS SE MANDAN CON AJAX
            if (correcto == true) {
                //  PONER EL GIF DE CARGANDO...
                $("#cargando").html("<center><img src='img/cargando.gif' width='30'></center>");

                //  INICIO DE AJAX
                var parametros = {
                    "nombre" : nombre.val(),
                    "usuario" : usuario.val(),
                    "nif" : nif.val(),
                    "email" : email.val(),
                    "contrasenya" : contrasenya.val(),
                    "contrasenya2" : contrasenya2.val()
                };
                $.ajax({
                    data:  parametros,
                    url:   'comprobar_registro.php',
                    type:  'post',
                    success:  function (respuesta) {
                        //  SE VUELVE A CARGAR EL BOTON DE INICIAR SESIÓN
                        $("#cargando").html("<button type='submit' class='btn btn-primary btn-block btn-flat'>Registrarse</button>");
                        if (respuesta == "todo correcto") {
                            //  SI TODO ES CORRECTO SE REDIRECCIONA AL LOGIN
                            window.location.replace('login.php');
                        } else {
                            //  SI ALGUN DATO NO ES CORRECTO, SE MUESTRA EL MENSAJE DE ERROR
                            $("#mensaje").html(respuesta);
                            $(".alert").slideDown(200);
                        }
                    }
                });
                //  FIN DE AJAX
            } else {
                //  SI ALGUN DATO NO ES CORRECTO, SE MUESTRA EL MENSAJE DE ERROR
                $("#mensaje").html(mensaje);
                $(".alert").slideDown(200);
            }
        });
    }

//  olvido_contrasenya.php
    function comprobar_olvido_contrasenya() {
        //  DESUPUÉS DE OCULTAR EL MENSAJE DE ALERTA SE EJECUTA LA FUNCIÓN QUE COMPRUEBA EL LOGIN
        $(".alert").slideUp(200, function() {

            //  DECLARACIÓN DE VARIABLES
            var correcto = true;
            var usuario = $("#usuario");

            //  CUANDO UN INPUT TIENE EL FOCO SE LE QUITA LA CLASE DE ERROR
            $("input").focus(function(){
                $(this).parent().removeClass("has-error");
                $(this).siblings("span").css("color", "#777777");
            });

            //  COMPROBACIÓN DEL USUARIO
            if (usuario.val() == "") {
                error_input(usuario);
            }

            //  FUNCIÓN QUE DA A LOS INPUT LA CLASE DE ERROR, PONE LA VARIABLE CORRECTO EN FALSE Y MUESTRA EL MENSAJE DE ERROR
            function error_input(input) {
                input.parent("div").addClass("has-error");
                input.siblings("span").css("color", "#a94442");
                correcto = false;
            }

            //  SI TODOS LOS DATOS SON CORRECTOS SE MANDAN CON AJAX
            if (correcto == true) {
                //  PONER EL GIF DE CARGANDO...
                $("#cargando").html("<center><img src='img/cargando.gif' width='30'></center>");

                //  INICIO DE AJAX
                var parametros = {
                    "usuario" : usuario.val()
                };
                $.ajax({
                    data:  parametros,
                    url:   'comprobar_olvido_contrasenya.php',
                    type:  'post',
                    success:  function (respuesta) {
                        //  SE VUELVE A CARGAR EL BOTON DE INICIAR SESIÓN
                        $("#cargando").html("<button type='submit' class='btn btn-primary btn-flat'>Recuperar contraseña</button>");
                        if (respuesta == "todo correcto") {
                            //  SI TODO ES CORRECTO SE REDIRECCIONA AL LOGIN
                            window.location.replace('login.php');
                        } else {
                            //  SI ALGUN DATO NO ES CORRECTO, SE MUESTRA EL MENSAJE DE ERROR
                            $("#mensaje").html(respuesta);
                            $(".alert").slideDown(200);
                        }
                    }
                });
                //  FIN DE AJAX
            } else {
                //  SI ALGUN DATO NO ES CORRECTO, SE MUESTRA EL MENSAJE DE ERROR
                $(".alert").slideDown(200);
                $("#mensaje").html("Introduce tu E-Mail o usuario");
            }
        });
    }

//  recuperar_contrasenya.php
    function comprobar_contrasenya_nueva() {
        //  DESUPUÉS DE OCULTAR EL MENSAJE DE ALERTA SE EJECUTA LA FUNCIÓN QUE COMPRUEBA EL REGISTRO
        $(".alert").slideUp(200, function() {

            //  DECLARACIÓN DE VARIABLES
            var correcto = true;
            var mensaje = "";
            var id = $("#id");
            var contrasenya = $("#contrasenya");
            var contrasenya2 = $("#contrasenya2");

            //  CUANDO UN INPUT TIENE EL FOCO SE LE QUITA LA CLASE DE ERROR
            $("input").focus(function(){
                $(this).parent().removeClass("has-error");
                $(this).siblings('span').css("color", "#777777");
            });

            //  EXPRESION REGULAR PARA COMPROBAR LAS CONTRASEÑAS
            var expR_contrasenya = /^[A-Za-z0-9]{6,12}$/;

            //  COMPROBACIÓN DE LA CONTRASEÑA
            if (contrasenya.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(contrasenya);
            } else if (!expR_contrasenya.test(contrasenya.val())) {
                mensaje = "Contraseña no válida (6 - 12 caracteres) solo letras y números";
                error_input(contrasenya);
            }

            //  COMPROBACIÓN DE LA CONTRASEÑA 2
            if (contrasenya2.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(contrasenya2);
            } else if (contrasenya.val() != contrasenya2.val()) {
                mensaje = "Las contraseñas no coinciden";
                error_input(contrasenya2);
            }

            //  FUNCIÓN QUE DA A LOS INPUT LA CLASE DE ERROR Y PONE LA VARIABLE CORRECTO EN FALSE
            function error_input(input) {
                input.parent("div").addClass("has-error");
                input.siblings("span").css("color", "#a94442");
                correcto = false;
            }

            //  SI TODOS LOS DATOS SON CORRECTOS SE MANDAN CON AJAX
            if (correcto == true) {
                //  PONER EL GIF DE CARGANDO...
                $("#cargando").html("<center><img src='img/cargando.gif' width='30'></center>");

                //  INICIO DE AJAX
                var parametros = {
                    "id" : id.val(),
                    "contrasenya" : contrasenya.val(),
                    "contrasenya2" : contrasenya2.val()
                };
                $.ajax({
                    data:  parametros,
                    url:   'comprobar_contrasenya_nueva.php',
                    type:  'post',
                    success:  function (respuesta) {
                        //  SE VUELVE A CARGAR EL BOTON DE INICIAR SESIÓN
                        $("#cargando").html("<button type='submit' class='btn btn-primary btn-flat'>Actualizar contraseña</button>");
                        if (respuesta == "todo correcto") {
                            //  SI TODO ES CORRECTO SE REDIRECCIONA AL INDEX
                            window.location.replace('login.php');
                        } else {
                            //  SI ALGUN DATO NO ES CORRECTO, SE MUESTRA EL MENSAJE DE ERROR
                            $("#mensaje").html(respuesta);
                            $(".alert").slideDown(200);
                        }
                    }
                });
                //  FIN DE AJAX
            } else {
                //  SI ALGUN DATO NO ES CORRECTO, SE MUESTRA EL MENSAJE DE ERROR
                $("#mensaje").html(mensaje);
                $(".alert").slideDown(200);
            }
        });
    }

//  OTRAS FUNCIONES
    $(function () {
        $('.chek_azul').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });














