function validarComponente() {
   
 
    var nombre = document.getElementById('nombreInput').value;
 
    var fecha = document.getElementById('fechaInput').value;
    var lugar = document.getElementById('lugarInput').value;
    var biografia = document.getElementById('biografiaInput').value;
    var foto = document.getElementById('fotoInput').value;

    var errores = "Errores: ";
    var resultado = false;

    /*
		Comprobar nombre
	*/
    var regEx = /^[A-Za-zÁ-Úá-ú -]+$/;    
    if(nombre == ''){
    	errores = errores.concat("\nDebe introducir un nombre ");
    	resultado = false;
    }else if(!nombre.match(regEx)){
    	errores = errores.concat("\nDebe introducir un nombre válido");
    	resultado = false;
    }
    
    /*
		Comprobar fecha
    */
    regEx = /^\d{4}-\d{2}-\d{2}$/;
    if(fecha == ''){
    	errores = errores.concat("\nDebe introducir una fecha de nacimiento ");
       	resultado = false;
    }else if(!fecha.match(regEx)){
    	errores = errores.concat("\nDebe introducir una fecha de nacimiento válida ");
    	resultado = false;
    }

    /*
		Comprobar lugar de nacimiento
	*/
	regEx = /^[A-Za-zÁ-Úá-ú -.,]+$/;
	if(lugar ==''){
    	errores = errores.concat("\nDebe introducir un lugar de nacimiento ");
    	resultado = false;
    }else if(!biografia.match(regEx)){
    	errores = errores.concat("\nDebe introducir un lugar de nacimiento válid0");
    	resultado = false;
    }

    /*
		Comprobar biografia 
    */
    if(biografia == ''){
    	errores = errores.concat("\nDebe introducir una biografia ");
    	resultado = false;
    }else if(!biografia.match(regEx)){
    	errores = errores.concat("\nDebe introducir una biografia válida");
    	resultado = false;
    }


    /*
		Comprobar foto
    */
    if(foto == ''){
    	errores = errores.concat("\nDebe introducir una foto ");
    	resultado = false;
    }

	
	alert(errores);

    return resultado;
}