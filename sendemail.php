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
if(isset($_POST['email'])) {

    function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
        $file = $path.$filename;
        $file_size = filesize($file);
        $handle = fopen($file, "r");
        $content = fread($handle, $file_size);
        fclose($handle);
        $content = chunk_split(base64_encode($content));
        $uid = md5(uniqid(time()));
        $name = basename($file);
        $header = "From: ".$from_name." <".$from_mail.">\r\n";
        $header .= "Reply-To: ".$replyto."\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        $header .= "This is a multi-part message in MIME format.\r\n";
        $header .= "--".$uid."\r\n";
        $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
        $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $header .= $message."\r\n\r\n";
        $header .= "--".$uid."\r\n";
        $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
        $header .= "Content-Transfer-Encoding: base64\r\n";
        $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
        $header .= $content."\r\n\r\n";
        $header .= "--".$uid."--";
        if (mail($mailto, $subject, "", $header)) {
            return True;
        } else {
            return False;
        }
    }
 
    /*** 
    * Configuración de asunto y destinatario.
    * - email_to  : Es el correo al que le será enviado el mail.
    * - email_subject : Es el asunto de el correo.
    */
 
    $email_to = "pruebas@zaachilagourmet.com";
 
    $email_subject = "Tenemos un nuevo comentario!";

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
 
        !isset($_POST['company']) ||

        !isset($_POST['comments'])
        ) {
 
        died('Datos incompletos, por favor ingrese los datos obligatorios.');       
 
    }

    // Tomamos los varoles de el formulario.
    // Los tomamos de el metodo POST porque es por el cual fueron enviados.
    
    $name = $_POST['name']; // requerido
 
    $last_name = $_POST['last_name']; // requerido
 
    $email_from = $_POST['email']; // requerido
 
    $company = $_POST['company']; // requerido

    $comments = $_POST['comments']; // no requerido
 
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
      mail($email_to, $email_subject, $email_message, $headers);
  } catch (Exception $e) {
      echo "<h3>Opps! Algo salió mal...</h3><br />";
      echo "<h4> Por el momento no podemos atenderte, por favor,intenta más tarde.</h4>";
  }

  $my_file = "document.pdf"; // puede ser cualquier formato
  $my_path = getcwd().'/';
  $my_name = $name;
  $my_mail = $email_to;
  $my_replyto = $email_to;
  $my_subject = "Archivo adjunto";
  $my_message = "Tu mensaje";
  mail_attachment($my_file, $my_path, $email, $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
  
?>
 
<h3>Gracias por contactarnos!</h3>
<?php
 
}
 
?>
      </form>
    </div>
  </body>
</html>