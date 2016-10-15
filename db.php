<?php
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('info.db');
    }
}
$db = new MyDB();
$favorites = array();

switch ($_GET['cmd']) {
  case 'create':
    createTable($db);
    break;

  case 'getFavorites':
    $favorites = getFavorites($db, $favorites);
    break;

  case 'addFavorite':
    addFavorite($db, $_GET['name'], $_GET['value']);
    break;


  default:
    # code...
    break;
}

function executeQuery($inputQuery, $db){
  $query = $inputQuery;
  $results = $db->query($query);

  return $results;
}

function createTable($db){
  $query = 'CREATE TABLE favorites (id int, name varchar(255), value varchar(255))';
  executeQuery($query, $db);
}

function getFavorites($db, $favorites){
  $query = 'SELECT value FROM favorites;';
  $results = executeQuery($query, $db);
  $favorites = $results->fetchArray();

  foreach ($favorites as $favorite) {
    array_push($favorites, $favorite);
  }

  return $favorites;
}

function addFavorite($db, $name, $val){
  $query = "INSERT INTO favorites (name, value) VALUES ('" . $name . "', '" . $val . "');";
  echo $query;
  executeQuery($query, $db);
}

?>
