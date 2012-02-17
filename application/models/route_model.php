<?php

class Route_model extends CI_Model
{
	function __construct(){
		parent::__construct();
	}
	
	function getRoute($routeID){
		$queryStr = "SELECT
				r.routeID, r.nickname,
				locStart.name AS startName, locStart.address AS startAddress,
				locEnd.name AS endName, locEnd.address AS endAddress
			FROM Routes r
				LEFT JOIN Locations locStart ON locStart.locationID = r.startLocationID
				LEFT JOIN Locations locEnd   ON locEnd.locationID = r.endLocationID
			WHERE r.routeID = '$routeID'";
		$query = $this->db->query($queryStr);
		
		$route;
		if ($query->num_rows() > 0){
			$result = $query->result();
			$route = $result[0];
		}
		return $route;
	}
	
	function getUserRoutes($userID = null){
		if(!isset($userID))
			$userID = $this->session->userdata('id');
		$queryStr = "SELECT
				r.routeID, r.nickname,
				locStart.name AS startName, locStart.address AS startAddress,
				locEnd.name AS endName, locEnd.address AS endAddress
			FROM Routes r
				JOIN Locations locStart ON locStart.locationID = r.startLocationID
				JOIN Locations locEnd   ON locEnd.locationID = r.endLocationID
			WHERE r.userID = '$userID'
			ORDER BY locStart.name";
		$query = $this->db->query($queryStr);
		$routes=null;
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$routes[] = $row;
			}
		}

		return $routes;
	}

}
