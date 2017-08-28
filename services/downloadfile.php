<?php
  session_start();
  $filename = $_SESSION['filename'];
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename="'.basename($filename).'"');
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($filename));
  //file_put_contents('downloadfile.log',$filename, FILE_APPEND | LOCK_EX);
  readfile($filename);
?>
