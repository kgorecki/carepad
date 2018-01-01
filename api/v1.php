<?php

require_once("dbmanager.php");

$dbManager = new DBManager;

$operation = $_GET["operation"];
switch ($operation) {
  case 'getTypes':
    echo $dbManager->getTypes();
    break;
  case 'select':
    echo $dbManager->getFeedingLimit();
    break;
  case 'insert':
    $type = $_GET["typeName"];
    if (isset($type))
      $dbManager->insertFeeding($type);
    break;
}