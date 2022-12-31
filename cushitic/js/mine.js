/**
 *    Mine is developped by Jama Musse Jama
 */
var httpObject = null;
var httpObjectFra = null;
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
 
function describeConcept(concept, cId){
    var desc = '<div class="bar">' +
	             '<span class="lemma">Concept ID:' + cId + ' - ' + concept + '</span>' +
  			   '</div>' +
  			   '<div class="def">' + concept + '</div>';

    var vNode = document.getElementById(cId);
	vNode.style.background-color="#f44336;";

alert (vNode);
	
// 	if (lastConcept != null){
// 		vNode = document.getElementById(lastConcept);
// 		vNode.style.backgroundColor="buttonface"; 
// 	}
//     lastConcept = cId;
  		
	return desc;
}

function showConcept(concept, cId) {
	var info = 'Loading ... ' + concept;
	setInnerHTML('onto-chart-container', info);

	var infoConcept = describeConcept(concept, cId);
	setInnerHTML('describeConcept', infoConcept);
	
	var dataSource = getDSForConcept(concept);
	var myChart = new FusionCharts({
		type: "dragnode",
		renderAt: "onto-chart-container",
		width: "100%",
		height: "87%",
		dataFormat: "json",
		dataSource
	  }).render();	

	return false;
}

function goConcept(concept, cId) {
	document.getElementById("op").value = 'showConcept';
	document.getElementById("concept").value = concept;
	document.getElementById("form_search").submit();
	
	lastConcept = cId;
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
