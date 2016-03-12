function sendnewpass(form, oldpass, pass1, pass2) {
    // Create a new element input, this will be our hashed password field. 
    if (oldpass.value!='') {
      if (pass1.value==pass2.value) {
        // Add the new element to our form.
        oldpass.value=hex_sha512(oldpass.value);
        var p = document.createElement("input");
        p.name = "pass";
        p.type = "hidden";
        p.value = hex_sha512(pass1.value);
        form.appendChild(p); // added this
        // Make sure the plaintext password doesn't get sent. 
        // Finally submit the form. 
        form.submit();
      }
      else{
        alert('Le due password devono essere uguali!');
      }
    }
    else{
      alert('La vecchia password non può essere vuota!');
    }

}
