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
        <link rel="stylesheet" href="css/style_form_shield_name.css">    
  </head>
  <body>
    <div class="container">
  <div id="name-form">
    <h3>Inserisci il nuovo nome</h3>
    <fieldset>
      <form name="form1" id="form1" action="/changeShieldName.php" method="get">
	<input type="hidden" name="mac" value="<?php echo $_REQUEST['mac']; ?>">
        <input type="text" name="shield_name">
       <input type="button" value="Salva" onClick='if(document.form1.shield_name.value!="") document.form1.submit()'>
      </form>
    </fieldset>
  </div>
</div>
</body>
</html>


