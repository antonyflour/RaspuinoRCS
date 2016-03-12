function ValidateIPPort(inputTextIP, inputTextPort)  
 {  
 var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;  
 if(inputTextIP.value.match(ipformat))  {
 	if(!isNaN(inputTextPort.value) &&  inputTextPort.value>0 && inputTextPort.value<65534){
        document.getElementById("form1").submit();
    }
    else{
    	alert("Inserisci un numero di porta valido!");
        document.form1.port.focus();
    }
 }  
 else  {  
 alert("Inserisci un indirizzo IP valido!");  
 document.form1.ip.focus();
 }  
 }  
