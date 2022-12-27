<?php
function add_this($word, $cat, $def){
   global $conn;
   $res = "adding $word";
   list($word, $m) = preg_split('/-/', $word, 2);
   $meaning = ($m ? $m : 0);

   list($d, $seealso) = preg_split('/^see /', $def, 2);

   $sql = "$word, $meaning, $cat, $def, ==> $seealso";
   $word = addslashes($word);
   $cat  = addslashes($cat);
   $def  = addslashes($def);
   $seealso = addslashes($seealso);

   $sql = "INSERT INTO `rsol_d_cushiticwords` 
(`recno`, `word`, `language`, `english`, `def_dictionary`, `def_english`, `source`, `category`, `base`, `rel`, `weight`, `meaning`, `srcfile`, `expanded`)
VALUES 
(NULL, '$word', 'ba', '$def', '$def', '$def', 'JMJ2022Somalicorpus', '$cat', '$word', '$seealso', '0', '$meaning', '$sourcefile', 0);";

   $res = $conn->query ($sql);
   if ($conn->isResultSet ($res)) {
      $result .= "Added: " . mb_convert_encoding($sql, "HTML-ENTITIES", "UTF-8") . "<br/>";
   } else {
      $res = "<font color=\"red\">Failed</font>: ". mb_convert_encoding($sql, "HTML-ENTITIES", "UTF-8") . "<br/>";
   }
   return $res;
}
function do_check(){
  global $conn;
  $suspend = 1;
  if($suspend){
   $result = 'Suspended this operation - already uploaded the Bayso dictionary';
  } else {
  	$result = "";
	$handle = fopen("data/wordlist.txt", "r");
  	if ($handle) {
        	//first clean
        	$result = "Starting to clean<br/>";
        	$sql = "delete * from rsol_d_cushiticwords where language = 'ba'";
        	$res = $conn->query ($sql);
        	if ($conn->isResultSet ($res)) {
           	  $result .= "Cleaning done<br/>";
        	}
        	$i = 0;
        	$names = 0; $verbs = 0; $adjs  = 0; $advs   = 0;
        	$noms  = 0; $conjs = 0; $pros  = 0; $nadjs  = 0;
        	$pops  = 0; $dems  = 0; $cars  = 0; $nadvs  = 0;
        	$amhs  = 0; $korma = 0; $adpop = 0; $relpro = 0;
    		while (($line = fgets($handle)) !== false) {
    	    		$i++; $to_add = 1;
       	    		list($a, $b, $c) = preg_split('/ /', $line, 3);
	    		if (preg_match('/_/', $a)){
      	        		$a = preg_replace('/_/', ' ', $a);
	    		}
            		if ($b == 'n'){
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
            		} else {
                	  $result .= "$i: found unknown: $b<br/>";
                	  $to_add = 0;
            		}
            		if ($to_add){
             		  $result .= add_this($a, $b, $c) . "<br/>";
            		}
       		}
       		$total = $names + $verbs + $advs + $adjs + $conjs + $noms + $pros + $pops + $dems + $amhs + $korma + $cars + $adpop + $nadjs + $nadvs + $relpro;
       		fclose($handle);
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
       		$result .= "Total: $total [$i]<br/>";
  	} else {
    		$result = 'Failed to open';
  	}
  }
  return $result;
}
?>

