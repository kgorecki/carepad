<?php
$atrr = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$db = new PDO('mysql:host={host};dbname={dbname};port=3306', '{dbuser}', '{password}', $atrr);
$db->query('SET NAMES utf8');
$data = $db->query('SELECT feeding_id, feeding_time, type_name, comments FROM feeding f inner join types t on f.type_id = t.type_id ORDER BY feeding_id DESC')->fetchAll(PDO::FETCH_ASSOC);
header('Content-type: application/json');
echo json_encode($data);
