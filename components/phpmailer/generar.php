<?php
include("../carrito/lib_carrito.php");

require 'PHPMailer/class.phpmailer.php';

$mail = new PHPMailer;

/** Configurar SMTP **/
$mail->isSMTP();                                      // Indicamos que use SMTP
$mail->Host = 'smtp.strato.com';                      // Indicamos los servidores SMTP
$mail->SMTPAuth = true;                               // Habilitamos la autenticación SMTP
$mail->Username = 'grupo2@grupo2.webinstitut.es';                 // SMTP username
$mail->Password = 'grupo2grupo2';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Habilitar encriptación TLS o SSL
$mail->Port = 587;                                    // TCP port

/** Configurar cabeceras del mensaje **/
$mail->From = 'grupo2@grupo2.webinstitut.es';                       // Correo del remitente
$mail->FromName = 'cajaLuz';           // Nombre del remitente
$mail->Subject = utf8_decode('Envío de factura');                // Asunto

/** Incluir destinatarios. El nombre es opcional **/
$mail->addAddress($_SESSION["cliente"][0]["email_cliente"], $_SESSION["cliente"][0]["nombre_cliente"]);
//$mail->addAddress('destinatario2@correo.com', 'Nombre2');
//$mail->addAddress('destinatario3@correo.com', 'Nombre3');

/** Con RE, CC, BCC **/
//$mail->addReplyTo('info@correo.com', 'Informacion');
//$mail->addCC('cc@correo.com');
$mail->addBCC('grupo2@grupo2.webinstitut.es');

/** Incluir archivos adjuntos. El nombre es opcional **/
$mail->addAttachment('facturas/' . $ref_factura . '.pdf');
//$mail->addAttachment('presupuestos/presupuesto.pdf', 'presu.jpg');

/** Enviarlo en formato HTML **/
$mail->isHTML(true);

/** Configurar cuerpo del mensaje **/
$mail->Body    = 'Te enviamos factura de <b>tu compra</b>';
//$mail->AltBody = 'Este es el mansaje en texto plano para clientes que no admitan HTML';

/** Para que use el lenguaje español **/
$mail->setLanguage('es');

/** Enviar mensaje... **/
if(!$mail->send()) {
    echo 'El mensaje no pudo ser enviado.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Mensaje enviado correctamente';
}


?>
