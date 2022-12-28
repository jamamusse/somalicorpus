/**
 * Mine is developped by Jama Musse Jama
 */


var httpObject = null;
var httpObjectFra = null;
var secondswaiting = 0;
var currentLangId = 'maskMineResultEng';
	
var plusIm = new Image();
//plusIm.src = "images/piu.png";

var minusIm = new Image();
//minusIm.src = "images/meno.png";

function rotatePlusMinus (idSiteImg){
  if (idSiteImg.src == 'http://trame.fefonlus.it/trame/images/piu.png'){
     idSiteImg.src = minusIm.src;
  } else {
     idSiteImg.src = plusIm.src;
  }
  //alert(idSiteImg.src);
  return true;
}

/* START 2023 development */

/**
 * this is for Cushitic Corpus - Omo-Tana family - functions
 */
function showConcept(concept) {
	alert (concept);
	return false;
}

/* END 2023 development */


/**
 * Sets "innerHTML" Property to given HTML String for the node with the given
 * id.
 * 
 * @param {String}
 *            sID id of the node of which to set innerHTML
 * @param {String}
 *            sHTML new HTML Contents
 * @return {Boolean} true if applied, otherwise false
 */

function setInnerHTML(sID, sHTML) {
    var bRes = false;
    try {
        var vNode = document.getElementById(sID);
        if (vNode) {
            if (vNode.viewNode) {
                vNode = vNode.viewNode;
            }
        }
        if (typeof (sHTML) == 'string' && vNode) {
            if ((sHTML.search(/\.*<e:.*/) < 0)
                    && (sHTML.search(/.*\<b:.*/) < 0)
                    && (sHTML.search(/.*\<c:.*/) < 0)
                    && (sHTML.search(/.*\<mm:.*/) < 0)) {
                vNode.innerHTML = sHTML;
                bRes = true;
            }
        } else {
            alert('no');
            if (typeof (sHTML) == 'string'){alert('due no');}
        }
    } catch (exsih) {
        bRes = false;
        alert("ERROR during setInnerHTML()");
    }
    return bRes;
}

function doCheckAll(){
  with (document.formFIRB) {
    for (var i=0; i < elements.length; i++) {
        if (elements[i].type == 'checkbox' && elements[i].name == 'dbChecker')
           elements[i].checked = true;
    }
  }
  setInnerHTML('resultSet', "Selezionati tutti siti del elenco completo");
  return false;
}

function doUnCheckAll(){
  with (document.formFIRB) {
    for (var i=0; i < elements.length; i++) {
        if (elements[i].type == 'checkbox' && elements[i].name == 'dbChecker')
            elements[i].checked = false;
        }
    }
  setInnerHTML('resultSet', "deselezionati tutti i siti del elenco completo");
  return false;
}

// Get the HTTP Object
function getHTTPObject(){
   if (window.ActiveXObject) 
       return new ActiveXObject("Microsoft.XMLHTTP");
   else if (window.XMLHttpRequest) 
       return new XMLHttpRequest();
   else {
      alert("Your browser does not support AJAX.");
      return null;
   }
}


function checkFieldsBeforeSubmit(){
    oneField = false;
    oneDb = false;
    with (document.formFIRB) {
        for (var i=0; i < elements.length; i++) {
            if (!oneField && (elements[i].name == 'Field0' || elements[i].name == 'Field1' || elements[i].name == 'Field2' || elements[i].name == 'Field3' || elements[i].name == 'Field4' ||  elements[i].name == 'Field41' ||  elements[i].name == 'Field42' ||
                    elements[i].name == 'Field5' || elements[i].name == 'Field6' || elements[i].name == 'Field7')){
                v = elements[i].value;
                v.replace(/^\s+|\s+$/g,"");
                if (v.length > 0){
                    oneField =  true;
                }
            }
            if (elements[i].name == 'dbChecker' &&  elements[i].checked){
               oneDb = true;
            }
        }
        if(!oneDb){
           alert("Selezionare almeno un db su cui fare la ricerca");
           return false;
        }
        if (oneField && oneDb){
          return true;
        }
    }
    alert("Inserisci un valore da ricercare almeno in un campo");
    return false;
}

function buildQueryString (){
    strQ = "op=search";
    dbs = "";
    maxnum=10;
    with (document.formFIRB) {
        for (var i=0; i < elements.length; i++) {
            if (elements[i].name == 'Field0' || elements[i].name == 'Field1' || elements[i].name == 'Field2' || elements[i].name == 'Field3' || elements[i].name == 'Field4' || elements[i].name == 'Field41' || elements[i].name == 'Field42'  ||
                    elements[i].name == 'Field5' || elements[i].name == 'Field6' || elements[i].name == 'Field7' ||  elements[i].name == 'Field8'){
                strQ += "&" + elements[i].name + "=" + elements[i].value;
            } else if (elements[i].name == 'dbChecker' &&  elements[i].checked){
                dbs += (dbs ? "|" : "") + elements[i].value;
            } else if (elements[i].name == 'dbMaxNumSchede' && elements[i].value > 0){
                maxnum = elements[i].value;
            }   
        } 
    }
    strQ += "&dbs=" + dbs + "&maxnum=" + maxnum;
    return strQ;
}



// Implement business logic

function doRealSubmit(strQ){    
    info = "<object width=\"750\" height=\"60\"><param name=\"movie\" value=\"/trame/images/firb-banner.swf\"><embed src=\"/firb/images/firb-banner.swf\" width=\"750\" height=\"60\"></embed></object>";
    info = '<img src=\"images/stiamo_cercando.gif\">';
    info = '<img src=\"images/loading.gif\">';
    info = 'Loading...';
    	
   // setInnerHTML('resultSet', 'ok'); return false;
    setInnerHTML('dialogContent', info);
    httpObject = getHTTPObject();
    secondswaiting = 0;
    if (httpObject != null) {
//        strQ = buildQueryString();
        httpObject.open("POST", 'index.php'+strQ, true);
        httpObject.onreadystatechange = setOutput;
        httpObject.send(null); 
    }
    return false;
}

// Change the value of the outputText field

function setOutput(){
    if(httpObject.readyState == 4){
//        alert(httpObject.responseText);
        if (httpObject.responseText){
            setInnerHTML('dialogContent', httpObject.responseText);
        } else {
            setInnerHTML('dialogContent', 'Failed here.');           
        }
    }
}


function OnOffMask(id){
 if (document.getElementById){
	obj = document.getElementById(id);
	obj.style.width = '75%';
	obj.style.height = '75%';
	l = screen.width * 0.125 + 'px';
	t = screen.height * 0.125 + 'px';
	t = '60px';
	obj.style.left = l;
	obj.style.top = t;
	if (obj.style.display == '' || obj.style.display == "none"){
		obj.style.display = "inline";
	} else {
		obj.style.display = "none";
	}
 }
}

function showMeDoc(docinfo, docid, parid){
	var divid = 'maskMineDoc';
    var strQ = 'index.php?op=getParagraph&did='+docid+'&parid='+parid;
    var res  = '';
	 if (document.getElementById){
		obj = document.getElementById(divid);
		if(obj){
		    httpObjectEng = getHTTPObject();
		    secondswaiting = 0;
		    if (httpObjectEng != null) {
		    	httpObjectEng.open("POST", strQ, false);
		    	httpObjectEng.send(null);
		    	res = httpObjectEng.responseText;
		    } else {
		        res = 'Waayay';    	
		    }			
			alert(docinfo+'\n\n'+res);
		} else {
			alert('failed');
		}
	 } else {
		 alert (docid);
	 }
}


function searchLanguageMe(){
	var result = '';
	if (document.getElementById){
		var eng = document.getElementById("engword").value;
		var ita = document.getElementById("itaword").value;
		var fra = document.getElementById("fraword").value;
		var swe = document.getElementById("sweword").value;
		// annulla every thing
		setInnerHTML('maskMineResultEng', '');
		setInnerHTML('maskMineResultIta', '');
		setInnerHTML('maskMineResultFra', '');
		setInnerHTML('maskMineResultSwe', '');
		
		if (eng){
			currentLangId = 'maskMineResultEng';
			result  = "You asked " + eng + " .... I am searching ....";
			setInnerHTML(currentLangId, result);
			doRealSearchEng('?op=searchlang&l=eng&q='+eng, result, currentLangId)
		} else {
//			alert ('Ops - eng');
		}
		if (ita){
			currentLangId = 'maskMineResultIta';
			result  = "hai chiesto " + ita + " .... sto cercando ....";
			setInnerHTML(currentLangId, result);
			doRealSearchIta('?op=searchlang&l=ita&q='+ita, result, currentLangId)		}
		if (fra){
			currentLangId = 'maskMineResultFra';
			result = "vous avez demand� " + fra + " .... je suis � la recherche d' ....";
			setInnerHTML(currentLangId, result);
			doRealSearchFra('?op=searchlang&l=fra&q='+fra, result, currentLangId)			
		}
		if (swe){
			currentLangId = 'maskMineResultSwe';
			result = "yoou asked in swe " + swe + " .... sto cercando ....";
			setInnerHTML(currentLangId, result);
			doRealSearchSwe('?op=searchlang&l=swe&q='+swe, result, currentLangId)			
		}
		if (!eng && !ita && !eng && !swe){
			result = 'insert word | inserisci una parola | entrez un mot | geli erey afafka mid ahaan.';
		}
	}
}

function setOutputLangEng(){
	mask = 'maskMineResultEng';
    if(httpObjectEng.readyState == 4){
        if (httpObjectEng.responseText){
            setInnerHTML(mask, httpObjectEng.responseText);
        } else {
//            setInnerHTML(mask, 'Failed Eng');           
        }
    }
}
function setOutputLangIta(){
	mask = 'maskMineResultIta';
    if(httpObjectIta.readyState == 4){
        if (httpObjectIta.responseText){
            setInnerHTML(mask, httpObjectIta.responseText);
        } else {
//            setInnerHTML(mask, 'Failed Ita');           
        }
    }
}
function setOutputLangFra(){
	mask = 'maskMineResultFra';
    if(httpObjectFra.readyState == 4){
        if (httpObjectFra.responseText){
            setInnerHTML(mask, httpObjectFra.responseText);
        } else {
//            setInnerHTML(mask, 'Failed Fra');           
        }
    }
}

function setOutputLangSwe(){
	mask = 'maskMineResultSwe';
    if(httpObjectSwe.readyState == 4){
        if (httpObjectSwe.responseText){
            setInnerHTML(mask, httpObjectSwe.responseText);
        } else {
//            setInnerHTML(mask, 'Failed Swe');           
        }
    }
}

function doRealSearchEng(strQ, strT, idMask){    
    info = strT;
    deb = 'index.php'+strQ;
    setInnerHTML(idMask, info);
    httpObjectEng = getHTTPObject();
    secondswaiting = 0;
    if (httpObjectEng != null) {
    	httpObjectEng.open("POST", 'index.php'+strQ, true);
    	httpObjectEng.onreadystatechange = setOutputLangEng;        	
    	httpObjectEng.send(null); 
    } else {
//        setInnerHTML(idMask, 'Hellooooo');    	
    }
    return false;
}


function doRealSearchIta(strQ, strT, idMask){    
    info = strT;    	
   // setInnerHTML('resultSet', 'ok'); return false;
    setInnerHTML(idMask, info);
    httpObjectIta = getHTTPObject();
    secondswaiting = 0;
    if (httpObjectIta != null) {
    	httpObjectIta.open("POST", 'index.php'+strQ, true);
    	httpObjectIta.onreadystatechange = setOutputLangIta;        	
    	httpObjectIta.send(null); 
    }
    return false;
}

function doRealSearchFra(strQ, strT, idMask){    
    info = strT;    	
   // setInnerHTML('resultSet', 'ok'); return false;
    setInnerHTML(idMask, info);
    httpObjectFra = getHTTPObject();
    secondswaiting = 0;
    if (httpObjectFra != null) {
    	httpObjectFra.open("POST", 'index.php'+strQ, true);
    	httpObjectFra.onreadystatechange = setOutputLangFra;        	
    	httpObjectFra.send(null); 
    }
    return false;
}

function doRealSearchSwe(strQ, strT, idMask){    
    info = strT;    	
    setInnerHTML(idMask, info);
    httpObjectSwe = getHTTPObject();
    secondswaiting = 0;
    if (httpObjectSwe != null) {
    	httpObjectSwe.open("POST", 'index.php'+strQ, true);
    	httpObjectSwe.onreadystatechange = setOutputLangSwe;        	
    	httpObjectSwe.send(null); 
    }
    return false;
}
