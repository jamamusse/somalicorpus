<?php
 define('APP_DIR', './');
 define('INCLUDES_DIR', '../includes/');
 define('_TITLE_IN_HEAD', 'Cushitic Language Family Corpora');
 define('_INSERT_A_WORD', 'Insert a cushitic word');
 include(APP_DIR . "config.php");
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

<!-- TinyMCE -->
<script type="text/javascript" src="includes/mine.js"></script>
<script type="text/javascript" src="includes/jquery-1.7.js"></script>
<script src="includes/jquery.imagemapster.js"></script>
<script src="includes/jquery.webcam.js"></script>
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
 $("input[type=texta]").autoSuggest("../suggestclemma.php", {asHtmlID: "q", selectedValuesProp: "name", selectedItemProp: "name", searchObjProps: "name", startText: "Geli halkan ereyga"});
 
});
	
});
</script>

<script type="text/javascript" src="js/charts.js"></script>

<script type="text/javascript" src="includes/jquery.autoSuggest.packed.js"></script>

<link rel="stylesheet" href="css/autoSuggest.css" type="text/css" media="screen" charset="utf-8" />
</head>
<body>
<!--h1>Welcome to Cushitic Language Family Corpora</h1-->
<div id="loginDiv">
<?php
 if($op != 'search'){
   echo "<div id=\"chart-container\"></div>";
 }
?>
     <form method="get" action="index.php">
         <input type="hidden" name="op" value="search" />  
         <input type="hidden" name="lang" value="<?php echo $lang; ?>" />
	 <input type="submit" value="search on" />
         <strong>OmoTana Family and Saho Corpora: over 7.3 million Lowland East Cushitic words</strong>
	 <input class="inputtext" type="texta" name="q" value=""/>
     </form>
</div>
<div id="restult_table">
<?php echo $result; ?>
</div>
</body>
</html>
