<?php
    /* curl-lal lekérjük az angol könyvtárban lévő fileneveket */
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,"http://almoneira.com/getuploadlist.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec ($curl);
    curl_close ($curl);
    $en_files = json_decode($result);
    
    
    //lekérjük a magyar könyvtárban lévő fileneveket
    $hu_files=array();
    $path=realpath('wp-content/uploads');
   
    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
    foreach($objects as $object){
      if (!$object->isDir()) {
        $nev=$object->getFilename();
        $aktpath=$object->getPath();
        $aktpath=str_replace($path,'',$aktpath);
        $hu_files[] = $aktpath.'/'.$nev;
      }
    }
    
    //megnézzük, hogy a magyar filenevek megvannak-e az angolban, ami nincs, azt eltesszük
    
    $copy=array();
    foreach ($hu_files as $hu_file) {
      if (!in_array($hu_file, $en_files)) {
        
        $copy[]=$hu_file;
      }
    }
    //print_r($copy);
    
    
    
    
    if (count($copy)>0) {
        $target_url = 'http://almoneira.com/copyfiles.php';
        $i=0;
        foreach ($copy as $file) {
        //This needs to be the full path to the file you want to send.
        $target_url_param=$target_url."?PATH=$file";
	      $file_name_with_full_path = realpath('./wp-content/uploads/'.$file);
        // curl will accept an array here too.
        // Many examples I found showed a url-encoded string instead.
        // Take note that the 'key' in the array will be the key that shows up in the
        // $_FILES array of the accept script. and the at sign '@' is required before the
        // file name.
	       $post = array('extra_info' => '123456','file_contents'=>'@'.$file_name_with_full_path);
   
          $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL,$target_url_param);
	        curl_setopt($ch, CURLOPT_POST,1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
          //curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	        $result=curl_exec ($ch);
          if ($result=='<!--ok-->') {
            $count_image++;
            logol("image ok:$file");
          }
          else {
            logol("image error:$file",true);
          }
	        curl_close ($ch);
	        //echo $result;
        }
    }
    
   

  
?>