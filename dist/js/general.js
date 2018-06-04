//  GESTIONAR COOKIES CON JQUERY
    /*

    mas info: https://blog.endeos.com/gestionar-cookies-con-jquery/

    Crear una cookie:   Cookies.set("nombre", "valor");                 (cookie de sesión)
                        Cookies.set("nombre", "valor", {expires: 5});   (cookie que caduca a los 5 días)
    Leer una cookie:    Cookies.get("nombre");
    Borrar una cookie:  Cookies.remove("nombre");

    */

//  AL CARGAR EL DOCUMENTO
    $(document).ready(function() {
        cambiar_barra_izq();
        header_scroll();
        anula_slider();
        $(".efecto_aparecer").show(500, "swing", function(){
            $(".efecto_aparecer2").show(500, "swing");
            $(".efecto_aparecer3").show(1000, "swing");
            if ($(document).height() - 200 > $(window).height()) {
                $(".div_flecha_abajo").show(1000, "swing");
            }
        });

        //  AL HACER CLICK EN LAS FLECHAS QUE HACEN SCROLL SUAVE
        $(".fa-arrow-alt-circle-up").click(function(){
            $("html, body").animate({scrollTop:0}, 700, "swing");
        });
        $(".fa-arrow-alt-circle-down").click(function(){
            $("html, body").animate({scrollTop:($(document).height() - $(window).height())}, 700, "swing");
        });

        //  AL PASAR EL RATON POR ENCIMA DE LAS FLECHAS QUE HACEN SCROLL SUAVE
        $(".fa-arrow-alt-circle-up").mouseenter(function(){
            $(this).animate({opacity:"0.5"}, "fast", "linear");
            $(this).css("font-weight", "bold");
        });
        $(".fa-arrow-alt-circle-down").mouseenter(function(){
            $(this).animate({opacity:"0.5"}, "fast", "linear");
            $(this).css("font-weight", "bold");
        });

        //  AL QUITAR EL RATON DE ENCIMA CLICK DE LAS FLECHAS QUE HACEN SCROLL SUAVE
        $(".fa-arrow-alt-circle-up").mouseleave(function(){
            $(this).animate({opacity:"0.3"}, "fast", "linear");
            $(this).css("font-weight", "normal");
        });
        $(".fa-arrow-alt-circle-down").mouseleave(function(){
            $(this).animate({opacity:"0.3"}, "fast", "linear");
            $(this).css("font-weight", "normal");
        });

        //  AL HACER CLICK FUERA DEL NOMBRE DE USUARIO SE OCULTA EL MENU CON ANIMACIÓN
        $("html").click(function(){
            $("#menu_usuario").hide("fast");
        });
        //  AL HACER CLICK EN EL NOMBRE DE USUARIO SE DESPLIEGA EL MENU CON ANIMACIÓN
        $("#nombre_usuario").click(function(e){
            event.preventDefault();
            e.stopPropagation();
            $("#menu_usuario").toggle("fast");
        });

        /*$(".enlaces_facturas").click(function(event) {
            event.preventDefault();
        });*/
    });

//  AL HACER SCROLL
    $(window).on("scroll", function() {

        //  LA FLECHA QUE HACE SCROLL HACIA ARRIBA APARECE O DESAPARECE
        if ($(window).scrollTop() > 200) {
            $(".div_flecha_arriba").show(1000, "swing");
        } else {
            $(".div_flecha_arriba").hide(1000, "swing");
        }

        //  LA FLECHA QUE HACE SCROLL HACIA ABAJO APARECE O DESAPARECE
        $.fn.scrollBottom = function() {
            return $(document).height() - this.scrollTop() - this.height();
        };
        if ($(window).scrollBottom() < 200) {
            $(".div_flecha_abajo").hide(1000, "swing");
        } else {
            $(".div_flecha_abajo").show(1000, "swing");
        }
    });

//  AL CAMBIAR EL TAMAÑO DE VENTANA
    $(window).resize(function() {
        cambiar_barra_izq();
    });

//  barra_lateral_izq.php
    function cambiar_barra_izq() {
        if (document.documentElement.clientWidth <= 767) {
            var barra_lateral_izq = document.getElementById("barra_lateral_izq");
            var barra_lateral_izq_scroll = document.getElementById("barra_lateral_izq_scroll");
            barra_lateral_izq.style = "";
            barra_lateral_izq_scroll.style = "";
        } else {
            $("#barra_lateral_izq").css("position", "fixed");
            $("#barra_lateral_izq").css("top", "0");
            $("#barra_lateral_izq").css("bottom", "0");
            $("#barra_lateral_izq_scroll").css("overflow-y", "scroll");
            $("#barra_lateral_izq_scroll").css("height", "100%");
        }
    }

    //  AL HACER CLICK EN EL BOTON QUE OCULTA LA BARRA LATERAL IZQ CAMBIA CLASES DE LA LISTA DE CATEGORIAS
    function quitar_clases_barra_lateral_izq() {
        var lista_categorias = document.getElementById("lista_categorias");
        if (lista_categorias.style.position != "absolute") {
            lista_categorias.style.position = "absolute";
            lista_categorias.style.width = "100%";
        } else {
            lista_categorias.style.position = "";
        }
    }

//  carrito...
    function cargar_numero_productos() {
        $.ajax({
            url:   'components/carrito/mostrar_carrito.php',
            success:  function (response) {
                $("#mostrar_productos").html(response);
            }
        });
        $.ajax({
            url:   'components/carrito/hab_deshab_btn_ir_a_pagina_carrito.php',
            success:  function (response) {
                if (response == 0) {
                    $("#ir_a_pagina_carrito").attr("disabled", true);
                    $("#ir_a_pagina_carrito").attr("href", "#");
                } else {
                    $("#ir_a_pagina_carrito").attr("disabled", false);
                    $("#ir_a_pagina_carrito").attr("href", "pagina_carrito.php");
                }
            }
        });
    }

    function borrar_producto(linea) {
        var parametros = {
            "linea" : linea
        };
        $.ajax({
            data:  parametros,
            url:   'components/carrito/eliminar_producto.php',
            type:  'post',
            success:  function (response) {
                cargar_numero_productos();
                $("#cantidad_productos").html(response);
                if (response == "") {
                    $.ajax({
                        url:   'vaciar_carrito.php',
                        type:  'post'
                    });
                    $("#ir_a_pagina_carrito").attr("disabled", true);
                }
            }
        });
    }

//  CONTROL DEL SCROLL PARA EL HEADER EN LA VISTA EN MÓVIL
    function header_scroll(){
        var altura = $(".navbar").offset().top;
        $(window).on("scroll", function() {
            if ($(window).scrollTop() > altura) {
                $(".navbar").addClass("menu-fijo");
            } else {
                $(".navbar").removeClass("menu-fijo");
            }
        });
    }

//  PARA LOS FORMULARIOS DE PAGINACION
//  index.php
    function index_ir_a_pagina(total_paginas) {
        var pagina = document.getElementById("pagina");
        pagina.value = parseInt(pagina.value);
        if (pagina.value < 1 || isNaN(pagina.value)) {
            pagina.value = 1;
        } else if (pagina.value > total_paginas) {
            pagina.value = total_paginas;
        }
        document.location.href = "index.php?pagina=" + pagina.value;
    }

//  pagina_busqueda.php
    function busqueda_ir_a_pagina(total_paginas, buscar) {
        var pagina = document.getElementById("pagina");
        pagina.value = parseInt(pagina.value);
        if (pagina.value < 1 || isNaN(pagina.value)) {
            pagina.value = 1;
        } else if (pagina.value > total_paginas) {
            pagina.value = total_paginas;
        }
        document.location.href = "pagina_busqueda.php?buscar=" + buscar + "&pagina=" + pagina.value;
    }

//  pagina_familia.php
    function familia_ir_a_pagina(total_paginas, familia) {
        var pagina = document.getElementById("pagina");
        pagina.value = parseInt(pagina.value);
        if (pagina.value < 1 || isNaN(pagina.value)) {
            pagina.value = 1;
        } else if (pagina.value > total_paginas) {
            pagina.value = total_paginas;
        }
        document.location.href = "pagina_familia.php?familia=" + familia + "&pagina=" + pagina.value;
    }

//  pagina_subfamilia.php
    function subfamilia_ir_a_pagina(total_paginas, subfamilia) {
        var pagina = document.getElementById("pagina");
        pagina.value = parseInt(pagina.value);
        if (pagina.value < 1 || isNaN(pagina.value)) {
            pagina.value = 1;
        } else if (pagina.value > total_paginas) {
            pagina.value = total_paginas;
        }
        document.location.href = "pagina_subfamilia.php?subfamilia=" + subfamilia + "&pagina=" + pagina.value;
    }

//  pagina_producto.php
    //  JQUERY (SLIDER IMAGENES)
    function anula_slider() {
        $('#myCarousel').carousel({
            interval: null
        });

        var clickEvent = false;
        $('#myCarousel').on('click', '.nav div li a', function() {
            clickEvent = true;
            $('.nav div li').removeClass('active');
            $(this).parent().addClass('active');
        }).on('slid.bs.carousel', function(e) {
            if (!clickEvent) {
                var count = $('.nav div').children().length - 1;
                var current = $('.nav div li .active');
                current.removeClass('active').next().addClass('active');
                var id = parseInt(current.data('slide-to'));
                if (count == id) {
                    $('.nav div li').first().addClass('active');
                }
            }
            clickEvent = false;
        });
    }

    //  PARA CALCULAR PRECIO AL DARLE A BOTON (-)
    function restar1(precio, stock) {
        if (cantidad.value > 1) {
            cantidad.value--;
            precio_total.innerHTML = precio * cantidad.value + " €";
        }
    }

    //  PARA CALCULAR PRECIO AL DARLE A BOTON (+)
    function sumar1(precio, stock) {
        if (cantidad.value < stock) {
            cantidad.value++;
            precio_total.innerHTML = precio * cantidad.value + " €";
        }
    }

    // PARA CALCULAR PRECIO CUANDO EL INPUT PIERDE EL FOCO
    function calcular(precio, stock) {
        cantidad.value = parseInt(cantidad.value);
        if (cantidad.value > stock) {
            cantidad.value = stock;
        }
        if (cantidad.value < 1) {
            cantidad.value = 1;
        }
        if (stock == 0) {
            cantidad.value = 0;
        }
        if (isNaN(cantidad.value)) {
            cantidad.value = 1;
        }
        precio_total.innerHTML = precio * cantidad.value + " €";
    }

    //  PARA AÑADIR PRODUCTO AL CARRITO
    function añadir_al_carrito(id) {
        var cantidad = $('#cantidad').val();
        var parametros = {
            "id" : id,
            "cantidad" : cantidad
        };
        $.ajax({
            data:  parametros,
            url:   'components/carrito/mete_producto.php',
            type:  'post',
            success:  function (response) {
                $("#cantidad_productos").html(response);
            }
        });
        mostrar_popup("success", "correctamente", "Producto añadido");
    }

//  pagina_carrito.php
    //  PARA CALCULAR PRECIO AL DARLE A BOTON (-)
    function restar1_carrito(fila, precio, stock, id, cantidad_productos) {
        var cantidad = document.getElementById("cantidad_" + fila);
        var precio_total = document.getElementById("precio_total_" + fila);
        if (cantidad.value > 1) {
            cantidad.value--;
            precio_total.innerHTML = precio * cantidad.value + "€";
            calcular_suma(id, "-1", cantidad_productos);
        }
    }

    //  PARA CALCULAR PRECIO AL DARLE A BOTON (+)
    function sumar1_carrito(fila, precio, stock, id, cantidad_productos) {
        var cantidad = document.getElementById("cantidad_" + fila);
        var precio_total = document.getElementById("precio_total_" + fila);
        if (cantidad.value < stock) {
            cantidad.value++;
            precio_total.innerHTML = precio * cantidad.value + "€";
            calcular_suma(id, "1", cantidad_productos);
        }
    }

    // PARA CALCULAR PRECIO CUANDO PULSAMOS UNA TECLA EN EL INPUT
    function calcular_carrito(fila, precio, stock, id, cantidad_productos) {
        var cantidad = document.getElementById("cantidad_" + fila);
        var precio_total = document.getElementById("precio_total_" + fila);
        cantidad.value = parseInt(cantidad.value);
        if (cantidad.value > stock) {
            cantidad.value = stock;
        }
        if (cantidad.value < 1) {
            cantidad.value = 1;
        }
        if (stock == 0) {
            cantidad.value = 0;
        }
        if (isNaN(cantidad.value)) {
            cantidad.value = "";
        }
        if (!cantidad.value == "") {
            precio_total.innerHTML = precio * cantidad.value + "€";
            calcular_suma_onblur(id, cantidad.value, cantidad_productos);
        } else {
            precio_total.innerHTML = "0€";
            calcular_suma_onblur(id, "0", cantidad_productos);
        }
    }

    //  PARA CALCULAR LA SUMA TOTAL DE LA COMPRA CUANDO PULSAMOS (-) O (+)
    function calcular_suma(id, cantidad, cantidad_productos) {
        var precio_total = 0;
        var suma_total = document.getElementById("suma_total");
        var gastos_envio = document.getElementById("gastos_envio");
        var total = document.getElementById("total");
        var suma = 0;
        var gastos_de_envio;
        for (var fila=0; fila<cantidad_productos; fila++) {
            if (document.getElementById("precio_total_" + fila) != null) {
                precio_total = document.getElementById("precio_total_" + fila).innerHTML;
                precio_total = parseFloat(precio_total.substr(0, precio_total.indexOf("€")));
                suma += precio_total;
            }
        }
        suma_total.innerHTML = suma + "€";
        if (suma > 60) {
            gastos_de_envio = 0;
        } else {
            gastos_de_envio = 10;
        }
        gastos_envio.innerHTML = gastos_de_envio + "€";
        total.innerHTML = suma + gastos_de_envio + "€";

        // USAR AJAX PARA CAMBIAR LA CANTIDAD DEL PRODUCTO
        var parametros = {
            "id" : id,
            "cantidad" : cantidad
        };
        $.ajax({
            data:  parametros,
            url:   'components/carrito/mete_producto.php',
            type:  'post',
            success:  function (response) {
                $("#cantidad_productos").html(response);
                $("#cantidad_productos_2").html("(" + response + ")");
            }
        });
    }

    //  PARA CALCULAR LA SUMA TOTAL DE LA COMPRA CUANDO PULSAMOS UNA TECLA EN EL INPUT
    function calcular_suma_onblur(id, cantidad, cantidad_productos) {
        var precio_total = 0;
        var suma_total = document.getElementById("suma_total");
        var gastos_envio = document.getElementById("gastos_envio");
        var total = document.getElementById("total");
        var suma = 0;
        var gastos_de_envio;
        for (var fila=0; fila<cantidad_productos; fila++) {
            if (document.getElementById("precio_total_" + fila) != null) {
                precio_total = document.getElementById("precio_total_" + fila).innerHTML;
                precio_total = parseFloat(precio_total.substr(0, precio_total.indexOf("€")));
                suma += precio_total;
            }
        }
        suma_total.innerHTML = suma + "€";
        if (suma > 60) {
            gastos_de_envio = 0;
        } else {
            gastos_de_envio = 10;
        }
        gastos_envio.innerHTML = gastos_de_envio + "€";
        total.innerHTML = suma + gastos_de_envio + "€";

        // USAR AJAX PARA CAMBIAR LA CANTIDAD DEL PRODUCTO
        var parametros = {
            "id" : id,
            "cantidad" : cantidad,
            "cambiando_cantidad" : true
        };
        $.ajax({
            data:  parametros,
            url:   'components/carrito/mete_producto.php',
            type:  'post',
            success:  function (response) {
                $("#cantidad_productos").html(response);
                if (response != 0) {
                    $("#cantidad_productos_2").html("(" + response + ")");
                } else {
                    $("#cantidad_productos_2").html("(0)");
                }
            }
        });
    }

    //  INPUT PIERDE EL FOCO
    function pierde_foco(fila) {
        var cantidad = document.getElementById("cantidad_" + fila);
        if (cantidad.value == "") {
            cantidad.value = 1;
        }
    }

    //  CARGAR EL PRECIO TOTAL DE LA COMPRA
    function cargar_precio_compra() {
        $.ajax({
            url:   'components/carrito/calcular_total.php',
            success:  function (response) {
                $("#suma_total").html(response);

                var gastos_envio = document.getElementById("gastos_envio");
                var total = document.getElementById("total");
                var gastos_de_envio;

                response = parseFloat(response.substr(0, response.length-1));

                if (response > 60) {
                    gastos_de_envio = 0;
                } else {
                    gastos_de_envio = 10;
                }
                gastos_envio.innerHTML = gastos_de_envio + "€";
                total.innerHTML = (response + gastos_de_envio) + "€";
            }
        });
    }

    //  BORRAR PRODUCTO
    function borrar_producto_carrito(linea) {
        $("#fila_" + linea).hide("slow", function(){
            $("#fila_" + linea).html("");
        });
        var parametros = {
            "linea" : linea
        };
        $.ajax({
            data:  parametros,
            url:   'components/carrito/eliminar_producto.php',
            type:  'post',
            success:  function (response) {
                cargar_numero_productos();
                cargar_precio_compra();
                $("#cantidad_productos").html(response);
                if (response != 0) {
                    $("#cantidad_productos_2").html("(" + response + ")");
                } else if (response == "") {
                    $("#cantidad_productos_2").html("(0)");
                    $.ajax({
                        url:   'vaciar_carrito.php',
                        type:  'post'
                    });
                    $("#vaciar_carrito").attr("disabled", true);
                    $("#btn-pago").attr("disabled", true);
                }
                mostrar_popup("error", "correctamente", "Producto eliminado");
            }
        });
    }

    //  VACIAR CARRITO
    function vaciar_carrito(total_filas) {
        for (var i=0; i<total_filas; i++) {
            borrar_producto_carrito(i);
        }
        $.ajax({
            url:   'vaciar_carrito.php',
            type:  'post'
        });
    }

//  rellenar_datos_cliente.php
    function comprobar_datos_cliente() {
        //  DESUPUÉS DE OCULTAR EL MENSAJE DE ALERTA SE EJECUTA LA FUNCIÓN QUE COMPRUEBA EL REGISTRO
        $(".alert2").slideUp(200, function() {

            //  DECLARACIÓN DE VARIABLES
            var correcto = true;
            var mensaje = "";
            var telefono = $("#telefono");
            var fechaNacimiento = $("#fechaNacimiento");
            var direccion = $("#direccion");
            var cp = $("#cp");
            var ciudad = $("#ciudad");
            var provincia = $("#provincia");
            var pais = $("#pais");
            var info = $("#info");

            //  CUANDO UN INPUT TIENE EL FOCO SE LE QUITA LA CLASE DE ERROR
            $("input").focus(function(){
                $(this).parent().removeClass("has-error");
                $(this).siblings('span').css("color", "#777777");
            });

            //  EXPRESIONES REGULARES PARA COMPROBAR LOS CAMPOS
            var expR_telefono = /^[0-9]{9}$/;
            var expR_direccion = /^[\/0-9A-Za-zÁÉÍÓÚáéíóúÑñ,.º\s]{1,100}$/;
            var expR_cp = /^[0-9]{5}$/;
            var expR_ciudad = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,15}$/;
            var expR_provincia = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,15}$/;
            var expR_pais = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,15}$/;

            //  COMPROBACIÓN DEL TELÉFONO
            if (telefono.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(telefono);
            } else if (!expR_telefono.test(telefono.val())) {
                mensaje = "Teléfono incorrecto";
                error_input(telefono);
            }

            //  COMPROBACIÓN DE FECHA DE NACIMIENTO
            if (fechaNacimiento.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(fechaNacimiento);
            }

            //  COMPROBACIÓN DE LA DIRECCIÓN
            if (direccion.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(direccion);
            } else if (!expR_direccion.test(direccion.val())) {
                mensaje = "Dirección incorrecta";
                error_input(direccion);
            }

            //  COMPROBACIÓN DEL CÓDIGO POSTAL
            if (cp.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(cp);
            } else if (!expR_cp.test(cp.val())) {
                mensaje = "Código postal no válido";
                error_input(cp);
            }

            //  COMPROBACIÓN DE LA CIUDAD
            if (ciudad.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(ciudad);
            } else if (!expR_ciudad.test(ciudad.val())) {
                mensaje = "Ciudad no válida";
                error_input(ciudad);
            }

            //  COMPROBACIÓN DE LA PROVINCIA
            if (provincia.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(provincia);
            } else if (!expR_provincia.test(provincia.val())) {
                mensaje = "Provincia no válida";
                error_input(provincia);
            }

            //  COMPROBACIÓN DEL PAÍS
            if (pais.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(pais);
            } else if (!expR_pais.test(pais.val())) {
                mensaje = "País no válido";
                error_input(pais);
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
                    "telefono" : telefono.val(),
                    "fechaNacimiento" : fechaNacimiento.val(),
                    "direccion" : direccion.val(),
                    "cp" : cp.val(),
                    "ciudad" : ciudad.val(),
                    "provincia" : provincia.val(),
                    "pais" : pais.val(),
                    "info" : info.val()
                };
                $.ajax({
                    data:  parametros,
                    url:   'comprobar_datos_compra.php',
                    type:  'post',
                    success:  function (respuesta) {
                        //  SE VUELVE A CARGAR EL BOTON DE FINALIZAR COMPRA
                        $("#cargando").html("<button type='submit' class='btn btn-primary pull-right'>Finalizar compra</button>");
                        if (respuesta == "todo correcto") {
                            //  SI TODO ES CORRECTO SE REDIRECCIONA A LA PÁGINA QUE ENVÍA LOS DATOS A PAYPAL
                            window.location.replace('components/paypal/recoger_datos.php');
                        }
                    }
                });
                //  FIN DE AJAX
            } else {
                //  SI ALGUN DATO NO ES CORRECTO, SE MUESTRA EL MENSAJE DE ERROR
                $("#mensaje").html(mensaje);
                $(".alert2").slideDown(200);
            }
        });
    }

//  pagina_perfil_cliente.php
    function modificar_datos_cliente() {
        $("#perfil_cliente").load("editar_datos_cliente.php");
    }

    function recargar_datos_cliente() {
        $("#perfil_cliente").load("mostrar_datos_cliente.php");
    }

    function comprobar_datos_perfil_cliente() {
        //  DESUPUÉS DE OCULTAR EL MENSAJE DE ALERTA SE EJECUTA LA FUNCIÓN QUE COMPRUEBA EL REGISTRO
        $(".alert2").slideUp(200, function() {

            //  DECLARACIÓN DE VARIABLES
            var correcto = true;
            var mensaje = "";
            var telefono = $("#telefono");
            var fechaNacimiento = $("#fechaNacimiento");
            var direccion = $("#direccion");
            var cp = $("#cp");
            var ciudad = $("#ciudad");
            var provincia = $("#provincia");
            var pais = $("#pais");
            var info = $("#info");

            //  CUANDO UN INPUT TIENE EL FOCO SE LE QUITA LA CLASE DE ERROR
            $("input").focus(function(){
                $(this).parent().removeClass("has-error");
                $(this).siblings('span').css("color", "#777777");
            });

            //  EXPRESIONES REGULARES PARA COMPROBAR LOS CAMPOS
            var expR_telefono = /^[0-9]{9}$/;
            var expR_direccion = /^[\/0-9A-Za-zÁÉÍÓÚáéíóúÑñ,.º\s]{1,100}$/;
            var expR_cp = /^[0-9]{5}$/;
            var expR_ciudad = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,15}$/;
            var expR_provincia = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,15}$/;
            var expR_pais = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,15}$/;

            //  COMPROBACIÓN DEL TELÉFONO
            if (telefono.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(telefono);
            } else if (!expR_telefono.test(telefono.val())) {
                mensaje = "Teléfono incorrecto";
                error_input(telefono);
            }

            //  COMPROBACIÓN DE FECHA DE NACIMIENTO
            if (fechaNacimiento.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(fechaNacimiento);
            }

            //  COMPROBACIÓN DE LA DIRECCIÓN
            if (direccion.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(direccion);
            } else if (!expR_direccion.test(direccion.val())) {
                mensaje = "Dirección incorrecta";
                error_input(direccion);
            }

            //  COMPROBACIÓN DEL CÓDIGO POSTAL
            if (cp.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(cp);
            } else if (!expR_cp.test(cp.val())) {
                mensaje = "Código postal no válido";
                error_input(cp);
            }

            //  COMPROBACIÓN DE LA CIUDAD
            if (ciudad.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(ciudad);
            } else if (!expR_ciudad.test(ciudad.val())) {
                mensaje = "Ciudad no válida";
                error_input(ciudad);
            }

            //  COMPROBACIÓN DE LA PROVINCIA
            if (provincia.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(provincia);
            } else if (!expR_provincia.test(provincia.val())) {
                mensaje = "Provincia no válida";
                error_input(provincia);
            }

            //  COMPROBACIÓN DEL PAÍS
            if (pais.val() == "") {
                mensaje = "Rellena todos los campos";
                error_input(pais);
            } else if (!expR_pais.test(pais.val())) {
                mensaje = "País no válido";
                error_input(pais);
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
                    "telefono" : telefono.val(),
                    "fechaNacimiento" : fechaNacimiento.val(),
                    "direccion" : direccion.val(),
                    "cp" : cp.val(),
                    "ciudad" : ciudad.val(),
                    "provincia" : provincia.val(),
                    "pais" : pais.val(),
                    "info" : info.val()
                };
                $.ajax({
                    data:  parametros,
                    url:   'comprobar_datos_compra.php',
                    type:  'post',
                    success:  function (respuesta) {
                        //  SE VUELVE A CARGAR EL BOTON DE FINALIZAR COMPRA
                        $("#cargando").html("<button type='submit' class='btn btn-primary pull-right'>Guardar</button>");
                        if (respuesta == "todo correcto") {
                            //  SI TODO ES CORRECTO SE REDIRECCIONA A LA PÁGINA QUE ENVÍA LOS DATOS A PAYPAL
                            window.location.replace('pagina_perfil_cliente.php');
                        }
                    }
                });
                //  FIN DE AJAX
            } else {
                //  SI ALGUN DATO NO ES CORRECTO, SE MUESTRA EL MENSAJE DE ERROR
                $("#mensaje").html(mensaje);
                $(".alert2").slideDown(200);
            }
        });
    }

//  MOSTRAR POPUPS
    function mostrar_popup(tipo, mensaje2, mensaje1) {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "100",
            "hideDuration": "1000",
            "timeOut": "1000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        Command: toastr[tipo](mensaje2, mensaje1)
    }











