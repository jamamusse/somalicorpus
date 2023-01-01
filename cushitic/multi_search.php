<?php

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
  $result .= " <div id=\"describeConcept\">";
  $result .= "$rows";
  $result .= "</div>";
  $result .= "</div>";

  //Graph Concepts Container
  $result .= "<div id=\"box_ethmology\">";
  $result .= "<div class=\"ethmobar\">" . "Concepts" . "</div>";
  $result .= "<div id=\"onto-chart-container\"></div>";
  $result .= "</div>";

  return $result;
}

?>
