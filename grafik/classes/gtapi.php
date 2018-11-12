<?php

error_reporting(0);

class kevia_gt_api {

	private $apilink;
	private $ip;
	private $port;

	/* FOR PLAYER GRAFICON */

	private $plot;
	private $graph;
	private $graphtime;
	private $logplayer;

	/* FOR GetServerHostedMap */

	private $servergeomap;

	function __construct($serverip, $serverport) {

		$this->apilink = json_decode(@file_get_contents('http://api.gametracker.rs/demo/json/server_info/' . $serverip . ':' . $serverport));
		$this->ip 	= $serverip;
		$this->port = $serverport;

	}

	public function gt_platyer() {
		return $players_day 	= $this->apilink->players_day;
	}

	public function GTBigGraficonPlayer() {

		require_once('graficon/phplot.php');
		
		$players_day 	= explode(':', $this->apilink->players_day);
		$replacetime	= array('-1' => 23, '-2' => 22, '-3' => 21, '-4' => '20', '-5' => 19, '-6' => 18, '-7' => 17, '-8' => 16, '-9' => 15, '-10' => 14, '-11' => 13, '-12' => 12, '-13' => 11, '-14' => 10);

		$playersmax 		= $this->apilink->playersmax;
		$this->plot 		= new PHPlot(500,150);

		$this->plot->SetYTickIncrement(16);
		$this->plot->SetPlotType('lines');

		$this->graph = array();
		for ($i = 24; $i >= 0; $i--){
	        if ($i / 2 == round($i / 2)){
	            $vreme = $i;
	            $this->graphtime = date("H") - $vreme;
	            if(substr_count($this->graphtime, '-') > 0) {
	            	$this->graphtime = $replacetime[$this->graphtime];
	            }
	        } else {
	            $this->graphtime = "";
	        }

	        $this->logplayer = array_chunk($players_day, 2);

	        $countval = count($this->logplayer);
	        for($k=0; $k <= 1; $k++){
	        	if($i == 24) {
	        		$broj = isset($this->logplayer[24][0]) ? $this->logplayer[24][0] : $this->logplayer[24][0] = round(($this->logplayer[15][0] + $this->logplayer[23][1]) / 2);
	        	} else {
	            	$broj = round(($broj + $this->logplayer[$i][$k]) / 2);
	        	}
	        }
	 
	 
	        $broj = $broj;
	        
	        if (!is_numeric($broj)){
	            $broj=0;
	        }

	        if(!isset($broj)){
	            $broj=0;
	        }

	        array_push($this->graph, array($this->graphtime, $broj));
		}

		$this->plot->SetDataValues($this->graph);
		$this->plot->SetPlotBorderType("left");

		$this->plot->SetXTickLength("5");
		$this->plot->SetXTickIncrement(22);
		$this->plot->SetPrecisionX(0);
		$this->plot->SetYTickIncrement($playersmax / 5);
		$this->plot->SetLightGridColor("kevia");
		$this->plot->SetDrawDashedGrid("solid");
		$this->plot->SetDrawYGrid("solid");
		$this->plot->SetBackgroundColor("kevia");
		$this->plot->SetDataColors('#0ba3fd');
		$this->plot->SetTextColor("white");
		$this->plot->SetGridColor("white");
		$this->plot->SetDrawXGrid(True);
		$this->plot->SetDrawYGrid(True);
		$this->plot->SetPlotAreaWorld(null, 0, null, $playersmax);

		return $this->plot->DrawGraph();
	}
	public function GTBaner() {

		require_once('graficon/phplot.php');
		
		$players_day 	= explode(':', $this->apilink->players_day);
		$replacetime	= array('-1' => 23, '-2' => 22, '-3' => 21, '-4' => '20', '-5' => 19, '-6' => 18, '-7' => 17, '-8' => 16, '-9' => 15, '-10' => 14, '-11' => 13, '-12' => 12, '-13' => 11, '-14' => 10);

		$playersmax 		= $this->apilink->playersmax;
		$this->plot 		= new PHPlot(169,80);

		$this->plot->SetYTickIncrement(16);
		$this->plot->SetPlotType('lines');

		$this->graph = array();
		for ($i = 24; $i >= 0; $i--){
	        if ($i / 6 == round($i / 6)){
	            $vreme = $i / 3;
	            $this->graphtime = date("H") - $vreme;
	            if(substr_count($this->graphtime, '-') > 0) {
	            	$this->graphtime = $replacetime[$this->graphtime];
	            }
	        } else {
	            $this->graphtime = "";
	        }

	        $this->logplayer = array_chunk($players_day, 2);

	        $countval = count($this->logplayer);
	        for($k=0; $k <= 1; $k++){
	        	if($i == 24) {
	        		$broj = isset($this->logplayer[24][0]) ? $this->logplayer[24][0] : $this->logplayer[24][0] = round(($this->logplayer[15][0] + $this->logplayer[23][1]) / 2);
	        	} else {
	            	$broj = round(($broj + $this->logplayer[$i][$k]) / 2);
	        	}
	        }
	 
	 
	        $broj = $broj;
	        
	        if (!is_numeric($broj)){
	            $broj=0;
	        }

	        if(!isset($broj)){
	            $broj=0;
	        }

	        array_push($this->graph, array($this->graphtime, $broj));
		}

		$this->plot->SetDataValues($this->graph);
		$this->plot->SetPlotBorderType("left");

		$this->plot->SetXTickLength("3");
		$this->plot->SetXTickIncrement(22);
		$this->plot->SetPrecisionX(0);
		$this->plot->SetYTickIncrement($playersmax / 4);
		$this->plot->SetLightGridColor("kevia");
		$this->plot->SetDrawDashedGrid("solid");
		$this->plot->SetDrawYGrid("solid");
		$this->plot->SetBackgroundColor("kevia");
		$this->plot->SetDataColors('#0ba3fd');
		$this->plot->SetTextColor("white");
		$this->plot->SetGridColor("white");
		$this->plot->SetDrawXGrid(True);
		$this->plot->SetDrawYGrid(True);
		$this->plot->SetPlotAreaWorld(null, 0, null, $playersmax);

		return $this->plot->DrawGraph();
	}
}

?>
