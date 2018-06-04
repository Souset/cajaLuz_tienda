<?php
class carrito {
	//atributos de la clase
   	/*var $num_productos;
   	var $array_id_prod;
   	var $array_nombre_prod;
   	var $array_precio_prod;
    var $array_cantidad_prod;
    var $array_imagen_prod;
    var $array_stock_prod;
    var $cantidad_total;*/

	//constructor. Realiza las tareas de inicializar los objetos cuando se instancian
	//inicializa el numero de productos a 0
	function carrito () {
   		$this->num_productos=0;
	}

    //cantidad para cargar en el icono del carrito (en el header)
    function cantidad_productos() {
        $this->cantidad_total = 0;
        for ($i=0; $i<$this->num_productos; $i++) {
			if($this->array_id_prod[$i] != 0) {
                $this->cantidad_total += $this->array_cantidad_prod[$i];
			}
		}
        if ($this->cantidad_total > 0) {
            echo $this->cantidad_total;
        }
    }
    function cantidad_productos2() {
        $this->cantidad_total2 = 0;
        for ($i=0; $i<$this->num_productos; $i++) {
			if($this->array_id_prod[$i] != 0) {
                $this->cantidad_total2 += $this->array_cantidad_prod[$i];
			}
		}
        echo $this->cantidad_total2;
    }

    //calcula el precio total de todos los productos que hay en el carrito
    function calcula_precio_total() {
        $this->precio_total = 0;
        for ($i=0; $i<$this->num_productos; $i++) {
            if($this->array_id_prod[$i] != 0) {
                $this->precio_total += $this->array_precio_prod[$i] * $this->array_cantidad_prod[$i];
            }
        }
        echo $this->precio_total . "€";
    }


    //Introduce un producto en el carrito. Recibe los datos del producto
	//Se encarga de introducir los datos en los arrays del objeto carrito
	//luego aumenta en 1 el numero de productos
	function introduce_producto($id_prod, $codigo_prod, $nombre_prod,$precio_prod,$cantidad_prod,$imagen_prod,$stock_prod){
        $existe = false;
        for ($i=0; $i<$this->num_productos; $i++) {
            if ($this->array_id_prod[$i] == $id_prod) {
                $existe = true;
                $j = $i;
            }
        }
        if ($existe == true) {
            if ($this->array_cantidad_prod[$j] + $cantidad_prod <= $stock_prod) {
                $this->array_cantidad_prod[$j] += $cantidad_prod;
            } else {
                $this->array_cantidad_prod[$j] = $stock_prod;
            }
        } else {
            $this->array_id_prod[$this->num_productos]=$id_prod;
            $this->array_codigo_prod[$this->num_productos]=$codigo_prod;
            $this->array_nombre_prod[$this->num_productos]=$nombre_prod;
            $this->array_precio_prod[$this->num_productos]=$precio_prod;
            $this->array_cantidad_prod[$this->num_productos]=$cantidad_prod;
            $this->array_imagen_prod[$this->num_productos]=$imagen_prod;
            $this->array_stock_prod[$this->num_productos]=$stock_prod;
            $this->num_productos++;
        }
	}

    //  cuando se cambia la cantidad de un producto en la pagina_carrito.php
    function modifica_producto($id_prod, $cantidad_prod) {
        for ($i=0; $i<$this->num_productos; $i++) {
            if ($this->array_id_prod[$i] == $id_prod) {
                $this->array_cantidad_prod[$i] = $cantidad_prod;
            }
        }
    }

	//Muestra el contenido del carrito de la compra
	//ademas pone los enlaces para eliminar un producto del carrito
	function imprime_carrito() {
		$suma = 0;
		for ($i=0;$i<$this->num_productos;$i++) {
			if ($this->array_id_prod[$i]!=0) {
                echo '  <div class="row">                                                                                       ';
                echo '      <div class="col-md-7">                                                                              ';
                echo '          <a href="pagina_producto.php?id=' . $this->array_id_prod[$i] . '">                              ';
                echo '              <div class="row">                                                                           ';
                echo '                  <div class="col-xs-2">                                                                  ';
                echo '                      <img class="borde_imagen" src="' . $this->array_imagen_prod[$i] . '" width="50px">  ';
                echo '                  </div>                                                                                  ';
                echo '                  <div class="col-xs-10">' . $this->array_nombre_prod[$i] . '</div>                       ';
                echo '              </div>                                                                                      ';
                echo '          </a>                                                                                            ';
                echo '      </div>                                                                                              ';
                echo '      <div class="col-md-5">                                                                              ';
                echo '          <div class="row" style>                                                                         ';
                echo '              <div class="col-xs-3 hidden-sm hidden-xs precios_productos_carrito">                        ';
                echo                    $this->array_precio_prod[$i] . '€                                                       ';
                echo '              </div>                                                                                      ';
                echo '              <div class="col-xs-4">                                                                      ';
                echo                    $this->array_cantidad_prod[$i]                                                           ;
                echo '              </div>                                                                                      ';
                echo '              <div class="col-xs-3 precios_productos_carrito">                                            ';
                echo                    $this->array_precio_prod[$i] * $this->array_cantidad_prod[$i] . '€                      ';
                echo '              </div>                                                                                      ';
                echo '              <div class="col-xs-2 col-sm-2">                                                             ';
                echo '                  <a onclick="borrar_producto(' . $i . ')"><i class="fas fa-trash-alt"></i></a>           ';
                echo '              </div>                                                                                      ';
                echo '          </div>                                                                                          ';
                echo '      </div>                                                                                              ';
                echo '  </div>                                                                                                  ';

                $suma += $this->array_precio_prod[$i] * $this->array_cantidad_prod[$i];
            }
        }
        //muestro el total
        echo '  <div class="row tabla_carrito_total">                                                                   ';
        echo '      <div class="col-xs-9"><h3><b>TOTAL:</b></h3></div>                                                  ';
        echo '      <div class="col-xs-3"><h3><b>' . $suma . '€</b></h3></div>                                          ';
        echo '  </div>                                                                                                  ';
        $this->suma_total = $suma;


                /*
                echo '  <tr>                                                                                            ';
                echo '      <td>                                                                                        ';
                echo '          <a href="pagina_producto.php?id=' . $this->array_id_prod[$i] . '">                      ';
                echo '              <img class="borde_imagen" src="' . $this->array_imagen_prod[$i] . '" width="50px">  ';
                echo '          </a>                                                                                    ';
                echo '      </td>                                                                                       ';
                echo '      <td>                                                                                        ';
                echo '          <a href="pagina_producto.php?id=' . $this->array_id_prod[$i] . '">                      ';
                echo '              <h4>' . $this->array_nombre_prod[$i] . '</h4>                                       ';
                echo '          </a>                                                                                    ';
                echo '      </td>                                                                                       ';
                echo '      <td>                                                                                        ';
                echo '          <h4>' . $this->array_precio_prod[$i] . '€</h4>                                          ';
                echo '      </td>                                                                                       ';
                echo '      <td>                                                                                        ';
                echo '          <h4>' . $this->array_cantidad_prod[$i] . '</h4>                                         ';
                echo '      </td>                                                                                       ';
                echo '      <td>                                                                                        ';
                echo '          <h4>' . $this->array_precio_prod[$i] * $this->array_cantidad_prod[$i] . '€</h4>         ';
                echo '      </td>                                                                                       ';
                echo '      <td>                                                                                        ';
                echo '          <a onclick="borrar_producto(' . $i . ')"><i class="fas fa-trash-alt"></i></a>           ';
                echo '      </td>                                                                                       ';
                echo '  </tr>                                                                                           ';

				$suma += $this->array_precio_prod[$i] * $this->array_cantidad_prod[$i];
			}
		}
		//muestro el total
		echo '
            <tr class="tabla_carrito_total">
                <td colspan="4">
                    <h4><b>TOTAL:</b></h4>
                </td>
                <td colspan="2">
                    <h4><b>' . $suma . '€</b></h4>
                </td>
            </tr>
        ';
        */


		/*//total más IVA
		echo "<tr><td><b>IVA (21%):</b></td><td> <b>" . $suma * 1.21 . "</b></td><td>&nbsp;</td></tr>";
		echo "</table>";*/
        if ($suma < 60) {
            $this->gastos_envio = 10;
        } else {
            $this->gastos_envio = 0;
        }
	}

	//elimina un producto del carrito. recibe la linea del carrito que debe eliminar
	//no lo elimina realmente, simplemente pone a cero el id, para saber que esta en estado retirado
	function elimina_producto($linea){
		$this->array_id_prod[$linea]=0;

	}

}
//inicio la sesión
session_start();
//si no esta creado el objeto carrito en la sesion, lo creo
if (!isset($_SESSION["ocarrito"])){
	$_SESSION["ocarrito"] = new carrito();
}
?>
