<?php
    include("bd.php");

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $sql = "SELECT *
                FROM productos
                WHERE subfamilia = '$id'";
        $productos = Query($sql);
    }

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
    for ($i=0; $i<count($productos); $i++) {
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);
        $pdf->MultiCell(0,5,
            $pdf->Cell(40, $pdf->Image($productos[$i]["imagen"],13,40,30)) .
            $pdf->MultiCell(140,7, $productos[$i]["titulo"] . "\n" . "Precio: " . $productos[$i]["PVP"] . $_EURO));
        $pdf->Ln($alto_celda);

        $pdf->Cell(0,0,"CARACTERÍSTICAS",0,0,'C');
        $pdf->Ln($alto_celda);
        $pdf->SetFont('Arial','',10);

        $pdf->Cell(10);
        $pdf->Cell(0,$alto_celda,
            $pdf->Cell($ancho_celda_1,$alto_celda, "Precio:") .
            $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["PVP"] . $_EURO));
        $pdf->Ln($alto_celda);

        $pdf->Cell(10);
        $pdf->Cell(0,$alto_celda,
            $pdf->Cell($ancho_celda_1,$alto_celda, "Referencia:") .
            $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["codigo"]));
        $pdf->Ln($alto_celda);

        if ($productos[$i]["horas"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Autonomía:") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["horas"]));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["potencia"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Potencia:") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["potencia"] . " W"));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["flujo_luminoso"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Flujo luminoso") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["flujo_luminoso"] . "lm"));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["angulo_apertura"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Ángulo de apertura") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["angulo_apertura"] . "º"));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["alimentacion"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Alimentación") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["alimentacion"]));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["temperatura"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Temperatura de calor") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["temperatura"]));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["num_leds"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Número de leds") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["num_leds"]));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["interior_exteior"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Interior-exterior") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["interior_exteior"]));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["proteccion_ip"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Protección IP") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["proteccion_ip"]));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["proteccion_ik"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Protección IK") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["proteccion_ik"]));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["ancho_mm"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Dimensiones del producto") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["ancho_mm"] . "x".$productos[$i]["largo_mm"] . "x" . $productos[$i]["alto_mm"] . " mm"));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["ancho_cm"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Dimensiones del paquete") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["ancho_cm"] . "x" . $productos[$i]["largo_cm"] . "x" . $productos[$i]["alto_cm"] . " cm"));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["peso_kg"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Peso del paquete") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["peso_kg"] . "Kg"));
            $pdf->Ln($alto_celda);
        }
        if ($productos[$i]["certificados"] != "") {
            $pdf->Cell(10);
            $pdf->Cell(0,$alto_celda,
                $pdf->Cell($ancho_celda_1,$alto_celda, "Certificados") .
                $pdf->Cell($ancho_celda_2,$alto_celda, $productos[$i]["certificados"]));
            $pdf->Ln($alto_celda);
        }

        $pdf->Ln(5);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(10,10, "Descripción");
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',10);
        $html = $productos[$i]["subtitulo"];
        $pdf->WriteHTML($html);
    }
    $pdf->Output();
?>
