<?php
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'PHPMailer/PHPMailerAutoload.php';

if (isset($_POST['inputName']) && isset($_POST['inputEmail']) && isset($_POST['inputPhone']) && isset($_POST['inputMessage'])) {

    //check if any of the inputs are empty
    if (empty($_POST['inputName']) || empty($_POST['inputEmail']) || empty($_POST['inputPhone']) || empty($_POST['inputMessage'])) {
        $data = array('success' => false, 'message' => 'Por favor complete todos los campos');
        echo json_encode($data);
        exit;
    }

    //create an instance of PHPMailer
    $mail = new PHPMailer();
    // incluimos los datos de conexión
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'usuario@gmail.com';                 // SMTP username
    $mail->Password = 'password';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;
    //datos para el envio
    $mail->From = $_POST['inputEmail'];
    $mail->FromName = $_POST['inputName'];
    $mail->AddAddress('usuario@gmail.com'); //recipient
    $mail->Subject = "Reporte de Incidentes - Vía addons para firefox";
    $mail->Body = "Nombre: " . $_POST['inputName'] . "\r\n\r\nDescripción: " . stripslashes($_POST['inputMessage']). "\r\n\r\nTeléfono: " .$_POST['inputPhone']. "\r\n\r\nCorreo: " .$_POST['inputEmail'];
    if (isset($_POST['ref'])) {
        $mail->Body .= "\r\n\r\nRef: " . $_POST['ref'];
    }

    if(!$mail->send()) {
        $data = array('success' => false, 'message' => 'Su mensaje no pudo ser enviado. ' . $mail->ErrorInfo);
        echo json_encode($data);
        exit;
    }

    $data = array('success' => true, 'message' => 'Muchas gracias. Hemos recibido su mensaje');
    echo json_encode($data);

} else {

    $data = array('success' => false, 'message' => 'POr favor rellene todos los campos correctamente;
    echo json_encode($data);

}
