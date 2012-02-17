<?php

class hack_google
{
	private $startLocation = "Hadley, MA";
	private $endLocation = "1001 N Pleasant St Amherst, MA";
	private $htmlDom;
	private $ci;
	private $url = "http://maps.google.com/m/directions";

	public function __construct($start = "1001 N Pleasant St Amherst, MA", $end = "Hadley, MA"){
		$this->startLocation = $start;
		$this->endLocation = $end;
		$this->ci =& get_instance();
		$this->ci->load->library('simple_html_dom');
	}
	
	function hack(){
		$html = $this->fetchHTML();
		$rows = $this->getAllRows($html);
		return $rows;	
	}
	
	public function hackBus(){
		$html = $this->fetchHTML();
		$rows = $this->getDirectionRows($html);
		return $rows;
	}
	
	private function getBusRows($html){
		$count = 0;
		$rows = null;
		foreach($html->find('div') as $div){
			if ($count == 2){
				$busRow = false;
				foreach($div->find('div') as $child){
					$busRow = false;
					foreach($child->find('img') as $img){
						if (strpos($img->src, "bus.png"))
							$busRow = true;
							break;
					}
					if ($busRow){
						$rows[] = $child;
						break;
					}
				}
			}
			$count++;
		}
		return $rows;
	}
	
	private function getDirectionRows($html){
		$count = 0;
		$rows = null;
		$segment = 0;
		foreach($html->find('div') as $div){
			if ($count == 2){
				foreach($div->find('div') as $i=>$child){
					$busRow = false;
					$walkRow = false;
					
					foreach($child->find('img') as $img){
						if (strpos($img->src, "bus.png")){
							$busRow = true;
							break;
						} 
						if (strpos($img->src,"walk.png")){
							$walkRow = true;
							break;
						}
					}
					
					if ($busRow){
						$rows[] = $child;
					}
					
				}
			}
			$count++;
		}
		return $rows;
	
	}
	
	private function getAllRows($html){
		$count = 0;
		$rows = null;
		foreach($html->find('div') as $div){
			if ($count == 2){
				$_c = 0;
				foreach($div->find('div') as $child){
						$rows[] =  $child;
					$_c++;
				}
			}
			$count++;
		}
		return $rows;
	}
	
	private function fetchHTML(){
		$date = "2011-11-30";
		$time = "8:48pm";
		$start = $this->startLocation;
		$end = $this->endLocation;
		$start = str_replace(" ", "+", $start);
		$end = str_replace(" ", "+", $end);
		$date = str_replace(" ", "+", $date);
		$time = str_replace(" ", "+", $start);
		
		$url = "http://maps.google.com/m/directions?saddr=$start&daddr=$end&dirflg=r&hl=en&ri=0&date=$date&time=$time";
		echo "[googleHack] -----> Streaming $url<br/>";
		$html = file_get_html($url);
		return $html;
	}
	
	
}

?>