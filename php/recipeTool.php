<?php

require_once('db.php');

try {
  $id = isset($_GET['id']) ? $_GET['id'] : '';
  $tool = isset($_GET['tool']) ? $_GET['tool'] : '';
  $recipe = isset($_GET['recipe']) ? $_GET['recipe'] : '';

  switch ($_GET['action']) {
    case 'insert':
      $db->exec('INSERT INTO ZRECIPETOOL (ZTOOL, ZRECIPE) VALUES (' . $tool . ', ' . $recipe . ')');
      $id = $db->lastInsertRowid();
      break;
    case 'update':
      $db->exec('UPDATE ZRECIPETOOL SET ZTOOL=' . $tool . ', ZRECIPE=' . $recipe . ' WHERE Z_PK=' . $id);
      break;
    case 'delete':
      $db->exec('DELETE FROM ZRECIPETOOL WHERE Z_PK=' . $id);
      return;
  }

  if (!isset($id)) {
    return;
  }

  $tool = $db->querySingle('SELECT * FROM ZRECIPETOOL WHERE Z_PK=' . $id, true);

  echo json_encode(array(
      'id' => $id,
      'tool' => $tool['ZTOOL'],
      'recipe' => $tool['ZRECIPE']
  ));
} finally {
  include 'db_cleanup.php';
}
?>