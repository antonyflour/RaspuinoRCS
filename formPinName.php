<?php 
	include_once 'functionCheckLogin.php';

	$code_login = login_check($mysqli);	
	if($code_login <1) {
        	header('Location: /index.php');
	}

	$mac = $_REQUEST['mac'];
?>
<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <title>Modifica Nomi Pin</title>
        <link rel="stylesheet" href="css/style_form_pin_name.css">  
  </head>
  <body>
    <div class="container" align=center>
  <div id="name-form">
    <h3>Inserisci il nuovo nome</h3>
    <fieldset>
      <form name="form1" id="form1" action="/changePinName.php" method="post">
      <input type="hidden" name="mac" value="<?php echo $mac ?>">
      	<table>
        <?php	
		 if ($stmt = $mysqli->prepare("SELECT pin_number FROM pins WHERE mac_shield = ? ORDER BY pin_number ASC;")) {
			$stmt->bind_param("s",$mac);
        		if($stmt->execute()){   
        			$stmt->store_result();
				 if ($stmt->num_rows >0) {
					$stmt->bind_result($numero_pin);
					while($stmt->fetch()){
            					echo "<tr><td>Pin ".$numero_pin."<td><input type=\"text\" name=\"namepin".$numero_pin."\">";
            				}
				}
				else{
					echo "<tr><td>1.Impossibile recuperare i pin dal database";
				}
			}
			else{
				echo "<tr><td>2.Impossibile recuperare i pin dal database";
			}
		}
		else{
			echo "<tr><td>3.Impossibile recuperare i pin dal database";
		}
        ?>
        </table>
        <input type="button" value="Salva" onClick='document.form1.submit()'>
      </form>
    </fieldset>
  </div>
</div>
</body>
</html>


