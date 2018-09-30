<?php
if(!isset($_POST)){ exit("403"); }


if($_POST['action'] == "save"){
	$TemplateName = $_POST['template_name'];
	$UniqueID     = $_POST['saveCode'];
	$TemplateData = $_POST['template_data'];

	$TemplateData = preg_replace('/<div[^>]+class="[^>]*editImage[^>]*"[^>]*>.*?<\/end>/i', '', $TemplateData);
	$TemplateData = preg_replace('/\<{0,1}div[^\>]*\>(.*?)<[\/]div>/i', '<div>$1</div>', $TemplateData);
	$TemplateData = preg_replace('/\cDYc(.*?)cDYc/i', '', $TemplateData);
	$TemplateData = preg_replace('/\cDYc(.*?)cDYcholder/i', '', $TemplateData);
	$TemplateData = preg_replace('/<span class="featuredHolder">(.*?)<\/span>/', '$1', $TemplateData);
	$TemplateData = preg_replace('/<span class=(.*?)featuredHolder(.*?)>(.*?)<\/span>/i', '$3', $TemplateData);
	$TemplateData = preg_replace('/<button class="featuredButton"(.*?)\/button>/', '', $TemplateData);
	$TemplateData = preg_replace('/\<{0,1}tfoot[^\>]*\>(.*?)<[\/]tfoot>/i', '', $TemplateData);

	if(!file_exists("../template/".$TemplateName."/cache/".$UniqueID)){
		mkdir("../template/".$TemplateName."/cache/".$UniqueID);
	}
	file_put_contents("../template/".$TemplateName."/cache/".$UniqueID."/".$_POST['version'].".sv", $TemplateData);
}else{
	$TemplateName = $_POST['template_name'];
	$UniqueID     = $_POST['saveCode'];
	$TemplateData = $_POST['template_data'];

	if(isset($_POST['version'])){
		echo file_get_contents("../template/".$TemplateName."/cache/".$UniqueID."/".$_POST['version'].".sv");
	}else{
		if(file_exists("../template/".$TemplateName."/cache/".$UniqueID."/")){
			$Dirs = scandir("../template/".$TemplateName."/cache/".$UniqueID."/");	
			$Index = 0;

			natsort($Dirs);
	
			foreach($Dirs as $File){
				if($File == "." || $File == ".." || $File == "temp" || $File == "images") unset($Dirs[$Index]);
				if($File == ucwords($TemplateName)." Export.zip") unset($Dirs[$Index]);
				$Index += 1;
			}

			$Versions = array_values($Dirs);
			$Total    = count($Versions) - 1;

			$Version = $Versions[$Total];

			$VersionID = explode(".", $Version);

			header("Content-type: application/json");
			$Data = array();
			$Data['data'] = file_get_contents("../template/".$TemplateName."/cache/".$UniqueID."/".$Version);
			$Data['version'] = $VersionID[0];

			echo json_encode($Data);
		}else{
			header("Content-type: application/json");
			$Data = array();
			$Data['data'] = file_get_contents("../template/".$TemplateName."/index.html");
			$Data['version'] = "0";
			$Data['new'] = "true";

			echo json_encode($Data);
		}
		
	}
}

?>