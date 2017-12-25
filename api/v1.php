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
    $this->timezone = $ini_array['timezone'];
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
    $db->query("INSERT INTO feeding SET feeding_time='$date', type_id=(SELECT type_id FROM types WHERE type_name=$typeName)");
  }

  function getFeeding() {
    $db = $this->getDB();
    $data = $db->query('SELECT feeding_id, feeding_time, type_name, comments FROM feeding f inner join types t on f.type_id = t.type_id ORDER BY feeding_id DESC')->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($data);
  }
}

$dbManager = new DBManager;

$operation = $_GET["operation"];

if ($operation == 'select')
  echo $dbManager->getFeeding();
else if ($operation == 'insert') {
  $type = $_GET["typeName"];
  if (isset($type))
    $dbManager->insertFeeding($type);
}
