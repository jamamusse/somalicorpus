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

<?php if ($op != 'login') {?>
<script type="text/javascript">
const dataSource = {
  chart: {
    caption: "Concepts idenfified",
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
          imagewidth: "40"
        },
        {
          id: "N2",
          x: "31",
          y: "77",
          alpha: "0",
          label: "Familiy",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40"
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
          imagewidth: "40"
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
          imageurl: "https://s8.postimg.cc/3qz87kmut/electronics.png"
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
          imageurl: "https://s8.postimg.cc/3qz87kmut/electronics.png"
        },
        {
          id: "N6",
          x: "51",
          y: "11",
          alpha: "0",
          label: "Fishing",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40",
          imageurl: "https://s8.postimg.cc/3qz87kmut/electronics.png"
        },
        {
          id: "N7",
          x: "70",
          y: "17",
          alpha: "0",
          label: "Agriculture",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40",
          imageurl: "https://s8.postimg.cc/3qz87kmut/electronics.png"
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
          imagewidth: "40"
        },
        {
          id: "N9",
          x: "79",
          y: "56",
          alpha: "0",
          label: "Loans",
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
          label: "Language shift",
          radius: "50",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40",
          imageurl: "https://s8.postimg.cc/3qz87kmut/electronics.png"
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
        
const dataSource1 = {
  chart: {
    caption: "Concepts idenfified",
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
          id: "isp",
          x: "80",
          y: "83",
          alpha: "0",
          name: "ISP",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "50",
          imagewidth: "50",
          imageurl: "https://s8.postimg.cc/k0pea9uw5/globe.png"
        },
        {
          id: "modem",
          x: "55",
          y: "83",
          alpha: "0",
          label: "Modem",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "40",
          imageurl: "https://s8.postimg.cc/3qz87kmut/electronics.png"
        },
        {
          id: "router",
          x: "45",
          y: "65",
          alpha: "0",
          name: "Master Router",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "40",
          imagewidth: "50",
          imageurl: "https://s8.postimg.cc/io7p89uut/router.png"
        },
        {
          id: "subrouter1",
          x: "20",
          y: "55",
          alpha: "0",
          name: "Sub Router 1",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "40",
          imagewidth: "50",
          imageurl: "https://s8.postimg.cc/io7p89uut/router.png"
        },
        {
          id: "subrouter2",
          x: "75",
          y: "45",
          alpha: "0",
          name: "Sub Router 2",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "40",
          imagewidth: "50",
          imageurl: "https://s8.postimg.cc/io7p89uut/router.png"
        },
        {
          id: "subrouter3",
          x: "40",
          y: "45",
          alpha: "0",
          name: "Sub Router 3",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "40",
          imagewidth: "50",
          imageurl: "https://s8.postimg.cc/io7p89uut/router.png"
        },
        {
          id: "desktop-srouter1",
          x: "10",
          y: "30",
          alpha: "0",
          name: "Public Desktop",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "40",
          imagewidth: "50",
          imageurl: "https://s8.postimg.cc/b9idg2911/multimedia.png"
        },
        {
          id: "nas-srouter1",
          x: "10",
          y: "65",
          alpha: "0",
          name: "Network Storage",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "20",
          imagewidth: "30",
          imageurl: "https://s8.postimg.cc/mymd3sfcl/nas.png"
        },
        {
          id: "mobile1-srouter2",
          x: "65",
          y: "20",
          alpha: "0",
          label: "Ronnie's Mobile",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "15",
          imageurl: "https://s8.postimg.cc/ec4ebmm0l/image.png"
        },
        {
          id: "mobile2-srouter2",
          x: "90",
          y: "25",
          alpha: "0",
          label: "Julliet's Mobile",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "15",
          imageurl: "https://s8.postimg.cc/ec4ebmm0l/image.png"
        },
        {
          id: "laptop1-srouter2",
          x: "80",
          y: "15",
          alpha: "0",
          name: "Romeo's Laptop",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "45",
          imagewidth: "60",
          imageurl: "https://s8.postimg.cc/qd94xq5at/new_laptop.png"
        },
        {
          id: "st-srouter3",
          x: "30",
          y: "20",
          alpha: "0",
          name: "Smart TV",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "40",
          imagewidth: "50",
          imageurl: "https://s8.postimg.cc/wbmy7t3n9/image.png"
        },
        {
          id: "desktop-srouter3",
          x: "45",
          y: "15",
          alpha: "0",
          name: "Amy's Desktop",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "40",
          imagewidth: "50",
          imageurl: "https://s8.postimg.cc/b9idg2911/multimedia.png"
        },
        {
          id: "mobile-srouter3",
          x: "55",
          y: "35",
          alpha: "0",
          label: "Amy's Mobile",
          radius: "60",
          shape: "CIRCLE",
          imagenode: "1",
          imagealign: "MIDDLE",
          imageheight: "30",
          imagewidth: "15",
          imageurl: "https://s8.postimg.cc/ec4ebmm0l/image.png"
        }
      ]
    }
  ],
  connectors: [
    {
      stdthickness: "2",
      connector: [
        {
          from: "isp",
          to: "modem",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "modem",
          to: "router",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "router",
          to: "subrouter1",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "router",
          to: "subrouter2",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "router",
          to: "subrouter3",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "subrouter1",
          to: "desktop-srouter1",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "subrouter1",
          to: "nas-srouter1",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "subrouter2",
          to: "mobile1-srouter2",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "subrouter2",
          to: "mobile2-srouter2",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "subrouter2",
          to: "laptop1-srouter2",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "subrouter3",
          to: "st-srouter3",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "subrouter3",
          to: "desktop-srouter3",
          color: "#1aaf5d",
          strength: "1",
          arrowatstart: "0",
          arrowatend: "0"
        },
        {
          from: "subrouter3",
          to: "mobile-srouter3",
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
<!--h1>Welcome to Cushitic Language Family Corpora</h1-->
<div id="loginDiv">
     <form method="post" action="index.php">
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
