<?php

function do_search($q, $target){
  global $conn, $translateLA, $concepts, $searchtype;
  $rows = ""; $languagesfound = "";
  $i = 0; $lfound = 0; $iFound  = "";
  if ($searchtype == 'SoremaboBaarelda'){
  	$sql = "SELECT * FROM rsol_c_otcommons WHERE MATCH (so,re,ma,bo,ba,ar,el,da,english) AGAINST ('$q')";
  	if($conn){
		 $res = $conn->query($sql);
		 if ($conn->isResultSet($res)) {
			while ($sRow =  $conn->fetchAssoc($res)){
				$rows .= "<tr><td>" . $sRow['so'] . "</td><td>" . $sRow['re'] . "</td><td>" . $sRow['ma'] . "</td><td>" . $sRow['bo'] . "</td>
							  <td>" . $sRow['ba'] . "</td><td>" . $sRow['ar'] . "</td><td>" . $sRow['el'] . "</td><td>" . $sRow['da'] . "</td></tr>";
			}
			$rows = "<table width=\"100%\" border=\"1\">" . 
					"<tr><th>SO</th><th>RE</th><th>MA</th><th>BO</th><th>BA</th><th>AR</th><th>EL</th><th>DA</th></tr>" .
					"$rows" .
					"</table>";
		}
  	}
  	$iFound = "$q is " . ($rows ? "" : "not") . "present in the Soremabo-Baarelda database";
  } else {
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
	  $iFound = ($i > 0 ? "$i items found in $lfound language(s) - $languagesfound" : "$q not found in $target");
  }
  $result = "<div id=\"box_lemma\">";
  $result .= "<div class=\"lemmabar\">" . $iFound . "</div>";
  $result .= " <div id=\"describeConcept\">";
  $result .= "$rows";
  $result .= "</div>";
  $result .= "</div>";

  //Graph Concepts Container
  $result .= "<div id=\"box_ethmology\">";
  $result .= "<div class=\"ethmobar\">" . "Concepts" . "</div>";
  $result .= "<div id=\"onto-chart-container\"></div>";
  $result .= getPublicationRef();
  $result .= "</div>";


  return $result;
}

?>
