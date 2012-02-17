<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Routes extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->user_model->loggedIn()){
			$this->session->set_flashdata('login_required', 'true');
			redirect('/');
		} 
		$this->load->model('route_model');
	}
	

	public function index()
	{
		$data['routes'] = $this->route_model->getUserRoutes();
		$data['content'] = 'routes/my_routes';
		$this->load->view('template/mobile_template', $data);
	}
	
	function view($routeID){
		$data['route'] = $this->route_model->getRoute($routeID);
		$data['content'] = 'routes/route';
		$this->load->view('template/mobile_template', $data);
	}
	function myview($routeID){
		$data['route'] = $this->route_model->getRoute($routeID);
		$data['content'] = 'routes/my_route';
		$this->load->view('template/mobile_template', $data);
	}
	
	function save(){
		$user = $this->session->userdata('id');
		$nickname = $this->input->post('nickname');
		$this->db->insert('Routes', array('userID' => $user, 'startLocationID'=>1, 'endLocationID'=>2, 'nickname'=>$nickname));
	}
	
	function delete(){
		$route = $this->input->post('routeID');
		$this->db->where('routeID', $route);
		$this->db->delete('Routes');
	}
	
	public function ghack(){
		include (getcwd()."/application/views/template/header.php");
		?>
		bizzle type yo address
		<br/>
		start <input type="text" value="1001 N Pleasant St Amherst, MA" id="start"/>
		end <input type="text" value="Amherst,MA" id="end"/>
		filter
		<select id="filter">
			<option value="FILTER_ALL">all data</option>
			<option value="FILTER_BUS_ONLY">only bus</option>
			<option value="FILTER_NO_ROUTE">no alternate route</option>
			<option VALUE="FILTER_ALT_ROUTE">alternate routes</option>
		</select>
		<input type="button" value="fetch" id="go"/>
		
		<div id="response" style="display:none;margin-top:10px; border-top:2px solid gray;"></div>

		
		
		
		<script type="text/javascript">
		$(document).ready(function(){
			$("#go").click(function(){
				$.post('/routes/do_gHack',
					{
						start: $("#start").val(),
						end: $("#end").val(),
						filter: $("#filter").val()
					},
					function(response){
						$("#response").html("");
						$("#response").append(response).show();
					});
			});
		});
		</script>
		<?php
		include (getcwd()."/application/views/template/footer.php");

	}
	
	function do_gHack(){
		echo "<pre>";
		echo "[googleHack] -----> Loading usability libraries..<br/>";
		$this->load->library('hack_google');
		echo "[googleHack] -----> Usability library loaded.<br/>";
		
		echo "[googleHack] -----> requesting POST data...<br/>";
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$filter = $this->input->post('filter');
		echo "[googleHack] -----> START ADDRESS = $start<br/>";
		echo "[googleHack] -----> END ADDRESS = $end<br/>";
		echo "[googleHack] -----> FILTER = $filter<br/>";		
		echo "[googleHack] -----> Scraping google site...<br/>";
		
		echo "[googleHack] -----> SCRAPE COMPLETE...<br/>";
		
		echo "[googleHack] -----> FILTERING...<br/>";
		$hack = new hack_google($start, $end);
		
		if ($filter == "FILTER_ALL"){
			$rows = $hack->hack();
		}
		if ($filter == "FILTER_BUS_ONLY"){
			$rows = $hack->hackBus();
		}
		echo "[googleHack] -----> FILTER COMPLETE<br/>";
		echo "[googleHack] -----> Determining important rows....<br/>";
		echo "[googleHack] -----> Thinking...<br/>";

		if (isset($rows)){
			foreach($rows as $i=>$row){
				 echo "A$i<br/>";
				 echo $row;
				 //echo print_r($row, true);
			}
		}
		if (!isset($rows)) {
			echo "[googleHack] -----> [ERROR] NO DIRECTIONS FOUND BY GOOGLE <br/>";
		}
		
		echo "[googleHack] -----> DONE";
		echo "</pre>";
	}

}
