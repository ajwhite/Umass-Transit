<?php

class Friend_model extends CI_Model
{
	function __construct(){
		parent::__construct();
	}
	
	
	// do a quick login, no auth for the proto
	function getFriends($userID=null){
		if (!isset($userID))
			$userID = $this->session->userdata('id');
		$queryStr = "SELECT * FROM Connections 
			JOIN User ON User.userID = receiverID
			WHERE requestorID = '$userID'";
		$query = $this->db->query($queryStr);
		$friends = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$friends[] = array(
					'userID' => $row->userID,
					'name'   => $row->name
				);
			}
		}
		return $friends;
	}
	
	
	function getFriendsRoutes($userID=null){
		if(!isset($userID))
			$userID = $this->session->userdata('id');
		$queryStr = "SELECT
				u.userID, u.name, r.routeID, r.nickname,
				locStart.name AS startName, locStart.address AS startAddress,
				locEnd.name AS endName, locEnd.address AS endAddress
			FROM Connections c
				JOIN User u ON u.userID = c.receiverID
				LEFT JOIN Routes r ON r.userID = c.receiverID
				LEFT JOIN Locations locStart ON locStart.locationID = r.startLocationID
				LEFT JOIN Locations locEnd   ON locEnd.locationID = r.endLocationID
			WHERE requestorID = '$userID'
			ORDER BY 
				u.name ASC, locStart.name ASC";
		$query = $this->db->query($queryStr);
		
		$friends = array();
		if ($query->num_rows() > 0){
			$trackingID = null;
			foreach($query->result() as $row){
				// track the last user to build user related route lists
				if (!isset($trackingID))
					$trackingID = $row->userID;
				// reinitialize route array for next user if they have routes
				if ($trackingID != $row->userID){
					if (isset($row->routeID)){
						$routes = array();
					} else {
						$routes = null;
					}
				}
				
				if (isset($row->routeID))
					$routes[] = array(
						'start'   => $row->startName,
						'end'     => $row->endName,
						'routeID' => $row->routeID,
						'nickname'=> $row->nickname
					);
				
				$friends[$row->userID] = array(
					'userID' => $row->userID,
					'name'   => $row->name,
					'routes' => isset($routes) ? $routes : null
				);
				$trackingID = $row->userID;
			}
		}
		return $friends;
	}

}
