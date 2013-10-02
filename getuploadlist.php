<?php
 $path=realpath('wp-content/uploads');
 $files=array();
 $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
  foreach($objects as $object){
    //echo "$name\n";
    
    if (!$object->isDir()) {
      //var_dump($object);
      $nev=$object->getFilename();
      $aktpath=$object->getPath();
      $aktpath=str_replace($path,'',$aktpath);
      $files[] = $aktpath.'/'.$nev;
      
    }
  }


if (count($files)>0) {
  echo json_encode($files);
  
}  
?>