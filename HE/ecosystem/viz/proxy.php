<?PHP

if($_REQUEST["url"]){
  $filename = $_GET['url'];
  $ext = pathinfo($filename, PATHINFO_EXTENSION);

  switch ($ext) {
  case "jpg":
      header('Content-Type: image/jpeg');
      readfile($filename);
      break;
  case "gif":
      header('Content-Type: image/gif');
      readfile($filename);
      break;
  case "png":
      header('Content-Type: image/png');
      readfile($filename);
      break;
  default:
      header('Content-Type: text/xml');
      readfile($filename);
      break;
  }
}

?>