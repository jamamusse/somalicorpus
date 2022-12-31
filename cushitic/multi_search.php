<?php

function getConceptsListMenu(){
	global $conn;
	$ret = "no concepts ready";
	$sql = "SELECT concode, concept FROM rsol_c_concept where concept <> 'Concepts' ORDER BY weight DESC LIMIT 2";
	$res = $conn->query ($sql);
	if ($conn->isResultSet ($res)) {
			$ret = "";
			while ($sRow =  $conn->fetchAssoc($res)){
				$ret .= "<button id=\"" . $sRow['concode'] . "\" onclick=\"goConcept('" . $sRow['concept'] . "', '" . $sRow['concode'] . "'); return false;\">" . $sRow['concept'] . "</button> ";
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
				$curr = ($sRow['concept'] == $concept? "style=\"background-color: #f44336;\"" : "style=\"background-color: green\"");
				$ret .= "<button id=\"" . $sRow['concode'] . "\" $curr onclick=\"showConcept('" . $sRow['concept'] . "', '" . $sRow['concode'] . "'); return false;\">" . $sRow['concept'] . "</button> ";
			}
	} else {
		$ret = "Error";
	}
	return $ret;
}

function describeConcept($concept){
	global $conn;
	$ret = "Unknown concept";
	$sql = "SELECT concept, description FROM rsol_c_concept where concept = '" . $concept . "'";
	$res = $conn->query ($sql);
	if ($conn->isResultSet ($res)) {
			$ret = "";
			if ($sRow =  $conn->fetchAssoc($res)){
				$ret .= $sRow['concept'] . ": " . $sRow['description'];
			}
	} else {
		$ret = "Error: not found concept while looking for $concept";
	}
	return $ret;
}

function do_showConcept($concept){
  $result = "<div id=\"box_lemma\">";
  $result .= "<div class=\"lemmabar\">Concept: $concept</div>";
  $result .= getConceptsList($concept);
  $result .= "<br/>";
  $result .= "<br/>";
  $result .= "<div id=\"describeConcept\">"; 
  $result .= "  <div class=\"bar\">";
  $result .= "  <span class=\"lemma\">" . $concept . "</span>";
  $result .= "  </div>";
  $result .= "  <div class=\"def\">" . describeConcept($concept) . "</div>";
  $result .= "  </div>";
  $result .= "</div>";
  $result .= "<div id=\"box_ethmology\">";
  $result .= "<div class=\"ethmobar\">" . "Concepts: $concept" . "</div>";
  $result .= "<div id=\"onto-chart-container\"></div>";
  $result .= "</div>";
  
  return $result;
}

function do_search($q, $target){
  global $conn, $translateLA, $concepts;
  $rows = ""; $languagesfound = "";
  $i = 0; $lfound = 0;
  $sql = "select language, word, meaning, pos, def_dictionary, english from rsol_c_cushiticwords where word like '$q'";
  if ($conn){
     $res = $conn->query($sql);
     if ($conn->isResultSet($res)) {
        while ($sRow =  $conn->fetchAssoc($res)){
         $l   = ($sRow['language'] ? $translateLA[$sRow['language']] : $translateLA['UNKNOWN']);
         $w   = $sRow['word'];
         $m   = $sRow['meaning'];
         $def = $sRow['def_dictionary'];
         $pos = $sRow['pos'];
         $en  = $sRow['english'];
         $i ++;
         if (!preg_match("/$l/", $languagesfound)){
         	$lfound ++;
         	$languagesfound .= ($languagesfound ? ", " : "") . $l;
         }
         $rows .= "<div class=\"bar\">";
         $rows .= "<span class=\"lemma\">$l - " . ($m ? " $m - " : "") . "<a href=\"?op=wordanalize\">$w</a> ($pos)</span>";
         $rows .= "</div>";
         $rows .= "<div class=\"def\">$def " . ($en ? "English: $en" : "") . "</div>";
         $rows .= "<br/>";
       }
     }
  }
  $result = "<div id=\"box_lemma\">";
  $result .= "<div class=\"lemmabar\">" . ($i > 0 ? "$i items found in $lfound language(s) - $languagesfound" : "$q not found in $target") . "</div>";
  $result .= "$rows";
  $result .= "</div>";
  //test
  $concepts = "<div id=\"onto-chart-container\"></div>";
  if($concepts){
	  $result .= "<div id=\"box_ethmology\">";
	  $result .= "<div class=\"ethmobar\">" . "Concepts" . "</div>";
	  $result .= "$concepts";
	  $result .= "</div>";
  }

  return $result;
}

?>
