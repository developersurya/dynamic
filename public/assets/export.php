<?php
if(!isset($_REQUEST)){ exit("403"); }
header("Content-type: application/json");

$TemplateName = $_REQUEST['template_name'];
$UniqueID     = $_REQUEST['saveCode'];
$Type 		  = $_REQUEST['type'];
	
//echo file_get_contents("../template/".$TemplateName."/cache/".$UniqueID."/".$_REQUEST['version'].".sv");
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


sortOutHTML($TemplateName, $UniqueID, $Version, $Type);

$zip = new ZipArchive();
$FileName = ucwords($TemplateName)." Export.zip";

if(file_exists("../template/".$TemplateName."/cache/".$UniqueID."/".$FileName)){
	unlink("../template/".$TemplateName."/cache/".$UniqueID."/".$FileName);
}

if ($zip->open("../template/".$TemplateName."/cache/".$UniqueID."/".$FileName, ZipArchive::CREATE)!==TRUE) {
	exit("FAILED");
}

$Images = scandir("../template/".$TemplateName."/images/");
foreach($Images as $Image){
	if($Image == ".." || $Image == "."){
	}else{
		$zip->addFile("../template/".$TemplateName."/images/".$Image, "images/".$Image);
	}
}

if(file_exists("../template/".$TemplateName."/cache/".$UniqueID."/images/")){
$Images = scandir("../template/".$TemplateName."/cache/".$UniqueID."/images/");
foreach($Images as $Image){
	if($Image == ".." || $Image == "."){
	}else{
		$zip->addFile("../template/".$TemplateName."/cache/".$UniqueID."/images/".$Image, "images/".$Image);
	}
}
}

$zip->addFile("../template/".$TemplateName."/cache/".$UniqueID."/temp", "index.html");
$zip->close();

$RE = array();
$RE['URL'] = "/template/".$TemplateName."/cache/".$UniqueID."/".urlencode($FileName);
echo json_encode($RE);


function sortOutHTML($Template, $Code, $File, $Type){
	$FilePath = "../template/".$Template."/cache/".$Code."/".$File;
	$File = file_get_contents($FilePath);

	if($Type != "mc"){
		$File = preg_replace('/ mc:repeatable="(.*?)"/', "", $File);
		$File = preg_replace('/ mc:edit="(.*?)"/', "", $File);
	}
	if($Type != "cm"){
		$File = preg_replace('/ editable="(.*?)"/', "", $File);
		$File = str_replace('<singleline>', "", $File);
		$File = str_replace('</singleline>', "", $File);
		$File = str_replace('<multiline>', "", $File);
		$File = str_replace('</multiline>', "", $File);
		$File = preg_replace('/<repeater>(.*?)<\/repeater>/', "$1", $File);
		$File = preg_replace('/<layout(.*?)>(.*?)<\/layout>/', "$2", $File);
		$File = preg_replace('/<unsubscribe>(.*?)<\/unsubscribe>/', "$1", $File);
		$File = preg_replace('/<table data-cmid="(.*?)" (.*?)>/', '<table $2>', $File);
		$File = preg_replace('/<!(.*?)EndModule(.*?)><\/table>/', '</table>', $File);
	}else{
		$File = preg_replace('/<table data-cmid="(.*?)" (.*?)>/', '<repeater><layout label="$1"><table $2>', $File);
		$File = preg_replace('/<!(.*?)EndModule(.*?)><\/table>/', '</table></layout></repeater>', $File);
		$File = preg_replace('/<a href="(.*?)" (.*?) class="unsub">(.*?)<\/a>/', "<unsubscribe $2>$3</unsubscribe>", $File);
	}

	$Color = explode("</span>", $File);
	$Start = explode('data-color="', $Color[0]);
	$End   = explode('"', $Start[1]);
	$Color = $End[0];

	$File = preg_replace('/ data-cmid="(.*?)"/', " ", $File);
	$File = str_replace("/template/".$Template."/cache/".$Code."/", "", $File);
	$File = str_replace("/template/".$Template."/", "", $File);
	$File = str_replace("http://sebbuilder.clients.pw", "", $File);
	$File = str_replace("#the_template.mobile", "body", $File);
	$File = str_replace(".htmltag{", "html{ background-color:".$Color."; ", $File);
	$File = str_replace('style="position: relative;"', " ", $File);
	$File = str_replace(" style='(.*?)'", ' style="$1"', $File);
	$File = str_replace(' style="(.*?)age:(.*?)"(.*?)"(.*?)"', ' style="$1age$2\'$3\'$4"', $File);
	$File = str_replace("#the_template.tablet", "body", $File);
	$File = str_replace("#the_template", "body", $File);
	$File = str_replace('" >', '">', $File);
	$File = str_replace("<!--html>", "<html>", $File);
	$File = str_replace('<!--DOCTYPE>', '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"', $File);
	$File = str_replace('<!--loose>', '"http://www.w3.org/TR/REC-html40/loose.dtd">', $File);
	$File = str_replace("<body-->", "<body style='margin: 0; padding: 0;'>", $File);
	$File = str_replace("<!--/body>", "</body>", $File);
	$File = str_replace("<title-->", "</title>", $File);
	$File = str_replace("<!--/head>", "</head>", $File);
	$File = str_replace("</body-->", "<body style='margin: 0; padding: 0;'>", $File);
	$File = str_replace("</html-->", "</html>", $File);
	$File = str_replace("<!--/head>", "</head>", $File);
	$File = str_replace(' class="unsub"', '', $File);
	$File = str_replace('<!--unsub-->', '', $File);
	$File = str_replace('<!--{@mobile-640px} --><style type="text/css">', '<style type="text/css">@media only screen and (max-width: 640px){', $File); 
	$File = str_replace("</style><!--{@endmobile-640px}-->", "}</style>", $File); 
	$File = str_replace('<!--{@mobile-479px} --><style type="text/css">', '<style type="text/css">@media only screen and (max-width: 479px){', $File); 
	$File = str_replace("</style><!--{@endmobile-479px}-->", "}</style>", $File); 
	$File = str_replace('<!--{@mobile-1200px} --><style type="text/css">', '<style type="text/css">@media only screen and (max-width: 1200px){', $File); 
	$File = str_replace("</style><!--{@endmobile-1200px}-->", "}</style>", $File);
	$File = str_replace('<!--{@mobile-900px} --><style type="text/css">', '<style type="text/css">@media only screen and (max-width: 900px)', $File); 
	$File = str_replace("</style><!--{@endmobile-900px}-->", "</style>", $File); 
	$File = preg_replace("/<\/?div[^>]*\>/i", "", $File);
	$File = preg_replace("/<div>(.*?)<\/div>/", "$1", $File);
	$File = str_replace("http://builder.dynamicxx.com", "", $File);
	$File = str_replace("http://www.www.", "http://www.", $File);
	$File = str_replace("/template/demo/", "", $File);
	$File = str_replace("&quot;", "'", $File);
	$File = str_replace("&amp;quot;", "'", $File);
	$File = str_replace("tabledata", "table data", $File);
	$File = str_replace("tableclass", "table class", $File);
	$File = str_replace("class= ", "", $File);
	$File = str_replace("  >", ">", $File);
	$File = str_replace(" >", ">", $File);
	$File = str_replace("tdclass=", "td class=", $File);
	$File = str_replace('onmouseover="showOptions(this);"', "", $File);
	
	$File = str_replace('/*bodyfont*/[style*="Open Sans"]', 'body *', $File);
	$File = str_replace('/*bodyfont*/[style*="Playfair Display"]', 'body *', $File);

	$File = preg_replace_callback('/<span class="ie9modify(.*?)<\/span>/', 'addIEImage', $File); //'<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/<span class="ie9modify(.*?)url((.*?));/', '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/finishthisoff(.*?)<\/span>/', '/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>', $File);
	
	$File = preg_replace_callback('/<span class="365pxie9modify(.*?)<\/span>/', 'addIEImage2', $File); //'<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:365;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/<span class="365pxie9modify(.*?)url((.*?));/', '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width: 365;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/finishthisoff(.*?)<\/span>/', '/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>', $File);
	
	$File = preg_replace_callback('/<span class="490ie9modify(.*?)<\/span>/', 'addIEImage3', $File); //'<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:365;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/<span class="490ie9modify(.*?)url((.*?));/', '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:490;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/finishthisoff(.*?)<\/span>/', '/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>', $File);
	
	$File = preg_replace_callback('/<span class="480ie9modify(.*?)<\/span>/', 'addIEImage4', $File); //'<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:480;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/<span class="480ie9modify(.*?)url((.*?));/', '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:480;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/finishthisoff(.*?)<\/span>/', '/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>', $File);
	
	$File = preg_replace_callback('/<span class="500ie9modify(.*?)<\/span>/', 'addIEImage5', $File); //'<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:500;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/<span class="500ie9modify(.*?)url((.*?));/', '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:500;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/finishthisoff(.*?)<\/span>/', '/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>', $File);
	
	$File = preg_replace_callback('/<span class="456ie9modify(.*?)<\/span>/', 'addIEImage6', $File); //'<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:456;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/<span class="456ie9modify(.*?)url((.*?));/', '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:456;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/finishthisoff(.*?)<\/span>/', '/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>', $File);
	
	$File = preg_replace_callback('/<span class="600ie9modify(.*?)<\/span>/', 'addIEImage7', $File); //'<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:600;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/<span class="600ie9modify(.*?)url((.*?));/', '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:600;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/finishthisoff(.*?)<\/span>/', '/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>', $File);
	
	$File = preg_replace_callback('/<span class="295ie9modify(.*?)<\/span>/', 'addIEImage8', $File); //'<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:295;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/<span class="295ie9modify(.*?)url((.*?));/', '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:295;"><v:fill type="tile" src="$2" finishthisoff/', $File);
	//$File = preg_replace('/finishthisoff(.*?)<\/span>/', '/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>', $File);

	$File = preg_replace("/<tfoot>(.*?)<\/tfoot>/", "", $File);
	$File = preg_replace('#<span class="featuredHolder">(.*?)<\/span>#is', "$1", $File);
	$File = preg_replace('/ data-element="(.*?)"/', "", $File);
	$File = preg_replace_callback('/rgb((.*?),(.*?),(.*?));/', 'rgb2hex', $File);
	$File = preg_replace('/ data-attr="(.*?)"/', "", $File);
	$File = preg_replace('/ data-position="(.*?)"/', "", $File);
	$File = preg_replace('/toModifyImage cDYc(.*?)cDYc/', "", $File);
	$File = preg_replace('/cDYc(.*?)cDYcholder/', "", $File);
	$File = preg_replace('/cDYc(.*?)cDYc/', "", $File);
	$File = preg_replace('/<(.*?)  (.*?)>/', "<$1$2>", $File);
	$File = preg_replace('/class="(.*?) "/', 'class="$1"', $File);
	$File = preg_replace('/class=""/', "", $File);
	$File = preg_replace('/class=" "/', "", $File);
	$File = preg_replace('/<span id="html_bg_color"(.*?)><\/span>/', "", $File);
	$File = preg_replace('/"(.*?) position: relative;/', '"$1', $File);
	$File = preg_replace('/"position: relative; (.*?)"/', '"$1"', $File);
	$File = str_replace('<!--[if gte mso 9.]>', '</div><!--[if gte mso 9.]>', $File);
	$File = preg_replace('/" >/', '">', $File);
	$File = preg_replace('/ data-element="(.*?)"/', " ", $File);
	$File = preg_replace('/ data-cke-saved-src="(.*?)"/', " ", $File);
	$File = preg_replace('/ data-cke-saved-href="(.*?)"/', " ", $File);
	$File = preg_replace('/ data-tool="(.*?)"/', "", $File);
	$File = preg_replace('/ data-jumpback="(.*?)"/', "", $File);
	$File = preg_replace('/ data-cke-saved-href"(.*?)"/', " ", $File);
	$File = preg_replace('/ onmouseover="(.*?)"/', " ", $File);
	//$File = preg_replace('/\s\s+/', "", $File);  
	//$File = preg_replace_callback('~<([A-Z0-9]+) \K(.*?)>~i', function($m) {$replacement = preg_replace('~\s*~', '', $m[0]); return $replacement;}, $File);
	$File = preg_replace('/<\s+/', '', $File);
	$File = preg_replace('/="(.*?)\s+"/', '="$1"', $File);
	$File = preg_replace('/="\s+(.*?)"/', '="$1"', $File);
	
//	$File = preg_replace('/"([a-z0-9]+)"/iU','$1',$File);
	file_put_contents("../template/".$Template."/cache/".$Code."/temp", $File);
}


function rgb2hex($c1) {
   $hex = "#";
   $hex .= str_pad(dechex(str_replace("(", "", $c1[2])), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($c1[3]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex(str_replace("(", "", $c1[4])), 2, "0", STR_PAD_LEFT);

   return $hex.";"; // returns the hex value including the number sign (#)
}

function addIEImage($Content){
	$Part1 = explode("url(", $Content[0]);
	$Part2 = explode(")", $Part1[1]);
	$Content = str_replace('"', "", str_replace("'", "", $Part2[0]));
	return '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;"><v:fill type="tile" src="'.$Content.'"/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>';
}

function addIEImage2($Content){
	$Part1 = explode("url(", $Content[0]);
	$Part2 = explode(")", $Part1[1]);
	$Content = str_replace('"', "", str_replace("'", "", $Part2[0]));
	return '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width: 365;"><v:fill type="tile" src="'.$Content.'"/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>';
}

function addIEImage3($Content){
	$Part1 = explode("url(", $Content[0]);
	$Part2 = explode(")", $Part1[1]);
	$Content = str_replace('"', "", str_replace("'", "", $Part2[0]));
	return '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:490;"><v:fill type="tile" src="'.$Content.'"/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>';
}

function addIEImage4($Content){
	$Part1 = explode("url(", $Content[0]);
	$Part2 = explode(")", $Part1[1]);
	$Content = str_replace('"', "", str_replace("'", "", $Part2[0]));
	return '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:480;"><v:fill type="tile" src="'.$Content.'"/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>';
}

function addIEImage5($Content){
	$Part1 = explode("url(", $Content[0]);
	$Part2 = explode(")", $Part1[1]);
	$Content = str_replace('"', "", str_replace("'", "", $Part2[0]));
	return '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:500;"><v:fill type="tile" src="'.$Content.'"/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>';
}

function addIEImage6($Content){
	$Part1 = explode("url(", $Content[0]);
	$Part2 = explode(")", $Part1[1]);
	$Content = str_replace('"', "", str_replace("'", "", $Part2[0]));
	return '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:456;"><v:fill type="tile" src="'.$Content.'"/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>';
}

function addIEImage7($Content){
	$Part1 = explode("url(", $Content[0]);
	$Part2 = explode(")", $Part1[1]);
	$Content = str_replace('"', "", str_replace("'", "", $Part2[0]));
	return '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:600;"><v:fill type="tile" src="'.$Content.'"/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>';
}

function addIEImage8($Content){
	$Part1 = explode("url(", $Content[0]);
	$Part2 = explode(")", $Part1[1]);
	$Content = str_replace('"', "", str_replace("'", "", $Part2[0]));
	return '<!--[if gte mso 9]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:295;"><v:fill type="tile" src="'.$Content.'"/><v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><div>';
}


?>