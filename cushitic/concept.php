<?php

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
		$result = "but you asked: $formrequest";
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
