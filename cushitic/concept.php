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
	$sql = "SELECT concode, concept, parent FROM rsol_c_concept where concept <> 'Concepts' ORDER BY weight DESC LIMIT 2";
	$res = $conn->query ($sql);
	if ($conn->isResultSet ($res)) {
			$ret = "";
			while ($sRow =  $conn->fetchAssoc($res)){
				$ret .= "<button onclick=\"goConcept('" . $sRow['concept'] . "', '" . $sRow['concode'] . "', '" . $sRow['parent'] . "'); return false;\">" . $sRow['concept'] . "</button> ";
			}
	} else {
		$ret = "Error";
	}
	return $ret;
}

function getConceptsList($concept, $parent){
	global $conn;
	$ret = "";
	$sql = "SELECT concode, concept, parent FROM rsol_c_concept where parent = '$parent' ORDER BY concode";
	$res = $conn->query ($sql);
	if ($conn->isResultSet ($res)) {
			$ret = "";
			while ($sRow =  $conn->fetchAssoc($res)){
				$curr = ($sRow['concept'] == $concept? "style=\"background-color: #f44336;\"" : "style=\"background-color: buttonface\"");
				$ret .= "<button id=\"" . $sRow['concode'] . "\" $curr onclick=\"showConcept('" . $sRow['concept'] . "', '" . $sRow['concode'] . "'); return false;\">" . $sRow['concept'] . "</button> ";
			}
	}
	return $ret;
}

function getThisConcept($code){
	global $conn;
	$ret = "";
	if ($code != 'N00' && $code != NULL){
		$sql = "SELECT concept, image FROM rsol_c_concept where concode = '" . $code . "'";
		$res = $conn->query ($sql);
		if ($conn->isResultSet ($res)) {
			if ($sRow =  $conn->fetchAssoc($res)){
				$ret = $code . "_" . $sRow['concept'] . "_" . $sRow['image'];
			}
		}
	}
	return $ret;
}

function getThisConceptByCode($code){
	global $conn;
	$ret = ['concept' => '', 'description' => '', 'image' => ''];
	if ($code != NULL){
		$sql = "SELECT concept, description, image FROM rsol_c_concept where concode = '" . $code . "'";
		$res = $conn->query ($sql);
		if ($conn->isResultSet ($res)) {
			if ($sRow =  $conn->fetchAssoc($res)){
				$ret = $sRow;
			}
		}
	}
	return $ret;
}

function getConceptParent($concept){
	global $conn;
	$ret = ['parent' =>  "N00"];
	if ($concept != NULL){
		$sql = "SELECT parent, description FROM rsol_c_concept where concept = '" . $concept . "'";
		$res = $conn->query ($sql);
		if ($conn->isResultSet ($res)) {
			if ($sRow =  $conn->fetchAssoc($res)){
				$ret = $sRow;
			}
		}
	}
	return $ret;
}


function describeConcept($concept, $parent, $formrequest){
	global $conn, $translateLA;
	$ret = "Unknown concept";
	if ($formrequest == 'JSGraph'){
		$sql = "SELECT concode, concept, parent, image FROM rsol_c_concept where concept = '" . $concept . "'";
		$res = $conn->query ($sql);
		if ($conn->isResultSet ($res)) {
				if ($sRow =  $conn->fetchAssoc($res)){
					$code = $sRow['concode'];
					$name = $sRow['concept'];
					$image = $sRow['image'];
					//children
					$children = "";
					$sql2 = "SELECT concode, concept, image FROM rsol_c_concept where parent = '" . $code . "'";
					$res2 = $conn->query ($sql2);
					if ($conn->isResultSet ($res2)) {
						while ($sRow2  =  $conn->fetchAssoc($res2)){
							$ccode  = $sRow2['concode'];
							$cname  = $sRow2['concept'];
							$cimage = $sRow2['image'];
							 
							$children .= ($children ? "-" : "") . $ccode . "_" . $cname . "_" . $cimage;
						}
					}	
					$parent = getThisConcept($sRow['parent']);
					$languages = "so-re-ma-bo-ba-ar-el-da";
					$result = $code . "|"
							. $name . "|"
							. $parent  . "|"
							. $image . "|"
							. $children . "|"
							. $languages;
				} else {
					$result = "Error|$concept|query|||";
				}
		} else {
			$result = "Error|$concept|query";
		}
	} else {
		$conceptCode = NULL;
		$parentCode = NULL;
		$gotAtleastOne = 0;
		$subconcepts = "";
		$languages   = array('ar' => "", 'ba' => "", 'bo' => "", 're' => "", 'so' => "", 'el' => "", 'da' => "", 'ma' => "");
		$sql = "SELECT concode, concept, description, parent FROM rsol_c_concept where concept = '" . $concept . "'";
		$res = $conn->query ($sql);
		if ($conn->isResultSet ($res)) {
				$ret = "";
				if ($sRow =  $conn->fetchAssoc($res)){
					$conceptCode = $sRow['concode'];
					$parentCode  = $sRow['parent'];
					$ret .= $sRow['concept'] . ": " . $sRow['description'];
			        $subconcepts = ($conceptCode == 'N00' ? "" : getConceptsList($concept, $conceptCode));
					$sql3 = "select w.word, w.language from rsol_c_cushiticwords w, rsol_c_concept c, rsol_c_wordconcept r 
						where c.recid = r.conceptid and w.recno = r.wordid and c.concode = '". $conceptCode . "' order by w.language, w.word";
					$res3 = $conn->query ($sql3);
					if ($conn->isResultSet ($res3)) {
						while ($sRow3 =  $conn->fetchAssoc($res3)){
							$word = $sRow3['word'];
							$lang = $sRow3['language'];
							$languages[$lang] .= ($languages[$lang] ? ", " : "") . $word;
							$gotAtleastOne = 1;
						}
					}
				} else {
					$ret = "Error: not found concept while looking for $concept";
				}
		} else {
			$ret = "Error: not found concept while looking for $concept";
		}
		$parentDesc = ""; $pp = null;
		if($parentCode && $parentCode != 'N00'){
			$pp = getThisConceptByCode($parentCode);
			if ($pp['concept']){
				$parentDesc = "<span class=\"def\">" . $pp['concept'] . ": " . $pp['description'] . "</span>";
			}
		}
		$result = "";
		if ($parentDesc){
			$result .= "<div class=\"bar\">";
			$result .= "    <span class=\"lemma\">" . $pp['concept'] . "</span>";
			$result .= "</div>";
			$result .= "<div class=\"def\">" . $pp['description'] . "</div><br/>";
			$result .= "<div class=\"def\">Sub concepts: " . getConceptsList($pp['concept'], $parentCode) . "</div><br/>";
		}
		$result .= "<div class=\"bar\">";
		$result .= "    <span class=\"lemma\">" . $concept .  ($pp ? " subclass of " . $pp['concept'] : "") . "</span>";
		$result .= "</div>";
		$result .= "<div class=\"def\">" . $ret . "</div>";
		if ($subconcepts){
			$result .= "<br/><div class=\"def\">Sub concepts: " . $subconcepts . "</div>";
		}
		if($gotAtleastOne){
			$result .= "<br/><div class=\"bar\">";
			$result .= "    <span class=\"lemma\">Languages</span>";
			$result .= "</div>";
			foreach ($languages as $lCode => $words){
				if ($words){
					$result .= "<div class=\"def\"><i>" . $translateLA[$lCode] . "</i>: " . $words . "<br/><br/></div>";		
				}
			}
		}
	}
	return $result;
}

function do_showConcept($concept){
  $parent = getConceptParent($concept)['parent'];
  $result = "<div id=\"box_lemma\">";
  $result .= " <div class=\"lemmabar\">Concept: $concept</div>";
  $result .= getConceptsList($concept, "N00");
  $result .= " <br/>";
  $result .= " <br/>";
  $result .= " <div id=\"describeConcept\">";
  $result .= describeConcept($concept, $parent, "");
  $result .= " </div>";
  $result .= "</div>";
  $result .= "<div id=\"box_ethmology\">";
  $result .= "  <div class=\"ethmobar\">" . "Concepts: $concept" . "</div>";
  $result .= "  <div id=\"onto-chart-container\"></div>";
  $result .= getPublicationRef();  
  $result .= "</div>";
  
  return $result;
}

?>
