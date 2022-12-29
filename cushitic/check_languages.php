<?php
function add_this($language, $word, $pos, $fon, $def, $en){
   global $conn, $translateLA, $verbose;
   $result = "adding $word in $translateLA[$language] with $pos [$fon]";
   if (preg_match('/_/', $word)){
	   list($word, $m) = preg_split('/_/', $word, 2);
	   $meaning = ($m ? $m : 0);
   } else {
	   $meaning = 0;
   }
   $sql = "$word, $meaning, $pos, $def";
   $word = addslashes($word);
   $pos  = addslashes($pos);
   $def  = addslashes($def);

   $sql = "INSERT INTO `rsol_c_cushiticwords` 
	(`recno`, `word`, `language`, `phonetic`, `pos`, `english`, `def_dictionary`, `meaning`)
	VALUES 
	(NULL,  '$word', '$language', '$fon', '$pos',  '$en', '$def', '$meaning');";

   $res = $conn->query ($sql);
   if (!$conn->error()) {
      $result .= "Added: " . mb_convert_encoding($sql, "HTML-ENTITIES", "UTF-8") . "<br/>";
   } else {
      $result .= "<font color=\"red\">Failed</font>: ". mb_convert_encoding($sql, "HTML-ENTITIES", "UTF-8") . "<br/>";
   }
   return ($verbose ? $result : "");
}

function do_check($language, $filein){
  global $conn;
  $suspend = 0;
  $result = "Checking $filein for $language<br/>";
  if($suspend){
    $result .= "Suspended this operation - already uploaded the $language dictionary";
  } else {
  	$result = "";
	$handle = fopen($filein, "r");
  	if ($handle) {
        	//first clean
        	$result .= "Starting to clean<br/>";
        	$sql = "DELETE from rsol_c_cushiticwords where language = '$language'";
        	$res = $conn->query ($sql);
        	if (!$conn->error()) {
           	  $result .= "Cleaning $language done<br/>";
        	}
        	$i = 0;
        	$names = 0; $verbs = 0; $adjs  = 0; $advs   = 0;
        	$noms  = 0; $conjs = 0; $pros  = 0; $nadjs  = 0;
        	$pops  = 0; $dems  = 0; $cars  = 0; $nadvs  = 0;
        	$amhs  = 0; $korma = 0; $adpop = 0; $relpro = 0;
        	$negs  = 0; $checks = 0;
        	// skip the first line
        	$line = fgets($handle);
    		while (($line = fgets($handle)) !== false) {
    	    		$i++; $to_add = 1;
       	    		list($a, $b, $fon, $d, $e, $english, $notes) = preg_split('/,/', $line, 7);
            		if ($b == ''){
                	  $checks ++;
                	  $b = 'tobechecked';
            		} elseif ($b == 'n'){
                	  $names ++;
            		} elseif ($b == 'v'){
                  	  $verbs ++;
            		} elseif ($b == 'adv'){
                	  $advs ++;
            		} elseif ($b == 'adj'){
                	  $adjs ++;
            		} elseif ($b == 'conj'){
                	  $conjs ++;
            		} elseif ($b == 'nom'){
                	  $noms ++;
            		} elseif ($b == 'pro'){
                	  $pros ++;
            		} elseif ($b == 'pop'){
                	  $pops ++;
            		} elseif ($b == 'dem'){
                	  $dems ++;
            		} elseif ($b == 'korma'){
                	  $korma ++;
            		} elseif ($b == '(Amh)'){
                	  $amhs ++;
            		} elseif ($b == 'cardnum'){
                	  $cars ++;
            		} elseif ($b == 'n/adj'){
                	  $nadjs ++;
            		} elseif ($b == 'adj/pop'){
                	  $adpop ++;
            		} elseif ($b == 'rel.pro'){
                	  $relpro ++;
            		} elseif ($b == 'n/adv'){
                	  $nadvs ++;
            		} elseif ($b == 'neg'){
                	  $negs ++;                	  
            		} else {
                	  $result .= "$i: found unknown: $b<br/>";
                	  $to_add = 0;
            		}
            		if ($to_add){
            		  $def = ($d ? "SOM=$d " : "") . ($e ? "REL=$e" : "") . ($notes ? "NOTES=$notes" : "");
             		  $result .= add_this($language, $a, $b, $fon, $def, $english);
            		}
       		}
       		$total = $names + $verbs + $advs + $adjs + $conjs + $noms + $pros + $pops + $dems + $amhs + $korma + $cars + $adpop + $nadjs + $nadvs + $relpro;
       		fclose($handle);
       		$result .= "to be set:   $checks<br/>";
       		$result .= "Names:   $names<br/>";
       		$result .= "Verbs:   $verbs<br/>";
       		$result .= "Advs:    $advs<br/>";
       		$result .= "Adjs:    $adjs<br/>";
       		$result .= "Conj:    $conjs<br/>";
       		$result .= "Noms:    $noms<br/>";
       		$result .= "Pros:    $pros<br/>";
       		$result .= "Pops:    $pops<br/>";
       		$result .= "Dems:    $dems<br/>";
       		$result .= "Amhs:    $amhs<br/>";
       		$result .= "Korma:   $korma<br/>";
       		$result .= "Cars:    $cars<br/>";
       		$result .= "Adj/pop: $adpop<br/>";
       		$result .= "N/Adjs:  $nadjs<br/>";
       		$result .= "N/Advs:  $nadvs<br/>";
       		$result .= "N/Advs:  $relpro<br/>";
       		$result .= "negs:    $negs<br/>";
       		$result .= "Total: $total [$i]<br/>";
  	} else {
    		$result = 'Failed to open';
  	}
  }
  return $result;
}
?>

