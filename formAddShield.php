<?php
include_once 'functionCheckLogin.php';

$code_login = login_check($mysqli);	
if($code_login <1) {
        header('Location: /index.php');
}
?>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Aggiungi Scheda</title>
        <link rel="stylesheet" href="css/style_form_add_shield.css">  
        <script src="js/ipaddressport-validation.js"></script>  
  </head>
  <body>
    <div class="container">
  <div id="add-form">
    <h3>Inserisci l'indirizzo IP e il numero di porta della scheda da aggiungere</h3>
    <fieldset>
      <form name="form1" id="form1" action="/addShield.php" method="get">
        <input type="text" name="ip" required value="Indirizzo IP" onBlur="if(this.value=='')this.value='Indirizzo IP'" onFocus="if(this.value=='Indirizzo IP')this.value='' ">
        <input type="text" name="port" required value="Numero porta" onBlur="if(this.value=='')this.value='Numero porta'" onFocus="if(this.value=='Numero porta')this.value='' ">
        <input type="button" value="Aggiungi" onClick='ValidateIPPort(document.form1.ip, document.form1.port)'>
      </form>
    </fieldset>
  </div>
</div>
</body>
</html>


