<?php
 define('APP_DIR', './');
 define('INCLUDES_DIR', 'includes/');
 define('_TITLE_IN_HEAD', 'Cushitic Language Family Corpora');
 define('_INSERT_A_WORD', 'Insert a cushitic word');
 include(APP_DIR . "config.php");
 include(APP_DIR . "multi_search.php");
 include(APP_DIR . "check_languages.php");

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
	case 'search':
      if(isset($q) && $q){
        $target='so';
      } elseif (isset($as_values_q) && preg_match("/-/", $as_values_q)) {
	    list($target, $q) = preg_split("/-/", trim($as_values_q), 2);
	  } else {
	    $q = (isset($as_values_q) ? $as_values_q : null);
        $target='so';	      
	  }
      $q = preg_replace ( '/\,/', '', trim ( $q ) );
	  $result = "<br/>";
	  $result .= do_search($q, $target) . "<br/>";
	  break;
	case 'wordanalize':
   	  $result = "Coming soon!";
	  break;	  
	case 'up_boni':
   	  $result = do_check('bo', 'data/2022-RCF_Boni-Wordlist-v1.3.csv');
	  break;
	case 'up_bayso':
   	  $result = do_check('ba', 'data/2022-RCF_Bayso-Wordlist-v1.3.csv');
	  break;
	case 'up_rendille':
   	  $result = do_check('re', 'data/2022-RCF_Rendille-Wordlist-v1.3.csv');
	  break;
	case 'up_dasanach':
   	  $result = do_check('da', 'data/2022-RCF_Dasanach-Wordlist-v1.3.csv');
	  break;
	case 'up_maay':
   	  $result = do_check('ma', 'data/2022-RCF_Maay-Wordlist-v1.3.csv');
	  break;
	case 'up_elmolo':
   	  $result = do_check('el', 'data/2022-RCF_ElMolo-Wordlist-v1.3.csv');
	  break;
	case 'up_arbore':
   	  $result = do_check('ar', 'data/2022-RCF_Arbore-Wordlist-v1.3.csv');
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
	//if mask is clicked - this is the search suggest item list
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});	
	$(function(){
		var data = 
			{items: [{value: "21", name: "JMJ"}]};
 		$("input[type=texta]").autoSuggest("suggestclemma.php", {asHtmlID: "q", selectedValuesProp: "name", selectedItemProp: "name", searchObjProps: "name", startText: "Insert a Cushitic word here"});
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
	 	 <strong><i>like: </i></strong><?php echo getConceptsList(); ?> &#8921;&#8921;<strong><a href=".">Home</a></strong>
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
