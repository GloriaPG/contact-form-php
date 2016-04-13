<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cotactanos!</title>
    <link rel="stylesheet" type="text/css" href="contactform.css">
  </head>
  <body>
    <div class="container">
     <form id="contact">
<?php
require_once('class.phpmailer.php');
if(isset($_POST['email'])) {

    

    /*** 
    * Configuración de asunto y destinatario.
    * - email_to  : Es el correo al que le será enviado el mail.
    * - email_subject : Es el asunto de el correo.
    */
 
    $email_subject = "Tenemos un nuevo comentario!";
    $email_to = "pruebas@zaachilagourmet.com"; // Dirección de correo a dónde llegan los datos ingresados en el formulario.

    $hasErrors = False;  
 
    function died($error) {
 
        // Si existe un error en el formulario se mostrará un mensaje a el usuario.

        echo "<h3>Opps! Algo salió mal...</h3><br />";
 
        echo "Errores.<br />";
        
        echo $error."<br />";
 
        echo "Por favor corrija sus datos.<br /><br />";

        die();
    }
 
    // Validamos de el lado de el servidor que los datos que son requeridos esten siendo enviados.
 
    if(!isset($_POST['name']) ||
 
        !isset($_POST['last_name']) ||
 
        !isset($_POST['email']) ||
 
        !isset($_POST['company'])
        ) {
 
        died('Datos incompletos, por favor ingrese los datos obligatorios.');       
 
    }

    // Tomamos los varoles de el formulario.
    // Los tomamos de el metodo POST porque es por el cual fueron enviados.
    
    $name = $_POST['name']; // requerido
 
    $last_name = $_POST['last_name']; // requerido
 
    $email_from = trim($_POST['email']); // requerido
 
    $company = $_POST['company']; // requerido

    $comments = $_POST['comments']; // no requerido en caso de querer hacerlo requerido agregar la validación en la linea 50.
 
    $error_message = "";

  // Validamos de el lado de el servidor que el parámetro email que nos stán enviando
  // tenga el formato de correo.
    
   $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/'; // Esta es una expresión regular que buscará el formato de email.
 
    if(!preg_match($email_exp,$email_from)) {

      $hasErrors=True;

      $error_message .= 'Su correo no es valido, por favor ingresar un correo valido, ejemplo : ejemplo@gmail.com .<br />';
   
    }

 
  if($hasErrors) {
 
    died($error_message);
 
  }
 
  /***
  * Crearción de el correo que estaremos enviando.
  */

    $email_message = "Nuevos comentarios.\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
     
 
    $email_message .= "Nombre: ".clean_string($name)."\n";
 
    $email_message .= "Apellidos: ".clean_string($last_name)."\n";
 
    $email_message .= "Email: ".clean_string($email_from)."\n";
 
    $email_message .= "Empresa: ".clean_string($company)."\n";
 
    $email_message .= "Comentarios: ".clean_string($comments)."\n";
  
 
  //Se crean los encabezados del correo
   
  $headers = 'From: '.$email_from."\r\n".
   
  'Reply-To: '.$email_from."\r\n" .
   
  'X-Mailer: PHP/' . phpversion();
   
  try {
      //mail($email_to, $email_subject, $email_message, $headers);
      mail($email_to, $email_subject, $email_message, $headers);
  } catch (Exception $e) {
      echo "<h3>Opps! Algo salió mal...</h3><br />";
      echo "<h4> Por el momento no podemos atenderte, por favor,intenta más tarde.</h4>";
  }


  /*** 
  * Función para enviar correo con archivo pdf adjunto.
  */
  function mail_attachment($name,$to,$from,$subject,$mainMessage,$fileatt,$fileattname) {
          $email = new PHPMailer();
          $email->From      = $from;
          $email->FromName  = $name;
          $email->Subject   = $subject;
          $email->Body      = $mainMessage;
          $email->AddAddress($to);

          $file_to_attach = $fileatt;

          $email->AddAttachment( $file_to_attach , $fileattname );

          return $email->Send();
      }
 
      // Settings
      $name        = "Zaachilagourmet";  // Nombre abjunto de el from.
      $from        = "pruebas@zaachilagourmet.com"; // Nombre de quien envía el correo.
      $subject     = "Gracias por tus comentarios!"; // Asunto de el corroe.
      $mainMessage = "Hola, gracias por tus comentarios!."; // Mensaje adjunto.
      $fileatt     = getcwd().'/pdf/XIV_PRESENTACION_HEB-101515.pdf'; // Lo calización de el archivo, se puede modificar el nombre de carpeta y archivo.
      $fileattname = "XIV_PRESENTACION_HEB-101515.pdf"; // Nombre de el archivo este puedes modificarlo  sin problema.
      mail_attachment($name,$email_from,$from,$subject,$mainMessage,$fileatt,$fileattname)
  
?>
 
<h3>Gracias por contactarnos!</h3>
<?php
 
}
 
?>
      </form>
    </div>
  </body>
</html>