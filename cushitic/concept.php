<?php


function getGraphConcept($concept){
	global $conn;
$chart = "  chart: {
caption: \"Concept identified: " . $concept . "\",
xaxisminvalue:   \"0\",
xaxismaxvalue:   \"100\",
yaxisminvalue:   \"0\",
yaxismaxvalue:   \"100\",
theme:           \"candy\",
basefontsize:    \"11\",
plothovereffect: \"0\"
  }";
$dataset = "  dataset: [
{
  data: [
{
  id: \"N0\",
  x: \"50\",
  y: \"45\",
  alpha: \"0\",
  name: \"Concepts\",
  radius: \"60\",
  shape: \"CIRCLE\",
  imagenode: \"1\",
  imagealign: \"MIDDLE\",
  imageheight: \"50\",
  imagewidth: \"50\",
  imageurl: \"images/globe.png\"
},
{
  id: \"N1\",
  x: \"52\",
  y: \"183\",
  alpha: \"0\",
  name: \"$concept\",
  radius: \"50\",
  shape: \"CIRCLE\",
  imagenode: \"1\",
  imagealign: \"MIDDLE\",
  imageheight: \"30\",
  imagewidth: \"40\"
}
  ]
}
  ]";

  $connectors = "  connectors: [
{
  stdthickness: \"2\",
  connector: [
{
  from: \"N0\",
  to: \"N1\",
  color: \"#1aaf5d\",
  strength: \"1\",
  arrowatstart: \"0\",
  arrowatend: \"0\"
}                
  ]
}
  ]";

	$ret = "{\n$chart,\n$dataset,\n$connectors}";


	return $ret;

}

function getConceptsListMenu(){
	global $conn;
	$ret = "no concepts ready";
	$sql = "SELECT concode, concept FROM rsol_c_concept where concept <> 'Concepts' ORDER BY weight DESC LIMIT 2";
	$res = $conn->query ($sql);
	if ($conn->isResultSet ($res)) {
			$ret = "";
			while ($sRow =  $conn->fetchAssoc($res)){
				$ret .= "<button onclick=\"goConcept('" . $sRow['concept'] . "', '" . $sRow['concode'] . "'); return false;\">" . $sRow['concept'] . "</button> ";
			}
	} else {
		$ret = "Error";
	}
	return $ret;
}

function getConceptsList($concept){
	global $conn;
	$ret = "no concepts ready";
	$sql = "SELECT concode, concept FROM rsol_c_concept where concept <> 'Concepts' ORDER BY concode";
	$res = $conn->query ($sql);
	if ($conn->isResultSet ($res)) {
			$ret = "";
			while ($sRow =  $conn->fetchAssoc($res)){
				$curr = ($sRow['concept'] == $concept? "style=\"background-color: #f44336;\"" : "style=\"background-color: buttonface\"");
				$ret .= "<button id=\"" . $sRow['concode'] . "\" $curr onclick=\"showConcept('" . $sRow['concept'] . "', '" . $sRow['concode'] . "'); return false;\">" . $sRow['concept'] . "</button> ";
			}
	} else {
		$ret = "Error";
	}
	return $ret;
}

function describeConcept($concept, $formrequest){
	global $conn;
	$ret = "Unknown concept";
	if ($formrequest == 'JSGraph'){
		//$result = getGraphConcept($concept);
		$sql = "SELECT concode, concept, parent, image FROM rsol_c_concept where concept = '" . $concept . "'";
		$res = $conn->query ($sql);
		if ($conn->isResultSet ($res)) {
				if ($sRow =  $conn->fetchAssoc($res)){
					$result = $sRow['concode'] . "|" . $sRow['concept'] . "|" . $sRow['parent'] . "|" . $sRow['image'];
				} else {
					$result = "Error|$concept|query";
				}
		} else {
			$result = "Error|$concept|query";
		}
	} else {	
		$sql = "SELECT concept, description FROM rsol_c_concept where concept = '" . $concept . "'";
		$res = $conn->query ($sql);
		if ($conn->isResultSet ($res)) {
				$ret = "";
				if ($sRow =  $conn->fetchAssoc($res)){
					$ret .= $sRow['concept'] . ": " . $sRow['description'];
				} else {
					$ret = "Error: not found concept while looking for $concept";
				}
		} else {
			$ret = "Error: not found concept while looking for $concept";
		}
		$result  = "<div class=\"bar\">";
		$result .= "    <span class=\"lemma\">" . $concept . "</span>";
		$result .= "</div>";
		$result .= "<div class=\"def\">" . $ret . "</div>";
	}
	return $result;
}

function do_showConcept($concept){
  $result = "<div id=\"box_lemma\">";
  $result .= " <div class=\"lemmabar\">Concept: $concept</div>";
  $result .= getConceptsList($concept);
  $result .= " <br/>";
  $result .= " <br/>";
  $result .= " <div id=\"describeConcept\">";
  $result .= describeConcept($concept, "");
  $result .= " </div>";
  $result .= "</div>";
  $result .= "<div id=\"box_ethmology\">";
  $result .= "  <div class=\"ethmobar\">" . "Concepts: $concept" . "</div>";
  $result .= "  <div id=\"onto-chart-container\"></div>";
  $result .= "</div>";
  
  return $result;
}

?>
