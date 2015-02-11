<?php
	var_dump($_FILES);
	if( !empty( $_FILES['file']['name']) ){
		echo $_FILES['file']['name'];
	}

	//echo "Hi You're yploading a file I see";
?>