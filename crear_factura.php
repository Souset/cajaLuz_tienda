<?php
    include_once("bd.php");

    $sql = "SELECT productos_vendidos.cantidad, productos.codigo, productos_vendidos.titulo_producto, productos_vendidos.PVP_producto, ventas.fecha_venta
            FROM productos_vendidos, productos, ventas
            WHERE ventas.id_venta = '$ref_factura' AND ventas.id_venta = productos_vendidos.fn_id_venta AND productos.id = productos_vendidos.fn_id_producto";
    $pedido = Query($sql);

    $sql = "SELECT *
            FROM clientes
            WHERE id_cliente = '$id_cliente'";
    $cliente = Query($sql);

    require('components/fpdf/fpdf.php');

    $ancho_celda_1 = 100;
    $ancho_celda_2 = 70;
    $alto_celda = 7;

    class PDF extends FPDF {

        protected $B = 0;
        protected $I = 0;
        protected $U = 0;
        protected $HREF = '';
        function WriteHTML($html) {
            // Intérprete de HTML
            $html = str_replace("\n",' ',$html);
            $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
            foreach($a as $i=>$e)
            {
                if($i%2==0)
                {
                    // Text
                    if($this->HREF)
                        $this->PutLink($this->HREF,$e);
                    else
                        $this->Write(5,$e);
                }
                else
                {
                    // Etiqueta
                    if($e[0]=='/')
                        $this->CloseTag(strtoupper(substr($e,1)));
                    else
                    {
                        // Extraer atributos
                        $a2 = explode(' ',$e);
                        $tag = strtoupper(array_shift($a2));
                        $attr = array();
                        foreach($a2 as $v)
                        {
                            if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                                $attr[strtoupper($a3[1])] = $a3[2];
                        }
                        $this->OpenTag($tag,$attr);
                    }
                }
            }
        }
        function OpenTag($tag, $attr) {
            // Etiqueta de apertura
            if($tag=='B' || $tag=='I' || $tag=='U')
                $this->SetStyle($tag,true);
            if($tag=='A')
                $this->HREF = $attr['HREF'];
            if($tag=='BR')
                $this->Ln(5);
        }
        function CloseTag($tag) {
            // Etiqueta de cierre
            if($tag=='B' || $tag=='I' || $tag=='U')
                $this->SetStyle($tag,false);
            if($tag=='A')
                $this->HREF = '';
        }
        function SetStyle($tag, $enable) {
            // Modificar estilo y escoger la fuente correspondiente
            $this->$tag += ($enable ? 1 : -1);
            $style = '';
            foreach(array('B', 'I', 'U') as $s)
            {
                if($this->$s>0)
                    $style .= $s;
            }
            $this->SetFont('',$style);
        }
        function PutLink($URL, $txt) {
            // Escribir un hiper-enlace
            $this->SetTextColor(0,0,255);
            $this->SetStyle('U',true);
            $this->Write(5,$txt,$URL);
            $this->SetStyle('U',false);
            $this->SetTextColor(0);
        }

        // Cabecera de página
        function Header() {
            // Logo
            $this->Image('img/cabecera_pdf.jpg',20,8,170);
            // Salto de línea
            $this->Ln(37);
        }
        // Pie de página
        function Footer() {
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Número de página
            $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->SetFont('Arial','B',12);

    $pdf->MultiCell(0,5,
        $pdf->Cell(85, 7, "DATOS DEL CLIENTE","B") .
        $pdf->Cell(15, 7, "") .
        $pdf->Cell(85, 7, "EMPRESA","B")
    );
    $pdf->Ln(2);

    $pdf->SetFont('Arial','',10);

    $pdf->MultiCell(0,5,
        $pdf->Cell(85, 7, "Nombre: " . $cliente[0]["nombre_cliente"]) .
        $pdf->Cell(15, 7, "") .
        $pdf->Cell(85, 7, "FACTURA Nº: " . $ref_factura)
    );
    $pdf->Ln(0);

    //  INVERTIR FORMATO FECHA
    $fecha = new DateTime($pedido[0]["fecha_venta"]);
    $fecha_venta = $fecha->format("d-m-Y");

    $pdf->MultiCell(0,5,
        $pdf->Cell(85, 7, "NIF: " . $cliente[0]["nif_cliente"]) .
        $pdf->Cell(15, 7, "") .
        $pdf->Cell(85, 7, "Fecha: " . $fecha_venta)
    );
    $pdf->Ln(0);

    $pdf->MultiCell(0,5,
        $pdf->Cell(85, 7, "Domicilio: " . $cliente[0]["direccion_cliente"]) .
        $pdf->Cell(15, 7, "") .
        $pdf->Cell(85, 7, "CajaLuz")
    );
    $pdf->Ln(0);

    $pdf->MultiCell(0,5,
        $pdf->Cell(85, 7, $cliente[0]["cp_cliente"] . " " . $cliente[0]["ciudad_cliente"] . " " . $cliente[0]["provincia_cliente"]) .
        $pdf->Cell(15, 7, "") .
        $pdf->Cell(85, 7, "C/ Los limones S/N")
    );
    $pdf->Ln(0);

    $pdf->MultiCell(0,5,
        $pdf->Cell(85, 7, "Teléfono: " . $cliente[0]["telefono_cliente"]) .
        $pdf->Cell(15, 7, "") .
        $pdf->Cell(85, 7, "Alicante")
    );
    $pdf->Ln(0);

    $pdf->MultiCell(0,5,
        $pdf->Cell(85, 7, "E-Mail: " . $cliente[0]["email_cliente"]) .
        $pdf->Cell(15, 7, "") .
        $pdf->Cell(85, 7, "CIF: B-13456899")
    );
    $pdf->Ln(10);

    $pdf->SetFont('Arial','B',12);

    $pdf->MultiCell(0,5,
        $pdf->Cell(85, 7, "DETALLES DE LA FACTURA")
    );
    $pdf->Ln(7);

    $pdf->SetFont('Arial','B',10);

    $pdf->MultiCell(0,5,
        $pdf->Cell(15, 7, "CANT.") .
        $pdf->Cell(120, 7, "CONCEPTO") .
        $pdf->Cell(25, 7, "PRECIO") .
        $pdf->Cell(25, 7, "  TOTAL")
    );
    $pdf->Ln(2);

    $suma_total = 0;

    $pdf->SetFont('Arial','',9);

    for ($i=0; $i<count($pedido); $i++) {
        $titulo_producto = $pedido[$i]["titulo_producto"];
        if (strlen($titulo_producto) > 55) {
            $titulo_producto = substr($titulo_producto, 0, 55) . "...";
        }

        $pdf->MultiCell(0,5,
            $pdf->Cell(15, 7, $pedido[$i]["cantidad"],1) .
            $pdf->Cell(120, 7, $pedido[$i]["codigo"] . " - " . $titulo_producto,1) .
            $pdf->Cell(25, 7, round($pedido[$i]["PVP_producto"]/1.21,2) . $_EURO,1,0,"R") .
            $pdf->Cell(25, 7, round($pedido[$i]["PVP_producto"]/1.21*$pedido[$i]["cantidad"],2) . $_EURO,1,0,"R")
        );
        $pdf->Ln(2);

        $suma_total += $pedido[$i]["PVP_producto"]*$pedido[$i]["cantidad"];
    }

    $suma = round($suma_total/1.21,2);
    $gEnvio = $suma_total>60?0:round(10/1.21,2);
    $iva = $suma_total+$gEnvio-round($suma_total/1.21,2);

    $pdf->SetFont('Arial','B',9);

    $pdf->MultiCell(0,5,
        $pdf->Cell(15, 7,"","L") .
        $pdf->Cell(120, 7) .
        $pdf->Cell(25, 7, "SUMA",1) .
        $pdf->Cell(25, 7, $suma . $_EURO,1,0,"R")
    );
    $pdf->Ln(2);
    $pdf->MultiCell(0,5,
        $pdf->Cell(15, 7,"","L") .
        $pdf->Cell(120, 7) .
        $pdf->Cell(25, 7, "G. ENVÍO",1) .
        $pdf->Cell(25, 7, $gEnvio . $_EURO,1,0,"R")
    );
    $pdf->Ln(2);
    $pdf->MultiCell(0,5,
        $pdf->Cell(15, 7,"","L") .
        $pdf->Cell(120, 7) .
        $pdf->Cell(25, 7, "IVA 21%",1) .
        $pdf->Cell(25, 7, $iva . $_EURO,1,0,"R")
    );
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',10);
    $pdf->MultiCell(0,5,
        $pdf->Cell(15, 7,"","LB") .
        $pdf->Cell(120, 7,"","B") .
        $pdf->Cell(25, 7, "SUMA TOTAL",1) .
        $pdf->Cell(25, 7, $suma_total . $_EURO,1,0,"R")
    );
    $pdf->Ln(2);

    $pdf->Output("F", "facturas/" . $ref_factura . ".pdf");
?>
