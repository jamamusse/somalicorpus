<?php
 define('APP_DIR', './');
 define('INCLUDES_DIR', 'includes/');
 define('_TITLE_IN_HEAD', 'Cushitic Language Family Corpora');
 define('_INSERT_A_WORD', 'Insert a cushitic word');
 include(APP_DIR . "config.php");
 include(APP_DIR . "concept.php");
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
	  $result = do_search($q, $target) . "<br/>";
	  break;
	case 'showConcept':
   	  if(isset($formrequest)){
	   	  $result = describeConcept($concept, $parent, $formrequest);
		  echo $result;
		  exit;
   	  } else {
	   	  $result = do_showConcept($concept);
	  }
	  break;
	case 'manageOtBaseWord': 
	  include_once("otbaseword.php"); 
   	  $result = manageOtBaseWord();
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
<html lang="<?php echo $lang; ?>">
<html>
<head>
<meta name="robots" content="index,nofollow">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link rel="stylesheet" type="text/css" charset="utf-8" media="all" href="css/main.css">
<title><?php echo _TITLE_IN_HEAD; ?></title>

<script type="text/javascript" src="includes/jquery-1.7.js"></script>
<script type="text/javascript" src="includes/jfusion/fusioncharts.js"></script>
<script type="text/javascript" src="includes/jfusion/themes/fusioncharts.theme.fint.js"></script>

<?php if ($op != 'login') {?>
<script type="text/javascript">
const dataSource = {
  chart: {
    caption: "Concepts idenfified: all",
    xaxisminvalue:   "0",
    xaxismaxvalue:   "100",
    yaxisminvalue:   "0",
    yaxismaxvalue:   "100",
    theme:           "candy",
    basefontsize:    "11",
    plothovereffect: "0"
  },
  dataset: [
    {
      data: [
        {
          id: "N0",
          x: "50",
          y: "45",
          alpha: "0",
          name: "Concepts",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "50",
          imagewidth: "50",
          imageurl: "images/globe.png"
        },
        {
          id: "N1",
          x: "52",
          y: "83",
          alpha: "0",
          label: "Numeracy",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40",
          imageurl: "images/numeracy.png"          
        },
        {
          id: "N2",
          x: "31",
          y: "77",
          alpha: "0",
          label: "Family",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40",
          imageurl: "images/family.jpeg"
        },
        {
          id: "N3",
          x: "18",
          y: "61",
          alpha: "0",
          label: "Human body",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40",
          imageurl: "images/body.jpg"
        },
        {
          id: "N4",
          x: "17",
          y: "37",
          alpha: "0",
          label: "Food",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40",
          imageurl: "images/food.jpeg"
        },
        {
          id: "N5",
          x: "29",
          y: "17",
          alpha: "0",
          label: "Animals",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40",
          imageurl: "images/animals.jpeg"
        },
        {
          id: "N6",
          x: "51",
          y: "11",
          alpha: "0",
          label: "Dressing",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40"
        },
        {
          id: "N7",
          x: "70",
          y: "17",
          alpha: "0",
          label: "Mode of life",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40"
        },
        {
          id: "N8",
          x: "81",
          y: "34",
          alpha: "0",
          label: "Environment",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40",
          imageurl: "images/environment.jpeg"
        },
        {
          id: "N9",
          x: "79",
          y: "56",
          alpha: "0",
          label: "Language loans",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40"
        },
        {
          id: "N10",
          x: "71",
          y: "76",
          alpha: "0",
          label: "Intra-Omo-Tana words",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40"
        }
      ]
    }
  ],
  connectors: [
    {
      stdthickness: "2",
      connector: [
        {
          from: "N0",
          to: "N1",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "N0",
          to: "N2",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "N0",
          to: "N3",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "N0",
          to: "N4",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "N0",
          to: "N5",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "N0",
          to: "N6",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "N0",
          to: "N7",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "N0",
          to: "N8",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "N0",
          to: "N9",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "N0",
          to: "N10",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        }                
      ]
    }
  ]
};
        
FusionCharts.ready(function() {
  var myChart = new FusionCharts({
    type: "dragnode",
    renderAt: "onto-chart-container",
    width: "100%",
    height: "87%",
    dataFormat: "json",
    dataSource
  }).render();
});
</script>
<?php } else {?>
<?php }?>

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
<div id="checkError"></div>
<div id="bodyContainer">
	<div id="loginDiv">
		 <form method="post" action="index.php" id="form_search">
			 <input type="hidden" name="op" value="search" id="op" />
			 <input type="hidden" name="concept" value="search" id="concept" />
			 <input type="hidden" name="parent" value="search" id="concept" />
			 <input type="hidden" name="lang" value="<?php echo $lang; ?>" />
			 <input type="submit" value="search on" />
			 <select name="searchtype"><option value="wordlis">Omo-Tana WordList</option>
			 			<option value="SoremaboBaarelda">Soremabo-Baarelda</option>
			 			<option value="SwadishWordList">Swadish Word List</option></select>
			 <strong>Omo-Tana Family Corpus: 7.3 million Lowland East Cushitic words or</strong>
			 <button onclick="goConcept('Concepts', 'N0', 'N0'); return false;">browse concepts</button>
 			 &#8921;&#8921;<strong><a href=".">Home</a> | <a href="?op=manageOtBaseWord&func=edit&wid=1">Edit</a></strong>
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
<div>
</body>
</html>
