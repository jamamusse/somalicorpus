<?php
$verGit = '1.00-2016';

define("MAIN_DIR", dirname(__FILE__) . "");
define("APP_DIR", dirname(__FILE__)  . "/");
define("INCLUDES_DIR", MAIN_DIR      . "/includes/");

include(APP_DIR . "config.php");

function db_disconnect(){
        global $conn;
        if ($conn->isConnected()){
                $conn->disconnect();
        }
}

function suggestme (){
        global $conn;
	global $c_q, $c_as_values_q;
	$data = array();

	$c_q = (isset($c_q) ? $c_q : "");
	if(isset($c_q) && $c_q){
	   $q = trim($c_q);
           $sql = "select distinct word, language from rsol_d_cushiticwords where word  like '$q%' order by word limit 10";
      	   if ($conn){
             $res = $conn->query($sql);
             if ($conn->isResultSet($res)) {
              while ($sRow =  $conn->fetchAssoc($res)){
                  $json = array();
                  $json['name'] = $sRow['language'] . '-' . $sRow['word'];
                  $json['value'] = $sRow['language'] . '-' . $sRow['word'];
                  $data[] = $json;
              }
            }
          }
        }
	header("Content-type: application/json");
	echo json_encode($data);
	exit;
}


suggestme();

?>
