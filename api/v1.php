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
  case 'selectAll':
    echo $dbManager->getFeeding();
    break;
  case 'insert':
    $type = $_GET["typeName"];
    $comment = $_GET["comment"];
    if (isset($type))
      echo $dbManager->insertFeeding($type, $comment);
    break;
}
