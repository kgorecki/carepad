<?php
$atrr = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$db = new PDO('mysql:host={host};dbname={dbname};port=3306', '{dbuser}', '{password}', $atrr);
$typeName = $db->quote($_GET["typeName"]);
$db->query('SET NAMES utf8');
$data = $db->query('INSERT INTO feeding SET feeding_time=NOW(), type_id=(SELECT type_id FROM types WHERE type_name='.$typeName.')');
header('Content-type: application/json');
