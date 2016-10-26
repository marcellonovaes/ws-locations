<?php

class MySql { 
    public $user = 'novaes';
    public $password = 'azsxdc';
    //public $host = "https://locations-novaes.c9users.io";
    public $host = "127.0.0.1";
    public $database = 'ws-locations';
    public $connection;
    
    function __construct(){
        	$this->connection = mysql_connect($this->host, $this->user, $this->password) or print (mysql_error()); 
        	
	        mysql_select_db($this->database, $this->connection) or print(mysql_error()); 
    }

    function getCategories(){
        $sql = "SELECT * FROM Categories";
        $result = mysql_query($sql, $this->connection); 
        $categories = null;
        while($row = mysql_fetch_array($result)){
            $categories[] = array('_ID' => $row['_ID'],'label' => $row['label']);
        }
        return json_encode($categories);
    }


    function getLocations(){
        $sql = "SELECT * FROM Locations";
        $result = mysql_query($sql, $this->connection); 
        $locations = null;
        while($row = mysql_fetch_array($result)){
            $locations[] = array('_ID' => $row['_ID'],'label' => $row['label'],'latitude' => $row['latitude'],'longitude' => $row['longitude'],'category' => $row['category']);
        }
        return json_encode($locations);
    }
    
    function putLocation($data){
        $json = json_decode($data);
        $sql = "INSERT INTO `Locations` (`_ID`, `label`, `latitude`, `longitude`, `category`) VALUES (NULL, '".$json->{'label'}."', '".$json->{'latitude'}."', '".$json->{'longitude'}."', '".$json->{'category'}."')";
        mysql_query($sql, $this->connection); 
    }

} 

foreach($_GET as $key=>$value)  $$key = $value;
foreach($_POST as $key=>$value) $$key = $value;


$database = new MySql();

switch ($action) {
    case 'getCategories':
        echo $database->getCategories();
        break;
    case 'getLocations':
        echo $database->getLocations();
        break;
    case 'putLocation':
        $database->putLocation($data);
}


?>