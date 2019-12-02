<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Files</title>

<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php 
$Dir = "www/subFolder";
if (isset($_POST['upload'])) {
	if (isset($_FILES['new_file'])) {
		if (move_uploaded_file($_FILES['new_file']['tmp_name'], $Dir . "/" . $_FILES['new_file']['name']) == TRUE) {
			chmod($Dir . "/" . $_FILES['new_file']['name'], 0644); //read and write - user, others read
			echo "File \"" . htmlentities($_FILES['new_file']['name']) ."\"successfully uploaded. <br />\n";
		}
		else
			echo "There was an error:". $_FILES['new_file']['error'] . " uploading \"" . htmlentities($_FILES['new_file']['name']) . "\".<br />\n";
	}
}
?>
<form action="UploadFile.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="500000" /><br />
	File to upload:<br />
<input type="file" name="new_file" /><br />
	(500 KB limit) <br />
<input type="submit" name="upload" value="Upload the File" />
<br />
</form>
</body>
</html>

