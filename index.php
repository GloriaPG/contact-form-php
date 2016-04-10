<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cotactanos!</title>
    <link rel="stylesheet" type="text/css" href="contactform.css">
  </head>
  <body>
    <div class="container">  
      <form id="contact" action="sendemail.php" method="post">
        <h3>Contactanos!</h3>
        <h4>Esperamos responderte en menos de 24 horas!</h4>
        <fieldset>
          <input name="name" id="name" placeholder="Tu nombre" type="text" tabindex="1" required autofocus>
        </fieldset>
        <fieldset>
          <input name="last_name" id="last_name" placeholder="Tus apellidos" type="text" tabindex="2" required autofocus>
        </fieldset>
        <fieldset>
          <input name="company" id="company" placeholder="El nombre de tu empresa" type="text" tabindex="3" required autofocus>
        </fieldset>
        <fieldset>
          <input name="email" id="email" placeholder="Tu email" type="email" tabindex="4" required>
        </fieldset>
        <fieldset>
          <textarea name="comments" id="comments" placeholder="Deja tus comentarios...." tabindex="5" required></textarea>
        </fieldset>
        <fieldset>
          <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Enviar</button>
        </fieldset>
      </form>
    </div>
  </body>
</html>
