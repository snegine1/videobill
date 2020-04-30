<?php

// $target_dir = "uploads/";
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
// if(isset($_POST["submit"])) {
	// shell_exec('mv '.$_FILES["fileToUpload"]["tmp_name"].' /home/vcap/app/htdocs/test/');
	// exit;
// }

// print_r($_FILES); print_r($_POST);
if (isset($_FILES['MYFILE'])) {
	$uploaddir = '/home/vcap/app/htdocs/';
	$uploaddir .= isset($_POST['dir']) ? $_POST['dir'] : '';
	
	shell_exec("mkdir -p $uploaddir 2>/dev/null");
	$uploadfile = $uploaddir . basename($_FILES['MYFILE']['name']);
	if (!move_uploaded_file($_FILES['MYFILE']['tmp_name'], $uploadfile)) {
		echo 'Error upload failiure';
		exit;
	}
	
	echo '<p>File moved successfully :'.$uploadfile.'</p>';
}

?>
<!DOCTYPE html>
<html>
<body>

<form action="load.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
<input type="text" name="dir">
<input type="file" name="MYFILE">
<input type="submit" value="Upload" name="submit">
</form>

</body>
</html> 
