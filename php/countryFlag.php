<?php

require_once('db.php');
require_once('imageManipulator.php');

try {
  $id = isset($_GET['id']) ? $_GET['id'] : '';

  if (!empty($_FILES)) {
    $country = $db->querySingle('SELECT * FROM ZCOUNTRY WHERE Z_PK=' . $id, true);

    $validExtensions = array('.jpg', '.jpeg', '.gif', '.png', '.JPG', '.JPEG');
    // get extension of the uploaded file
    $fileExtension = strrchr($_FILES['file']['name'], ".");
    // check if file Extension is on the list of allowed ones
    if (in_array($fileExtension, $validExtensions)) {
      $newNamePrefix = time() . '_';
      $manipulator = new ImageManipulator($_FILES['file']['tmp_name']);

      $db->exec('UPDATE ZCOUNTRY SET ZFLAG="images/' . $country['ZCODE'] . '_flag' . $fileExtension . '" WHERE Z_PK=' . $country['Z_PK']);

      // saving file to uploads folder
      $manipulator->save('../images/' . $country['ZCODE'] . '_flag' . $fileExtension);
    } else {

    }
  }
} finally {
  include 'db_cleanup.php';
}
?>