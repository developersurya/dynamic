<?php
if(!isset($_POST['saveCode'])) exit();


$SaveCode = $_POST['saveCode'];
$Image    = $_FILES['fileToUpload'];
$Template = $_POST['template'];


if(file_exists("../template/".$Template."/cache/".$SaveCode."/images/")){
}else{
	mkdir("../template/".$Template."/cache/".$SaveCode."/images/", 0777);
}

$Ext = explode(".", $Image['name']);
$Ext = end($Ext);
if($Ext == "jpg" || $Ext == "png" || $Ext == "gif"){
	$NewPath = "/template/".$Template."/cache/".$SaveCode."/images/".uniqid().$Image['name'];
	move_uploaded_file($Image['tmp_name'], "..".$NewPath);
	echo "<script>parent.".$_POST['callBack']."('$NewPath');</script>";
}else{
	echo "<script>alert('You can only upload images.');</script>";
}
?>