<?php

$verGit = '1.01-2023';

# Manages new words directly to add to the corpus.

$opMe     = "manageOtBaseWord";
$HaaMaya  = Array('0'  => 'No', '1'  => 'Yes');

$foriegnLanguages  = Array(
	''        => '',
	'UKNOWN'  => 'Unknown',
	'AM'      => 'Amharic',
	'AR'      => 'Arabic',
	'EN'      => 'English',
	'FR'      => 'French',
	'HA'      => 'Harari',
	'IN'      => 'Indian',
	'IT'      => 'Italian',
	'KI'      => 'Kiswahili',
	'OR'      => 'Oromo',
	'PE'      => 'Persian'
);

$nsemantics = Array (
	'' => '',
	'unknown' => 'Unknown',
	'transfer' => 'Transfer',
	'tool' => 'Tool',
	'time' => 'Time',
	'quant' => 'Quantity',
	'pro' => 'Pronoun',
	'perception verb' => 'Perception verb',
	'motion' => 'Motion',
	'misc verb' => 'Misc verb',
	'location' => 'Location',
	'impact' => 'Impact',
	'human verb' => 'Human verb',
	'human' => 'Human',
	'environment' => 'Environment',
	'conj' => 'Conjuction',
	'colour' => 'Colour',
	'body verb' => 'Body verb',
	'body part' => 'Body part',
	'animal product' => 'Animal product',
	'animal' => 'Animal',
	'adjective' => 'Adjective'
);


function getABC(){
	global $conn, $wid, $opMe;
	$ret = "";
	
	$sql = "select count(*) n, SUBSTRING(english, 1, 1) c from rsol_c_otsawidsh group by c order by c";
    if ($res = $conn->query ( $sql )){
		if ($conn->isResultSet ( $res )) {
			while ($sRow = $conn->fetchAssoc ( $res ) ) {
				$ret .= ($ret ? " - " : "") . $sRow['c'] . "(<a href=\"?op=$opMe&func=list&wid=$wid&startch=" . $sRow['c'] . "\">" . $sRow['n'] . "</a>)";
			}   				
		}
	}
	return $ret;
}

function listTokens($char){
	global $conn, $opMe;
	$ret = "";
	if ($char){
		$sql = "select recid, english from rsol_c_otsawidsh where english like '$char%'";
		if ($res = $conn->query ( $sql )){
			if ($conn->isResultSet ( $res )) {
				while ($sRow = $conn->fetchAssoc ( $res ) ) {
					$wid = $sRow['recid'];
					$eng = $sRow['english'];
					$ret .= ($ret ? ", " : "") . "<a href=\"?op=$opMe&func=edit&wid=$wid&startch=$char\">$eng</a>";
				}   				
			}
		}
	}
	return $ret;
}


function checkPoint(){
	global $conn, $translateLA;
	$aRes = array('english' => 0, 'so' => 0, 're' => 0, 'ma' => 0, 'bo' => 0, 'ba' => 0, 'ar' => 0, 'el' => 0, 'da' => 0);
	$ret = "";
	$data = "";
	foreach($aRes as $l => $val){
		$sql = "SELECT count(*) n FROM `rsol_c_otsawidsh` WHERE $l <> ''";
		if ($res = $conn->query ( $sql )){
			if ($conn->isResultSet ( $res )) {
				while ($sRow = $conn->fetchAssoc ( $res ) ) {
					$data .= ($data ? ", " : "") . "{\"label\": \"" . ($l == 'english' ? 'English' : $translateLA[$l]) . "\", \"value\": \"" . $sRow['n'] . "\"}";
					$aRes[$l] = $sRow['n'];
				}  
			}
		}
	}
	$data = "\"data\": [". $data . "]";	
	$ret .= "
<script type=\"text/javascript\">
FusionCharts.ready(function(){
      var genderChart = new FusionCharts({
        \"type\": \"column2d\",
        \"renderAt\": \"onto-chart-stats\",
        \"width\": \"1024\",
        \"height\": \"300\",
        \"dataFormat\": \"json\",
        \"dataSource\": {\"chart\": {
\"caption\": \"So far compiled statistics\",
\"subCaption\": \"\",
\"xAxisName\": \"Language\",
\"yAxisName\": \"Number of words filled\",
\"numberPrefix\": \"\",
\"theme\": \"fint\"
    },
$data
        }});
	genderChart.render();
    }
)
</script>";
	
	return $ret;
}

function checkDoubleLife($word){
   global $conn;
   $wid = -1;
   $sql = "SELECT recid from rsol_d_otbasewords where english like '" . addslashes($word) . "'";
   if ($res = $conn->query ( $sql )){
   		if ($conn->isResultSet ( $res )) {
   			if ($sRow = $conn->fetchAssoc ( $res ) ) {
   				$wid = $sRow['recid'];
   			}   				
   		}
   	}
   	if ($conn->error ()){
   		echo "Attention: error: " . $conn->error();
   		exit;
   	}
   	return $wid;
}		


function stubEditWord($wid){
	return 	editWord ($wid);
}

function editWord ($wid){
	global $conn, $op, $opMe, $func;
	global $eng, $so, $re, $ma, $bo, $ba, $ar, $el, $da, $semantic, $reference;
	
	if ($wid){
		if ($func == 'edit'){
			$sql    = "SELECT english, so, re, ma, bo, ba, ar, el, da, semantic, reference
					   FROM rsol_c_otsawidsh
					   WHERE `recid` = '$wid'";
			if ($res = $conn->query ( $sql )){
				if ($conn->isResultSet ( $res )) {
					if ( $sRow = $conn->fetchAssoc ( $res ) ){
						 $eng      = $sRow['english'];
						 $so       = $sRow['so'];
						 $re       = $sRow['re'];
						 $ma       = $sRow['ma'];
						 $bo       = $sRow['bo'];
						 $ba       = $sRow['ba'];
						 $ar       = $sRow['ar'];
						 $el       = $sRow['el'];
						 $da       = $sRow['da'];
						 $semantic = $sRow['semantic'];
						 $reference= $sRow['reference'];
						 

						 $func = 'update';
						 $ret = getFilledForm($wid);
					} else {
						$ret = "Could not find: $wid";
					}
				} else {
					$ret = "Connection error: $wid";
				}			
			} else {
				$ret = "Connection error: $wid [$sql]";
			}
		} elseif ($func == 'update'){
			$eng    = addslashes($eng);
			$so    = addslashes($so);
			$ma    = addslashes($ma);
			$re    = addslashes($re);
			$bo    = addslashes($bo);
			$ba    = addslashes($ba);
			$ar    = addslashes($ar);
			$el    = addslashes($el);
			$da    = addslashes($da);			
			$eng    = addslashes($eng);
			$reference = addslashes($reference);
			$sql = "update rsol_c_otsawidsh
					   SET 
					   	`english`  = '$eng',
					   	`so`       = '$so',
					   	`ma`       = '$ma',
					   	`re`       = '$re',
					   	`bo`       = '$bo',
					   	`ba`       = '$ba',
					   	`ar`       = '$ar',
					   	`el`       = '$el',
					   	`da`       = '$da',
					   	`semantic` = '$semantic',
					   	`reference` = '$reference'
					   WHERE `recid` = '$wid'";
			if ($res = $conn->query ( $sql )){
				if (!$conn->error ()) {
					$func = 'update';
					$ret = getFilledForm($wid);
				} else {
					$ret = "SQL Error: $sql";
				}
			} else {
				$ret = "SQL Error: $sql";
			}	
		} else {
			$ret = "Could not recognize function $func";
		}
	} else {
		$ret = "Need at least WordId: $wid";
	}
	if ($conn->error ()){
		echo "$ret<br/><br/>Attention: Connection Error: " . $conn->error();
		exit;
	}
	
	return $ret;
}

function insertToken($eng) {
	global $conn, $opMe, $resultato;;
	$eng    = addslashes($eng);
 
    $wid = checkDoubleLife($word);
    if ($wid == -1){
		$sql    = "INSERT INTO rsol_d_otbasewords
					(`recid`, `english`) 
				VALUES 
					(NULL, '$eng')";
		$conn->query ( $sql );
		$lword = "I added $word:  <a href=\"?op=$opMe&func=read&wid=$wid\">edit</a> or check <a href=\"?op=search&corpus=OmBaseWord&q=$word\">showWord</a>";
		$ret = ($conn->error () ? "<font color=\"red\">Failed - $sql" : "<font color=\"blue\">Ok") . " ($eng)</font>: $lword";
	} else {
	    $ret = "<font color=\"red\">ATTENTION ($eng) exist</font>: <a href=\"?op=$opMe&func=read&wid=" . $wid . "\">Edit $word: $wid</a>";
	}
		
	$resultato = $ret;
		
	return;
}

function stumbNewForm(){
	global $eng;
	return getFilledForm(-1, $eng);
}

function isAdmin(){
	return true;
}

function getFilledForm($wid){
	global $conn, $op, $func, $nsemantics, $HaaMaya, $foriegnLanguages;
	global $eng, $so, $re, $ma, $bo, $ba, $ar, $el, $da, $semantic, $reference, $startch;
	$readonly = "";
	$meaning = 0; $plural = "";
	
	if ($func == 'new'){
	    $func = 'add';
	}
	$menuback = "Define navigation:<p>" . getABC() . "</p>";
	if (!isAdmin()){
		$readonly = "class=\"readonly\" readonly";
	}
	$ret  = "<div id=\"word_table\">";
	$ret .= "<form method=\"post\" action=\"index.php\">
	<input type=\"hidden\" value=\"$op\" name=\"op\">
	<input type=\"hidden\" value=\"$wid\" name=\"wid\">
	<input type=\"hidden\" value=\"$startch\" name=\"startch\">
	<input type=\"hidden\" value=\"" . ($wid == -1 ? "add" : "update") . "\" name=\"func\">";
	
	$ret .= "<table id=\"\" align=\"center\" border=\"1\">";
	$ret .= "<tr>
	           <td class=\"label\">English word</td>
	           <td class=\"data\" colspan=\"2\"><input size=\"35\" name=\"eng\" type=\"text\" readonly value=\"" . $eng . "\"/></td>
	           <td class=\"label\">Semantic</td>
	           <td class=\"data\" colspan=\"2\"><select name=\"semantic\">" . getoptions($nsemantics, $semantic) . "</select></td>
	           <td class=\"data\" colspan=2>Working on <font color=\"red\"><i><u>$eng</u></i></font></td>	           
	           </tr>";
	$ret .= "<tr><td class=\"labelH\">Somali</td>
				 <td class=\"labelH\">Rendille</td>
				 <td class=\"labelH\">Maay</td>
				 <td class=\"labelH\">Boni</td>
				 <td class=\"labelH\">Bayso</td>
				 <td class=\"labelH\">Arbore</td>
				 <td class=\"labelH\">El Molo</td>
				 <td class=\"labelH\">Dasanach</td>
			 </tr>";
	$ret .= "<tr><td class=\"data\"><input size=\"18\" name=\"so\" type=\"text\" $readonly value=\"" . $so . "\"/></td>
				 <td class=\"data\"><input size=\"18\" name=\"re\" type=\"text\" $readonly value=\"" . $re . "\"/></td>
				 <td class=\"data\"><input size=\"18\" name=\"ma\" type=\"text\" $readonly value=\"" . $ma . "\"/></td>
				 <td class=\"data\"><input size=\"18\" name=\"bo\" type=\"text\" $readonly value=\"" . $bo . "\"/></td>
				 <td class=\"data\"><input size=\"18\" name=\"ba\" type=\"text\" $readonly value=\"" . $ba . "\"/></td>
				 <td class=\"data\"><input size=\"18\" name=\"ar\" type=\"text\" $readonly value=\"" . $ar . "\"/></td>
				 <td class=\"data\"><input size=\"18\" name=\"el\" type=\"text\" $readonly value=\"" . $el . "\"/></td>
				 <td class=\"data\"><input size=\"18\" name=\"da\" type=\"text\" $readonly value=\"" . $da . "\"/></td>
			 </tr>";
	$ret .= "<tr><td class=\"labelH\">References:</td>
				 <td class=\"data\" colspan=7><textarea cols=\"114\" rows=\"5\" name=\"reference\">$reference</textarea></td>
			 </tr>";

/*
	$ret .= "<tr>
	           <td class=\"label\">Ergis</td>
	           <td class=\"data\"><select name=\"isloaned\">" . getoptions($HaaMaya, $isloaned) . "</select></td>
	           <td class=\"label\">Afka</td>
	           <td class=\"data\"><select name=\"laonl\">" . getoptions($foriegnLanguages, $laonl) . "</select></td>
	           <td class=\"label\">Ereyga qalaad</td>
	           <td class=\"data\" colspan=\"3\"><input size=\"45\" name=\"loanw\" type=\"text\" value=\"" . $loanw . "\"/></td></tr>";
*/		
	$ret .= "</table>";
	
	$ret .= "<input type=\"submit\" value=\"Save data\">";

	$ret .= "</form>$menuback";
	if ($startch){
		$ret .= listTokens($startch);
	}
	$ret .= "<p></p></div>";
	$ret .= "<div id=\"stat_chart\"><div id=\"onto-chart-stats\"></div></div>";
	$ret .= checkPoint();  

	return $ret;

}


function checkWordInWords($word){
	global $words;
    foreach ($words as $w){
      if ($w == $word){return true;}
    }
    return false;
}

function showWordFrequency ($docId, $docTitle, $word){
	global $conn, $op, $func, $words;
	if ($word){
		$words = Array ($word);
	}
	if (!$words){
		$words = Array ($docTitle);
	}
	$limit = 1000;
	checkWordInWords($word);
	$ret .= '<br/><div id="box_lemma">
	                 <div class="lemmabar">Rakaadka adeegsiga ereyada ee ' . highlightbase ( $docTitle ) . '</div>';
	$sql = "SELECT count(*) n, root FROM `rsol_d_corpus` where documentId = '" . addslashes($docId) . "' and root <> '' group by root order by n desc";
	$res = $conn->query ( $sql );
	if ($conn->isResultSet ( $res )) {
	$i = 0;
	while ( $i < $limit && $sRow = $conn->fetchAssoc ( $res ) ) {
		$i++;
		$w = $sRow ['root'];
		$n = $sRow ['n'];
		if (checkWordInWords($w)){
			$bcol = "balck";
			$col  = "white";
			$chk  = "checked";
		} else {
			$bcol = "white";
			$col  = "red";
			$chk  = "";		
		}
		$rows .= "<tr bgcolor=\"$bcol\"><td width=\"1\">$i</td>
					  <td align=\"left\"><a href=\"?op=$op&func=wordFrequency&docId=$docId&docTitle=$docTitle&word=$w\">
					  	<font color=\"$col\">$w</font></a>
					  </td>
					  <td>$n</td>
					  <td width=\"10\"><input type=\"checkbox\" name=\"words[]\" value=\"$w\" $chk></td>
				  </tr>";
		}
	}
	if ($rows){
	    $f = "<form method=\"get\" action=\"index.php\">
					<input type=\"hidden\" value=\"$op\" name=\"op\">
					<input type=\"hidden\" value=\"$func\" name=\"func\">
					<input type=\"hidden\" value=\"$docId\" name=\"docId\">
					<input type=\"hidden\" value=\"$docTitle\" name=\"docTitle\">";
		$row = "<tr><td width=\"1\">#</td>
					  <td align=\"centre\">Erey</td>
					  <td>Inta jeer</td>
					  <td>$f<input type=\"submit\" value=\"Eeg\"></td>
				  </tr>";
		$ret .= "<table border=\"1\" width=\"100%\">$row\n$rows</table>";
		$ret .= "</form>";
	}
	$ret .= '</div>';

	$rets = '<div id="box_ethmology"><div class="ethmobar">Kaydka Af Soomaaliga (Somali Corpus) 2016-2020</div>';
    foreach ($words as $word){
		$ret1  = "<br/><center><font color = 'red'>Isoggolaanshaha ereyga</font> <i>$word</i> <font color = 'red'>ee dhiganaha</font> <i>$docTitle</i></center>";
		$sql = "select parid, line from rsol_d_corpus where documentId = '$docId' and root like '$word'";
		$res = $conn->query ( $sql );
		if ($conn->isResultSet ( $res )) {
			$n = $conn->rowCount($res);
			$i = 0;
			$rows1 = "";
			while ( $i < $limit && $sRow = $conn->fetchAssoc ( $res ) ) {
				$i++;
				$cline = $sRow ['line'];
				$parid = $sRow ['parid'];
				list ( $pr, $ce, $po ) = preg_split ( "/\|/", $cline, 3 );
			
				$rows1 .= "<tr><td width=\"1%\">$i</td>
							   <td width=\"48%\" align=\"right\">$pr</td>
							   <td width=\"1%\"  align=\"centre\"><font color='red'>$ce</font></td>
							   <td width=\"48%\" align=\"left\">$po</td></tr>";
			
			}
		}
		$ret1 .= "<table border=\"1\" width=\"100%\">$rows1</table>";
		
		$ret1 .= "<p>Ma rabtaa in aad eegto haddii iyo sida loo adeegsaday ereygan <i>$word</i>? ";
		$ret1 .= "<a href=\"?op=search&corpus=corpus&q=$word\">Kaydka</a>";
		$ret1 .= " | ";
		$ret1 .= "<a href=\"?op=search&corpus=headword&q=&as_values_q=$word\">Qaamuuska</a>";
		$ret1 .= "</p>";
		
		$rets .= $ret1;
	}
	$rets .= '</div>';
	return $ret . $rets;

}

function manageOtBaseWord(){
	global $op, $func, $wid, $startch, $resultato;
	$resultato = "";
	
	switch ($func) {
		case 'new' :
			$resultato .= "Ku darista erey cusub, iyo doorashada nooca hadalka, aad uga fiirso<br/>";
//			$resultato .= stumbNewForm();
			break;
		case 'add' :
			$resultato .= "Ku darista erey cusub, iyo doorashada nooca hadalka, aad uga fiirso<br/>";
//		    insertToken($eng);
			break;
		case 'list' :
			$startch = ($startch ? $startch : "A");		
			if ($wid){
				$func = 'edit';
				$resultato .= stubEditWord ($wid);
			} else {
			    $resultato .= listTokens($startch);
			}
			break;
		case 'edit' :
			if ($wid){
//				$resultato .= "Read this data from DB: $wid<br/>";
				$resultato .= stubEditWord ($wid);
			} else {
				$resultato .= "Need the word id";
			}
			break;
		case 'update' :
			if ($wid){
//				$resultato .= "Saved this data to the DB: $wid<br/>";
				$resultato .= editWord ($wid);
			} else {
				$resultato .= "Need the word id";
			}
			break;
		case 'wordFrequency' :	
			if ($docId){
				$resultato .= showWordFrequency ($docId, $docTitle, $word);
			} else {
				$resultato .= "Waxa aad u baahan tahay aqoonsiga dhiganaga";
			}
			break;
			
		default:
			$resultato .= "Have no clue idea what to do with $func";
			break;
	}	
	return $resultato;
	
}


?>