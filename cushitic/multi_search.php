<?php

function do_search($q, $target){
  global $conn, $translateLA;
  $i = 0;
  $sql = "select language, word, meaning, category, def_dictionary from rsol_d_cushiticwords where word like '$q'";
  if ($conn){
     $res = $conn->query($sql);
     if ($conn->isResultSet($res)) {
        $rows = "";
        while ($sRow =  $conn->fetchAssoc($res)){
         $l   = ($sRow['language'] ? $translateLA{$sRow['language']} : $translateLA{'UNKNOWN'});
         $w   = $sRow['word'];
         $m   = $sRow['meaning'];
         $def = $sRow['def_dictionary'];
         $cat = $sRow['category'];
         $i ++;
         $rows .= "<div class=\"bar\">";
         $rows .= "<span class=\"lemma\">$l - " . ($m ? " $m - " : "") . "<a href=\"?op=wordanalize\">$w</a> ($cat)</span>";
         $rows .= "</div>";
         $rows .= "<div class=\"def\">$def</div>";
         $rows .= "<br/>";
       }
     }
  }
  $result .= "<div id=\"box_lemma\">";
  $result .= "<div class=\"lemmabar\">" . ($i > 0 ? "$i items found" : "$q not found in $target") . "</div>";
  $result .= "$rows";
  $result .= "</div>";

  return $result;
}

?>
