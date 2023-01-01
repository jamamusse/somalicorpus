/**
 *    Mine is developped by Jama Musse Jama
 */
var httpObject = null;
var httpObjectG = null;
var secondswaiting = 0;

var lastConcept = null;
	
/* START 2023 development */

/**
 * this is for Cushitic Corpus - Omo-Tana family - functions
 */
 function getDSForConcept(concept){
 	const d = {
  chart: {
    caption: "Concept identified: " + concept,
    xaxisminvalue:   "0",
    xaxismaxvalue:   "100",
    yaxisminvalue:   "0",
    yaxismaxvalue:   "100",
    theme:           "candy",
    basefontsize:    "11",
    plothovereffect: "0"
  },
  dataset: [
    {
      data: [
        {
          id: "N0",
          x: "50",
          y: "45",
          alpha: "0",
          name: "Concepts",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "50",
          imagewidth: "50",
          imageurl: "images/globe.png"
        },
        {
          id: "N1",
          x: "52",
          y: "83",
          alpha: "0",
          label: concept,
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40"
        }
      ]
    }
  ],
  connectors: [
    {
      stdthickness: "2",
      connector: [
        {
          from: "N0",
          to: "N1",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        }                
      ]
    }
  ]
};	
 	
 	return d; 
}

function setOutputdConceptContent() {
    if(httpObject.readyState == 4){
        if (httpObject.responseText){
            setInnerHTML('describeConcept', httpObject.responseText);
        } else {
            setInnerHTML('describeConcept', 'Failed here: getConceptConent');           
        }
    }
}
function setOutputdConceptGraph() {
    if(httpObjectG.readyState == 4){
        if (httpObjectG.responseText){
//            setInnerHTML('describeConcept', httpObject.responseText);
//            alert('From graph ' + httpObjectG.responseText);
        } else {
            setInnerHTML('onto-chart-container', 'Failed here: getConceptGraph');  
        }
	var dataSource = getDSForConcept(concept);
	var myChart = new FusionCharts({
		type: "dragnode",
		renderAt: "onto-chart-container",
		width: "100%",
		height: "87%",
		dataFormat: "json",
		dataSource
	  }).render();	
        
    }
}

function showConcept(concept, cId) {
	var info = 'Loading ... ' + concept;
	setInnerHTML('onto-chart-container', info);

	var strQ = '?op=showConcept&formrequest=JSContent&concept=' + concept;
    setInnerHTML('describeConcept', info);
    httpObject = getHTTPObject();
    secondswaiting = 0;
    if (httpObject != null) {
        httpObject.open("POST", 'index.php'+strQ, true);
        httpObject.onreadystatechange = setOutputdConceptContent;
        httpObject.send(null); 
    }
    var vNode = document.getElementById(cId);
	vNode.style.backgroundColor = "red";
	
 	if (lastConcept != null){
 		vNode = document.getElementById(lastConcept);
 		vNode.style.backgroundColor="buttonface"; 
 	}
    lastConcept = cId;
	var strQ2 = '?op=showConcept&formrequest=JSGraph&concept=' + concept;
    httpObjectG = getHTTPObject();
    secondswaiting = 0;
    if (httpObjectG != null) {
        httpObjectG.open("POST", 'index.php'+strQ2, true);
        httpObjectG.onreadystatechange = setOutputdConceptGraph;
        httpObjectG.send(null); 
    } else {
    	alert ("failed here: showConcept" + concept);
    }

	return false;
}

function goConcept(concept, cId) {
	lastConcept = cId;
	document.getElementById("op").value = 'showConcept';
	document.getElementById("concept").value = concept;
	document.getElementById("form_search").submit();
		
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
        } else {
        	alert ('no ' + sID);
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

function describeConcept(concept, cId){
    var desc = '<div class="bar">' +
	             '<span class="lemma">Concept ID:' + cId + ' - ' + concept + '</span>' +
  			   '</div>' +
  			   '<div class="def">' + concept + '</div>';

    var vNode = document.getElementById(cId);
	vNode.style.backgroundColor = "red";
	
 	if (lastConcept != null){
 		vNode = document.getElementById(lastConcept);
 		vNode.style.backgroundColor="buttonface"; 
 	}
    lastConcept = cId;
  		
	return desc;
}

