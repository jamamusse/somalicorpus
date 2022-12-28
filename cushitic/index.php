<?php
 define('APP_DIR', './');
 define('INCLUDES_DIR', 'includes/');
 define('_TITLE_IN_HEAD', 'Cushitic Language Family Corpora');
 define('_INSERT_A_WORD', 'Insert a cushitic word');
 include(APP_DIR . "config.php");
 function getConceptsList(){
    global $conn;
    $ret = "no concepts ready";
    $sql = "SELECT * FROM rsol_c_concept ORDER BY weight DESC LIMIT 5";
	$res = $conn->query ($sql);
	if ($conn->isResultSet ($res)) {
			$ret = "";
			while ($sRow =  $conn->fetchAssoc($res)){
				$ret .= "<button onclick=\"showConcept('marriage'); return false;\">marriage</button>";
			}
	} else {
		$ret = "Error in $sql - " . $conn->error();
	}
 	return $ret;
 }
 if (!isset($op)){
   $op = 'login';
 }
 if ($op == 'login'){
   $lang = "en";
 } 
 $result = "";
 switch ($op){
	case 'login':
	  $result = "Welcome to All in a Family place for our forefathers languages";
	  $result = "";
	  break;
	case 'up_bayso':
   	  include_once('check_bayso.php');
   	  $result = do_check();
	  break;
	case 'search':
          if(isset($q) and !isset($as_values_q)){
             $target='so';
          } else { 
	     list($target, $q) = preg_split('/-/', trim($as_values_q), 2);
             $q = preg_replace ( '/\,/', '', trim ( $q ) );
          }
	  $result = "<br/>";
	  include_once('multi_search.php');
	  $result .= do_search($q, $target) . "<br/>";
	  break;
	default:
	  $result = "$op not recognized";
	  break;
 }
?>
<html>
<head>
<meta name="robots" content="index,nofollow">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link rel="stylesheet" type="text/css" charset="utf-8" media="all" href="css/main.css">
<title><?php echo _TITLE_IN_HEAD; ?></title>

<script type="text/javascript" src="includes/jquery-1.7.js"></script>
<script type="text/javascript" src="includes/jfusion/fusioncharts.js"></script>
<script type="text/javascript" src="includes/jfusion/themes/fusioncharts.theme.fint.js"></script>

<script type="text/javascript">
$(document).ready(function() {	
	//select all the a tag with name equal to modal
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
		var title = $(this).attr('title');

        doRealSubmit(title);	
       
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
	
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$('.window .closeBox').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});	
	$(function(){
	var data = {items: [
{value: "21", name: "JMJ"}
]};
 $("input[type=texta]").autoSuggest("../suggestclemma.php", {asHtmlID: "q", selectedValuesProp: "name", selectedItemProp: "name", searchObjProps: "name", startText: "Insert a Cushitic word here"});
 
});
	
});
</script>

<script type="text/javascript" src="js/mine.js"></script>
<script type="text/javascript" src="js/charts.js"></script>

<script type="text/javascript" src="includes/jquery.autoSuggest.packed.js"></script>

<link rel="stylesheet" href="css/autoSuggest.css" type="text/css" media="screen" charset="utf-8" />
</head>
<body>
<!--h1>Welcome to Cushitic Language Family Corpora</h1-->
<div id="loginDiv">
     <form method="get" action="index.php">
         <input type="hidden" name="op" value="search" />  
         <input type="hidden" name="lang" value="<?php echo $lang; ?>" />
	 	 <input type="submit" value="search on" />
         <strong>Omo-Tana Family and Saho Corpora: over 7.3 million Lowland East Cushitic words or</strong>
	     <button onclick="showConcept('all'); return false;">browse concepts</button>
	 	 <strong><i>like: </i></strong><?php echo getConceptsList(); ?> 
	     <input class="inputtext" type="texta" name="q" value=""/>
     </form>
</div>
<div id="restult_table">
<?php echo $result; ?>
</div>
<?php
 if($op != 'search'){
   echo "<div id=\"chart-container\"></div>";
 }
?>
</body>
</html>
