function changeState(ip, port, pin, stato){
            	var request = new XMLHttpRequest();
                request.open('GET','changeStatePin.php?ip='+ip+'&port='+port+'&pin='+pin+'&stato='+stato+'&rand='+Math.random(),true);
                request.send(null);
                request.onreadystatechange = function(){
                	if(this.readyState == 4){ 
                    		if(this.status==200){ 
                			location.reload();
                		}
                		else{
                			window.alert("Impossibile cambiare lo stato. Verifica che tu sia loggato");
                		}
                    	}
                }
   
}
