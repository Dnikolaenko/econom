<?php

$serverName = "http://".$_SERVER['HTTP_HOST'];

$tempFile = $_FILES['Filedata']['tmp_name'];
$fileName = $_FILES['Filedata']['name'];
$fileSize = $_FILES['Filedata']['size'];

move_uploaded_file($tempFile, "uploads/".$fileName);

echo $serverName."/admin/contacts/uploads/".$fileName;

?>