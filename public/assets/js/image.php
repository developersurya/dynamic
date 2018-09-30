<?php
header("Content-type: text/javascript");
if(!isset($_GET['fid'])) exit();
$ID = $_GET['fid'];
?>
function callbackIG<?php echo $ID; ?>(newPath){ 
	alert('worked');
}
