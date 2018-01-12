<?php

class DBManager {
  private $configFile = '../config.ini';
  private $db_url;
  private $db_port;
  private $db_name;
  private $db_username;
  private $db_password;
  private $timezone;

  function __construct() {
    $ini_array = parse_ini_file($this->configFile);
    $this->db_url = $ini_array['db_url'];
    $this->db_port = $ini_array['db_port'];
    $this->db_name = $ini_array['db_name'];
    $this->db_username = $ini_array['db_username'];
    $this->db_password = $ini_array['db_password'];
    $tz = $ini_array['timezone'];
    $this->timezone = isset($tz) ? $tz : date_default_timezone_get();
    $limit = $ini_array['results_limit'];
    $this->limit = isset($limit) ? $limit : 0;
    
  }

  private function getDB() {
    $atrr = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $db = new PDO('mysql:host=' . $this->db_url . ';dbname=' . $this->db_name
            . ';port=' . $this->db_port, $this->db_username, $this->db_password, $atrr);
    $db->query('SET NAMES utf8');
    return $db;    
  }

  function insertFeeding($type) {
    $db = $this->getDB();
    $typeName = $db->quote($type);
    $timestamp = new DateTime("now", new DateTimeZone($this->timezone));
    $date = $timestamp->format("Y-m-d H:i:s");
    $query = "INSERT INTO feeding SET feeding_time='$date', type_id=(SELECT type_id FROM types WHERE type_name=$typeName)";
    $rows['type_name'] = $typeName;
    $rows['rows'] = $db->exec($query);
    return json_encode($rows);

  }

  function getFeeding($limit = 0) {
    $db = $this->getDB();
    $sLimit = $limit != 0 ? "LIMIT $limit" : ''; 
    $data = $db->query("SELECT feeding_id, feeding_time, type_name, type_colour, comments FROM feeding f inner join types t on f.type_id = t.type_id ORDER BY feeding_id DESC $sLimit")->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($data);
  }

  function getFeedingLimit() {
   return $this->getFeeding($this->limit);
  }
  
  function getTypes() {
    $db = $this->getDB();
    $data = $db->query("SELECT type_id, type_name, type_colour FROM types")->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($data);
  }
}
