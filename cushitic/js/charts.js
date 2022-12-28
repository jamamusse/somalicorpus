const dataSource = {
  chart: {
    caption: "",
    theme: "fusion",
    viewmode: "1",
    showrestorebtn: "0",
    valuefontcolor: "#FFFFFF",
    yaxismaxvalue: "1100",
    yaxisminvalue: "0",
    divlinealpha: "0"
  },
  dataset: [
    {
      data: [
        {
          id: "01",
          label: "Cushitic<br/>(7,376,874 words)",
	  	  color: "FE3233",
          x: "50",
          y: "1050",
          shape: "rectangle",
          width: "120",
          height: "40"
        },
        {
          id: "02",
          label: "North Cushitic<br/>(Beja)",
          x: "32",
          y: "880",
          shape: "rectangle",
          width: "120",
          height: "40"
        },
        {
          id: "03",
          label: "Centeral Cushitic<br/>(Agow)",
          x: "44",
          y: "880",
          shape: "rectangle",
          width: "120",
          height: "40"
        },
        {
          id: "04",
          label: "East Cushitic<br/>(7,376,874 words)",
          x: "57",
          y: "880",
          shape: "rectangle",
          width: "120",
          height: "40"
        },
        {
          id: "05",
          label: "Southern Cushitic<br/>(Iraqw, Algawa, Buringe)",
          x: "70",
          y: "880",
          shape: "rectangle",
          width: "140",
          height: "40"
        },
        {
          id: "04.1",
          label: "Highland East Cushitic<br/>(Burji, Hadiya, Sidama)",
          x: "43",
          y: "680",
          shape: "rectangle",
          width: "120",
          height: "40"
        },
        {
          id: "04.2",
          label: "Lowland East Cushitic<br/>(7,376,874 words)",
          x: "57",
          y: "680",
          shape: "rectangle",
          width: "120",
          height: "40"
        },
        {
          id: "04.3",
          label: "Yaaku/Dulley",
          x: "70",
          y: "680",
          shape: "rectangle",
          width: "100",
          height: "40"
        },
        {
          id: "04.2.1",
          label: "Oromoide",
          x: "41",
          y: "530",
          shape: "rectangle",
          width: "160",
          height: "40"
        },
	{
          id: "04.2.2",
          label: "Omo-Tana<br/>(7,156,000 words)",
	  color: "FE3233",
          x: "57",
          y: "530",
          shape: "rectangle",
          width: "160",
          height: "40"
        },
        {
          id: "04.2.3",
          label: "Saho/Afar<br/>(250,000 words)",
	  color: "FE3233",
          x: "73",
          y: "530",
          shape: "rectangle",
          width: "160",
          height: "40",
          link: "n-http://www.somalicorpus.com/saho"
        },
        {
          id: "04.2.2.1",
          label: "Eastern Omo-Tana",
          x: "35",
          y: "300",
          shape: "rectangle",
          width: "160",
          height: "40"
        },
        {
          id: "04.2.2.2",
          label: "Central Omo-Tana",
          x: "57",
          y: "300",
          shape: "rectangle",
          width: "160",
          height: "40"
        },
        { 
          id: "04.2.2.3",
          label: "Western Omo-Tana",
          x: "79",
          y: "300",
          shape: "rectangle",
          width: "160",
          height: "40"
        },
	{
          id: "04.2.2.1.1",
	  color: "FE3233",
          label: "Soomaali<br/>(7,283,666 words)",
          x: "6",
          y: "100",
          shape: "rectangle",
          width: "140",
          height: "40",
	  link: "n-http://www.somalicorpus.com"
        },
	{
          id: "04.2.2.1.2",
          label: "Rendille<br/>(4,004 words)",
	  color: "FE3233",
          x: "19",
          y: "100",
          shape: "rectangle",
          width: "140",
          height: "40",
          link: "n-http://www.somalicorpus.com/bayso"
        },
	{
          id: "04.2.2.1.3",
	  color: "FE3233",
          label: "Maay<br/>(1500 words)",
          x: "31",
          y: "100",
          shape: "rectangle",
          width: "140",
          height: "40"
        },
	{
          id: "04.2.2.1.4",
	  color: "FE3233",
          label: "Boni<br/>(500 words)",
          x: "43",
          y: "100",
          shape: "rectangle",
          width: "140",
          height: "40"
        },
	{
          id: "04.2.2.2.1",
	  color: "FE3233",
          label: "Bayso<br/>(1000 words)",
          x: "57",
          y: "100",
          shape: "rectangle",
          width: "140",
          height: "40"
        },
        {
          id: "04.2.2.3.1",
	  color: "FE3233",
          label: "Arbore<br/>(500 words)",
          x: "72",
          y: "100",
          shape: "rectangle",
          width: "140",
          height: "40"
        },
        {
          id: "04.2.2.3.2",
	  color: "FE3233",
          label: "El Molo<br/>(300 words)",
          x: "84",
          y: "100",
          shape: "rectangle",
          width: "140",
          height: "40"
        },
        {
          id: "04.2.2.3.3",
	  color: "FE3233",
          label: "Dasanech<br/>(1500 words)",
          x: "95",
          y: "100",
          shape: "rectangle",
          width: "120",
          height: "40"
        }

      ]
    }
  ],
  connectors: [
    {
      stdthickness: "1.5",
      connector: [
        {
          from: "01",
          to: "02",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "01",
          to: "03",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "01",
          to: "04",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "01",
          to: "05",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "01.02",
          to: "04",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "01.01",
          to: "02",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "02",
          to: "02.1",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "02",
          to: "02.2",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "02",
          to: "02.3",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "04",
          to: "04.1",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "04",
          to: "04.2",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "04",
          to: "04.3",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
	{
          from: "04.2",
          to: "04.2.1",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
	{
          from: "04.2",
          to: "04.2.2",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "04.2",
          to: "04.2.3",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
	{
          from: "04.2.2",
          to: "04.2.2.1",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
	{
          from: "04.2.2",
          to: "04.2.2.2",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
	{
          from: "04.2.2",
          to: "04.2.2.3",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
	{
          from: "04.2.2.1",
          to: "04.2.2.1.1",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
	{
          from: "04.2.2.1",
          to: "04.2.2.1.2",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
	{
          from: "04.2.2.1",
          to: "04.2.2.1.3",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
	{
          from: "04.2.2.1",
          to: "04.2.2.1.4",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
	{ 
          from: "04.2.2.2",
          to: "04.2.2.2.1",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
	{ 
          from: "04.2.2.3",
          to: "04.2.2.3.1",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
        },
        {
          from: "04.2.2.3",
          to: "04.2.2.3.2",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
	},
        {
          from: "04.2.2.3",
          to: "04.2.2.3.3",
          arrowatstart: "0",
          arrowatend: "1",
          alpha: "100"
	}
      ]
    }
  ]
};

FusionCharts.ready(function() {
  var myChart = new FusionCharts({
    type: "dragnode",
    renderAt: "chart-container",
    width: "100%",
    height: "90%",
    dataFormat: "json",
    dataSource
  }).render();
});

