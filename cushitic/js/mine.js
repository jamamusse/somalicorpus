/**
 *    Mine is developped by Jama Musse Jama
 */
var httpObject = null;
var httpObjectG = null;
var secondswaiting = 0;

var lastConcept = null;
var currentConcept = null;
	
/* START 2023 development */

function giveT(code, name, image, parent, langs, children){
	var aParent;
	var pcode;
	var pname;
	var pimag;
	var pdElem;
    var codeConnect = code;
	var x = 45;
	if (parent){
		x = 25;
	}

	//if parent - add
	if (parent){
		aParent =  parent.split('_');
		pcode  = aParent[0];
		pname  = aParent[1];
		pimag  = aParent[2];
		pdElem = {
			id: pcode, 
			x: "55", 
			y: "88", 
			alpha: "0", 
			name: pname, 
			radius: "55", 
			shape: "CIRCLE", 
			imagenode: "1", 
			imagealign: "MIDDLE", 
			imageheight: "50", 
			imagewidth: "50", 
			imageurl: "images/" + pimag 
		};
		codeConnect = pcode;	
	}

	var d = { 
chart: { 
	caption: "Concept identified: " + name, 
	xaxisminvalue: "0", 
	xaxismaxvalue: "100", 
	yaxisminvalue: "0", 
	yaxismaxvalue: "100", 
	theme: "candy", 
	basefontsize: "11", 
	plothovereffect: "0" 
	}, 
dataset: [ { 
	data: [ 
		{ 
			id: "N0", 
			x: "86", 
			y: "86", 
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
			id: code, 
			x: x, 
			y: "82", 
			alpha: "0", 
			name: name, 
			radius: "50", 
			shape: "CIRCLE", 
			imagenode: "1", 
			imagealign: "MIDDLE", 
			imageheight: "30", 
			imagewidth: "40", 
			imageurl: "images/"+image
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
				to: codeConnect, 
				color: "#1aaf5d", 
				strength: "1", 
				arrowatstart: "0", 
				arrowatend: "0" 
			} 
		] 
	} 
]

};

	//if parent - add what you have created.
	if (parent){
		d['dataset'][0]['data'].push(pdElem);
		var dConnect = 			{ 
			from: pcode, 
			to: code, 
			color: "#1aaf5d", 
			strength: "1", 
			arrowatstart: "0", 
			arrowatend: "0" 
		};
		d['connectors'][0]['connector'].push(dConnect);		

	}
	
	// if languages - add
	if (children){
		const aChildren = children.split("-");
		var x = 34; 
		var y = 50;
		var t = aChildren.length;

		var r = 38;
		var s = 5;
		var m = r/2;

		x = (t > 5 ? m/2 : m + ((100-r-(t*s))/t)/2);		
		for (var i = 0; i < aChildren.length; i++) {
			const aChild = aChildren[i].split("_");
			var childCode = aChild[0]; 
			var childName = aChild[1]; 
			var childImage = aChild[2]; 
			var dElem = {
				id: childCode, 
				x: x, 
				y: y, 
				alpha: "0", 
				name: childName, 
				radius: r, 
				shape: "CIRCLE", 
				imagenode: "1", 
				imagealign: "MIDDLE", 
				imageheight: "50", 
				imagewidth: "50", 
				imageurl: "images/" + childImage 
			};
			x = x + m - (t > 5 ? 6 : 0);
			d['dataset'][0]['data'].push(dElem);
			
			var dConnect = 			{ 
				from: code, 
				to: childCode, 
				color: "#1aaf5d", 
				strength: "1", 
				arrowatstart: "0", 
				arrowatend: "0" 
			};
			d['connectors'][0]['connector'].push(dConnect);
			const aColors = Array("#1aaf5d", "#E56D40", "#1aaf5d", "#F6F931", "#1aaf5d", "#045AFA", "#1aaf5d", "#000000", "#1aaf5d", "#1aaf5d");
            var color = aColors[i];
			// if languages - add
			if (langs){
				const aLangs = langs.split("-");
				for (var j = 0; j < aLangs.length; j++) {
					var lang = aLangs[j];			
					var dConnect = 			{ 
						from: childCode, 
						to: lang, 
						color: color, 
						strength: "1", 
						arrowatstart: "0", 
						arrowatend: "0" 
					};
					d['connectors'][0]['connector'].push(dConnect);
				}
			}
		}
	}

	// if languages - add
	if (langs){
		const aLangs = langs.split("-");
		var x = 6; y = 25;
		for (var i = 0; i < aLangs.length; i++) {
			var lang = aLangs[i];
			var dElem = {
				id: lang, 
				x: x, 
				y: y, 
				alpha: "0", 
				name: lang, 
				radius: "38", 
				shape: "CIRCLE", 
				imagenode: "1", 
				imagealign: "MIDDLE", 
				imageheight: "50", 
				imagewidth: "50", 
				imageurl: "images/" + lang + ".png" 
			};
			x = x + 14; 
			y = y + (i < 3 ? -5 : 5);
			d['dataset'][0]['data'].push(dElem);
			
			if (!children){
				var dConnect = { 
					from: code, 
					to: lang, 
					color: "#1aaf5d", 
					strength: "1", 
					arrowatstart: "0", 
					arrowatend: "0" 
				};
				d['connectors'][0]['connector'].push(dConnect);
			}
		}
	}

	return d;

}


/**
 * this is for Cushitic Corpus - Omo-Tana family - functions
 */
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
	var dataSource = "";
	var code = "";
	var concept = "";
	var parent = "";
	var image = "";
 	var langs = "";
 	var children = "";
    if(httpObjectG.readyState == 4){
        if (httpObjectG.responseText){
            ds = httpObjectG.responseText;

            const aInfo = ds.split("|");
			code    = aInfo[0];
			concept = aInfo[1];
			parent  = aInfo[2];
			image   = aInfo[3];
			children= aInfo[4];
			langs   = aInfo[5];
        } else {
            setInnerHTML('onto-chart-container', 'Failed here: getConceptGraph');  
        }
        dataSource = giveT(code, concept, image, parent, langs, children);
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
	currentConcept = concept;

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

