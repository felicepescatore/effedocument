// -----------------------------------------------------------------------------
// Generic Form Validation
//
// Copyright (C) 2000 Jacob Hage - [jacobhage@hotmail.com]
// Distributed under the terms of the GNU Library General Public License
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// Initializing script  - setting global variables
// -----------------------------------------------------------------------------
var checkObjects		= new Array(); 	// Array containing the objects to validate.
var errors				= ""; 			// Variable holding the error message.
var returnVal			= false; 		// General return value. The validated form will only be submitted if true.
var language			= new Array(); 	// Language independent error messages!
var selectecLanguage	= "italian";	// Choose between "english", "danish", "dutch", "french", "spanish", "russian", "portuguese"
language.italian		= new Array();
language.english		= new Array();
language.danish			= new Array();
language.dutch			= new Array();
language.french			= new Array();
language.spanish		= new Array();
language.russian		= new Array();
language.portuguese		= new Array();
language.swedish		= new Array();
language.polish			= new Array();
language.brazport		= new Array(); // Brazilian Portuguese

// Error messages in italian:
	language.italian.header		= "Si sono presentati i seguenti errori:"
	language.italian.start		= "->";
	language.italian.field		= " Il Campo ";
	language.italian.require	= " Ë obbligatorio";
	language.italian.min		= " e deve contenere minimo ";
	language.italian.max		= " e massimo ";
	language.italian.minmax		= " e non pi˘ di ";
	language.italian.chars		= " caratteri";
	language.italian.num		= " e deve contenere numeri";
	language.italian.email		= " deve contenere un indirizzo e-mail vaido";
	
// Error messages in english:
	language.english.header		= "The following error(s) occured:"
	language.english.start		= "->";
	language.english.field		= " Field ";
	language.english.require	= " is required";
	language.english.min		= " and must consist of at least ";
	language.english.max		= " and must not contain more than ";
	language.english.minmax		= " and no more than ";
	language.english.chars		= " characters";
	language.english.num		= " and must contain a number";
	language.english.email		= " must contain a valid e-mail address";
	
// Error messages in Danish:
	language.danish.header		= "Der opstod f\370lgende fejl:";
	language.danish.start		= "->";
	language.danish.field		= " Feltet ";
	language.danish.require		= " skal udfyldes";
	language.danish.min			= " og skal best\345 af mindst ";
	language.danish.max			= " og m\345 ikke best\345 af flere end ";
	language.danish.minmax		= " og ikke flere " // English: " and no more than ";
	language.danish.chars		= " tegn";
	language.danish.num			= " og m\345 kun best\345 af tal";
	language.danish.email		= " skal indeholde en korrekt e-mail addresse";
	
// Error messages in Dutch: 
	language.dutch.header		= "De volgende fout(en) zitten in het formulier:"
	language.dutch.start		= "->";
	language.dutch.field		= " Veld ";
	language.dutch.require		= " is verplicht";
	language.dutch.min			= " en moet bestaan uit minstens";
	language.dutch.max			= " en moet bestaan uit meer dan";
	language.dutch.minmax		= " en niet meer dan";
	language.dutch.chars		= " karakters";
	language.dutch.num			= " en moet een nummer zijn";
	language.dutch.email		= " moet een geldig e-mail adres zijn.";

// Error messages in French: 
	language.french.header		= "L'erreur suivante s'est produite: "
	language.french.start		= "->";
	language.french.field		= " Le champs ";
	language.french.require		= " est obligatoire";
	language.french.min			= " et doit contenir au moins ";
	language.french.max			= " et ne doit pas contenir plus de ";
	language.french.minmax		= " et pas plus de ";
	language.french.chars		= " caract\350res";
	language.french.num			= " et doit contenir un nombre ";
	language.french.email		= " doit contenir une adresse e-mail valide";

// Error messages in Spanish: 
	language.spanish.header		= "Se ha producido un error:"
	language.spanish.start		= "->";
	language.spanish.field		= " El campo ";
	language.spanish.require	= " es obligatorio";
	language.spanish.min		= " y debe contener al menos ";
	language.spanish.max		= " y no debe contener m\341s de ";
	language.spanish.minmax		= " y no m\341s de ";
	language.spanish.chars		= " caracteres";
	language.spanish.num		= " y debe contener un n\372mero";
	language.spanish.email		= " debe contener una direcci\363n de e-mail v\341lida";
	
// Error messages in russian: 
	language.russian.header		= " ¬ÓÁÌËÍÎ‡ Œ¯Ë·Í‡(Ë):"
	language.russian.start		= "->";
	language.russian.field		= " œÓÎÂ ";
	language.russian.require	= " Ó·ˇÁ‡ÚÂÎ¸ÌÓ";
	language.russian.min		= " Ë ‰ÓÎÊÌÓ ÒÓ‰ÂÊ‡Ú¸ ÌÂ ÏÂÌÂÂ ";
	language.russian.max		= " Ë ÌÂ ‰ÓÎÊÌÓ ÒÓ‰ÂÊ‡Ú¸ ·ÓÎÂÂ ";
	language.russian.minmax		= " Ë ÌÂ ·ÓÎÂÂ ";
	language.russian.chars		= " ÁÌ‡ÍÓ‚";
	language.russian.num		= " Ë ‰ÓÎÊÌÓ ÒÓ‰ÂÊ‡Ú¸ ˜ËÒÎÓ‚ÓÂ ÁÌ‡˜ÂÌËÂ";
	language.russian.email		= " ‰ÓÎÊÌÓ ÒÓ‰ÂÊ‡Ú¸ ‰ÂÈÒÚ‚ËÚÂÎ¸Ì˚È e-mail ‡‰ÂÒ";
	
// Error messages in portuguese: 
	language.portuguese.header	= "O(s) seguinte(s) erro(s) ocorreu(am):"
	language.portuguese.start	= "->";
	language.portuguese.field	= " Campo ";
	language.portuguese.require	= " e' necessario";
	language.portuguese.min		= " e deve conter pelo menos ";
	language.portuguese.max		= " e nao deve conter mais de ";
	language.portuguese.minmax	= " e nao mais que ";
	language.portuguese.chars	= " caracteres";
	language.portuguese.num		= " e deve conter numero";
	language.portuguese.email	= " deve conter um e-mail valido";

// Error messages in Swedish: 
	language.swedish.header		= "Följande fel uppstod:";
	language.swedish.start		= "->";
	language.swedish.field		= " Fältet ";
	language.swedish.require	= " måste fyllas i";
	language.swedish.min		= " och skall bestå av minst ";
	language.swedish.max		= " och skall inte bestå av fler än ";
	language.swedish.minmax		= " och inte fler än ";
	language.swedish.chars		= " tecken";
	language.swedish.num		= " och måste innehålla ett nummer";
	language.swedish.email		= " måste innehålla en korrekt epost adress";

// Error messages in polish: 
	language.polish.header		= "Wystπpi≥ nastÍpujπcy b≥πd(b≥Ídy):"
	language.polish.start		= "* ";
	language.polish.field		= " Pole <";
	language.polish.require		= "> jest wymagane";
	language.polish.min			= " i musi zawieraÊ conajmniej ";
	language.polish.max			= " i nie moøe zawieraÊ wiÍcej niø ";
	language.polish.minmax		= " i nie wiÍcej niø ";
	language.polish.chars		= " znaki";
	language.polish.num			= " i musi zawieraÊ liczbÍ";
	language.polish.email		= " musi zawieraÊ prawid≥owy adres e-mail";

// Error messages in brazilian portuguese: 
	language.brazport.header	= "O(s) seguinte(s) erro(s) ocorreu(ram):"
	language.brazport.start		= "->";
	language.brazport.field		= " O campo ";
	language.brazport.require	= " È obrigatÛrio";
	language.brazport.min		= " e deve ser composto de no mÌnimo por ";
	language.brazport.max		= " e n„o deve conter mais de ";
	language.brazport.minmax	= " e n„o mais de ";
	language.brazport.chars		= " caracteres";
	language.brazport.num		= " e deve conter um n˙mero";
	language.brazport.email		= " deve conter um endereÁo de e-mail v·lido";

// -----------------------------------------------------------------------------
// define - Call this function in the beginning of the page. I.e. onLoad.
//
// n = name of the input field (Required)
// type= string, num, email (Required)
// min = the value must have at least [min] characters (Optional)
// max = the value must have maximum [max] characters (Optional)
// d = (Optional)
// -----------------------------------------------------------------------------
function define(n,type,HTMLname,min,max,d){
	var p;
	var i;
	var x;
	if(!d) d=document;
	if((p=n.indexOf("?"))>0&&parent.frames.length){
    	d=parent.frames[n.substring(p+1)].document;
    	n=n.substring(0,p);
    }
	if(!(x=d[n])&&d.all) x=d.all[n];
	
  	for (i=0;!x&&i<d.forms.length;i++){
  		x=d.forms[i][n];
  	}
	for(i=0;!x&&d.layers&&i<d.layers.length;i++){
		x=define(n,type,HTMLname,min,max,d.layers[i].document);
		return x;		
	}
	
	// Create Object. The name will be "V_something" where something is the "n" parameter above.
	eval("V_"+n+" = new formResult(x,type,HTMLname,min,max);");
	checkObjects[eval(checkObjects.length)] = eval("V_"+n);
}

// -----------------------------------------------------------------------------
// formResult - Used internally to create the objects
// -----------------------------------------------------------------------------
function formResult(form,type,HTMLname,min,max){
	this.form = form;
	this.type = type;
	this.HTMLname = HTMLname;
	this.min  = min;
	this.max  = max;
}

// -----------------------------------------------------------------------------
// validate - Call this function onSubmit and return the "returnVal". (onSubmit="validate();return returnVal;")
// -----------------------------------------------------------------------------
function validate(){
	if(checkObjects.length>0){
		errorObject = "";
	
		for(i=0;i<checkObjects.length;i++){
			validateObject 			= new Object();
			validateObject.form 	= checkObjects[i].form;
			validateObject.HTMLname = checkObjects[i].HTMLname;
			validateObject.val 		= checkObjects[i].form.value;
			validateObject.len 		= checkObjects[i].form.value.length;
			validateObject.min 		= checkObjects[i].min;
			validateObject.max 		= checkObjects[i].max;
			validateObject.type 	= checkObjects[i].type;
			
			//Debug alert line
			//alert("validateObject: "+validateObject+"\nvalidateObject.val: "+validateObject.val+"\nvalidateObject.len: "+validateObject.len+"\nvalidateObject.min,validateObject.max: "+validateObject.min+","+validateObject.max+"\nvalidateObject.type: "+validateObject.type);
			
			// Checking input. If "min" and/or "max" is defined the input has to be within the specific range
			if(validateObject.type == "num" || validateObject.type == "string"){
				if((validateObject.type == "num" && validateObject.len <= 0) || (validateObject.type == "num" && isNaN(validateObject.val))){errors+=language[selectecLanguage].start+language[selectecLanguage].field+validateObject.HTMLname+language[selectecLanguage].require+language[selectecLanguage].num+"\n";
				} else if (validateObject.min && validateObject.max && (validateObject.len < validateObject.min || validateObject.len > validateObject.max)){errors+=language[selectecLanguage].start+language[selectecLanguage].field+validateObject.HTMLname+language[selectecLanguage].require+language[selectecLanguage].min+validateObject.min+language[selectecLanguage].minmax+validateObject.max+language[selectecLanguage].chars+"\n";
				} else if (validateObject.min && !validateObject.max && (validateObject.len < validateObject.min)){errors+=language[selectecLanguage].start+language[selectecLanguage].field+validateObject.HTMLname+language[selectecLanguage].require+language[selectecLanguage].min+validateObject.min+language[selectecLanguage].chars+"\n";
				} else if (validateObject.max && !validateObject.min &&(validateObject.len > validateObject.max)){errors+=language[selectecLanguage].start+language[selectecLanguage].field+validateObject.HTMLname+language[selectecLanguage].require+language[selectecLanguage].max+validateObject.max+language[selectecLanguage].chars+"\n";
				} else if (!validateObject.min && !validateObject.max && validateObject.len <= 0){errors+=language[selectecLanguage].start+language[selectecLanguage].field+validateObject.HTMLname+language[selectecLanguage].require+"\n";
				}
			} else if(validateObject.type == "email"){
				// Checking existense of "@" and ".". The length of the input must be at least 5 characters. The "." must neither be preceding the "@" nor follow it.
				if((validateObject.val.indexOf("@") == -1) || (validateObject.val.charAt(0) == ".") || (validateObject.val.charAt(0) == "@") ||(validateObject.len < 6) || (validateObject.val.indexOf(".") == -1) || (validateObject.val.charAt(validateObject.val.indexOf("@")+1) == ".") || (validateObject.val.charAt(validateObject.val.indexOf("@")-1) == ".")){errors+=language[selectecLanguage].start+language[selectecLanguage].field+validateObject.HTMLname+language[selectecLanguage].email+"\n";}
			} else if(validateObject.type == "cf_pi"){
				//check codice fiscale e partita iva
				var cf = validateObject.val;
				var validi, i, s, set1, set2, setpari, setdisp;
				var perror_cf='';
				var perror_pi='';
				if( cf == '' )  perror_cf= "-> I Codice Fiscale Ë obbligatorio\n";
				else {
					cf = cf.toUpperCase();
					if( cf.length != 16 && perror_cf=='')
						perror_cf= "-> La lunghezza del Codice Fiscale non Ë corretta: il codice fiscale dovrebbe essere lungo esattamente 16 caratteri.\n";
					validi = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
					for( i = 0; i < 16; i++ ){
						if( validi.indexOf( cf.charAt(i) ) == -1 && perror_cf=='')
							perror_cf= "-> Il Codice Fiscale contiene uno o pi˘ caratteri non validi\n";
					}
					set1 = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					set2 = "ABCDEFGHIJABCDEFGHIJKLMNOPQRSTUVWXYZ";
					setpari = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					setdisp = "BAKPLCQDREVOSFTGUHMINJWZYX";
					s = 0;
					for( i = 1; i <= 13; i += 2 )
						s += setpari.indexOf( set2.charAt( set1.indexOf( cf.charAt(i) )));
					for( i = 0; i <= 14; i += 2 )
						s += setdisp.indexOf( set2.charAt( set1.indexOf( cf.charAt(i) )));
					if( s%26 != cf.charCodeAt(15)-'A'.charCodeAt(0) )
						if (perror_cf=='')
							perror_cf= "-> Il Codice Fiscale non Ë corretto: il codice di controllo non corrisponde.\n";
				}
				
				if (perror_cf!=''){
					var pi=cf;
					
					if( pi == '' )  perror_pi= "-> Il Codice Fiscale/Partita Iva Ë obbligatorio\n";
					else{
						if( pi.length != 11 )
							perror_pi= "-> Il Codice Fiscale o Partita Iva non sono corretti.\n" ;
						validi = "0123456789";
						for( i = 0; i < 11; i++ ){
							if( validi.indexOf( pi.charAt(i) ) == -1 && perror_pi=='')
								perror_pi= "-> Il Codice Fiscale o Partita Iva non sono corretti.\n";
						}
						s = 0;
						for( i = 0; i <= 9; i += 2 )
							s += pi.charCodeAt(i) - '0'.charCodeAt(0);
						for( i = 1; i <= 9; i += 2 ){
							c = 2*( pi.charCodeAt(i) - '0'.charCodeAt(0) );
							if( c > 9 )  c = c - 9;
							s += c;
						}
						if( ( 10 - s%10 )%10 != pi.charCodeAt(10) - '0'.charCodeAt(0) )
							if (perror_pi=='')
								perror_pi= "-> Il Codice Fiscale o Partita Iva non sono corretti.\n";
					}
				}
				errors+=perror_pi;
			}
		}
	}
	// Used to set the state of the returnVal. If errors -> show error messages in chosen language
	if(errors){
		alert(language[selectecLanguage].header.concat("\n"+errors));
		errors = "";
		returnVal = false;
	} else {
		returnVal = true;
	}
}
