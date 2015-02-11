<?php
	var_dump($_FILES);
	if( !empty( $_FILES['file']['name']) ){
		echo $_FILES['file']['name'];
	}
?>
