@extends('app')

@section('content')
<div class="row">
	<div class="leftNavigation tabSelect">
		<img src="/assets/img/logo_dynamicxx.png" class="logo" />
		<ul>
			<li><a href="#" data-tab="modules"><span><img src="/assets/img/sidebar/1_grey.png" class="normal" /><img src="/assets/img/sidebar/1_red.png" class="hover" /></span> Modules</a></li>
			<li class="active"><a href="#" data-tab="styles"><span><img src="/assets/img/sidebar/2_grey.png" class="normal" /><img src="/assets/img/sidebar/2_red.png" class="hover" /></span> Styles</a></li>
			@if(isset($backgrounds))
			<li><a href="#" data-tab="background"><span><img src="/assets/img/sidebar/3_grey.png" class="normal" /><img src="/assets/img/sidebar/3_red.png" class="hover" /></span> Background Imgs</a></li>
			@endif
			<li><a href="#" data-tab="save"><span><img src="/assets/img/sidebar/4_grey.png" class="normal" /><img src="/assets/img/sidebar/4_red.png" class="hover" /></span> Save</a></li>
			<li><a href="#" data-tab="upload"><span><img src="/assets/img/sidebar/5_grey.png" class="normal" /><img src="/assets/img/sidebar/5_red.png" class="hover" /></span> Upload</a></li>
			<li><a href="#" data-tab="export"><span><img src="/assets/img/sidebar/6_grey.png" class="normal" /><img src="/assets/img/sidebar/6_red.png" class="hover" /></span> Export</a></li>
		</ul>

		<div class="text-center">
			<button class="btn btn-secondary btn-purchase" id="purchaseButton" onClick="window.open('{{ $template->buy_url }}');">Purchase</button>
		</div>
	</div>
	<div class="subNavigation tabLeft" id="modulesTab">
		<ul class="moduleSelect connectedSortable">
			@if(isset($modules))
			<?php
			function cmp($a, $b){
				return strnatcmp($a->module_name, $b->module_name);
			}
			usort($modules, "cmp");
			?>
			@foreach ($modules as $module)
			<li class="text-center leftOptions" data-codetoadd="{{ $module->module_htmltext }}"><img src="{{ $module->module_image }}" /></li>
			@endforeach
			@endif
		</ul>
	</div>
	<div class="subNavigation tabLeft active" id="stylesTab">
		<ul>
			@if(isset($colors))
			@foreach ($colors as $color)
    		<li>{{ $color->color_name }} <div class="pull-right"><input type="text" name="color" data-background="{{ $color->html_bg }}" data-htmltag="{{ $color->html_color_tag }}" data-modifies="{{ $color->attribute_name }}" class="clrpick color{{ $color->id }}" value="{{ $color->inital_value }}" /></div></li>
			@endforeach
			@endif

			@if(isset($sliders))
			@foreach ($sliders as $slider)
			<li class="no-border">{{ $slider->slider_name }} <div class="pull-right"><div class="min-slider" data-min="{{ $slider->min_value }}" data-max="{{ $slider->max_value }}" data-modifies="{{ $slider->html_attribute }}" data-cssmodifer="{{ $slider->css_modification }}" data-default="{{ $slider->default_value }}"></div> <p class="pull-right number">{{ $slider->default_value }}px</p></div></li>
			@endforeach
			@endif
		</ul>
	</div>
	<div class="subNavigation tabLeft" id="backgroundTab">
		<ul>
			@if(isset($backgrounds))
			@foreach ($backgrounds as $background)
			<li data-bgid="{{ $background->id }}" class="collapsed">
				<p>{{ $background->background_name }}</p>
				<span class="hidden">
				<input type="text" placeholder="Enter a Valid URL" onBlur="updateBG(this.value, '{{ $background->attribute_name }}');" id="backgroundImage" /><br /><button class="btn btn-white" onclick="$(this).parent().find('.fileToUpload').click();">UPLOAD FROM DESKTOP</button><br />
				<button class="btn btn-white" onclick="editorBackground('{{ $background->attribute_name }}');" style="margin-top: 5px;">IMAGE EDITOR</button>
				<form action="/assets/uploadImage.php" method="post" enctype="multipart/form-data" target="uploadFrame" style="display: none;">
					<input type="file" name="fileToUpload" class="fileToUpload" onchange="$(this).parent().submit();">
					<input type="hidden" name="saveCode" value="{{ $saveCode }}" />
					<input type="hidden" name="template" value="{{ $template->slug }}" />
					<input type="hidden" name="callBack" value="callbackBG{{ $background->id }}" />
					<input type="submit" value="Upload" />
				</form>
				<script>function callbackBG{{ $background->id }}(newPath){ $('[data-bgid={{ $background->id }}] input[type=file]').val(''); $('[data-element={{ $background->attribute_name }}]').css('background-image', "url('"+newPath+"')"); saveTemplate(); }</script>
				</span>
			</li>
			@endforeach
			@endif

			<iframe src="" height="100" width="100" frameborder="0" name="uploadFrame"></iframe>

			
		</ul>
	</div>
	<div class="subNavigation tabLeft" id="saveTab">
		<ul>
			<li><div class="yourCode">Your code is: <span id="saveCode"></span></div>
			Use this code to upload your template</li>
		</ul>
	</div>
	<div class="subNavigation tabLeft" id="uploadTab">
		<ul>
			<li><input type="text" placeholder="Enter your saved code here..." id="uploadCode" /><br /><button class="btn btn-third" onClick="loadTemplateFromCode($('#uploadCode').val());">UPLOAD</button>
		</ul>
	</div>

	<div class="subNavigation tabLeft" id="exportTab">
		<ul>
			<li><button class="btn btn-white" onClick="exportTemplate('mc');">MailChimp</button></li>
			<li><button class="btn btn-white" onClick="exportTemplate('cm');">Campaign Montior</button></li>
			<li><button class="btn btn-white" onClick="exportTemplate('html');">HTML Normal</button></li>
		</ul>
	</div>
	<div class="template-holder pull-right">
		<div class="fixed">
			<button class="btn btn-third desktopPreview hidden">Preview <i class="fa fa-desktop"></i></button>
			<button class="btn btn-third tabletPreview">Preview <i class="fa fa-tablet"></i></button>
			<button class="btn btn-third mobilePreview">Preview <i class="fa fa-mobile"></i></button>

			<div class="pull-right">
				<button class="btn btn-third" id="reset">Reset <i class="fa fa-refresh"></i></button>
				<button class="btn btn-third" disabled id="redo">Redo <i class="fa fa-repeat"></i></button>
				<button class="btn btn-third" disabled id="undo">Undo <i class="fa fa-undo"></i></button>
			</div>
		</div>
	
		<div id="the_template" class="connectedSortable"></div>
	</div>
</div>


<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="/assets/js/color/jqColor.js"></script>
<script type="text/javascript" src="/assets/js/color/colors.js"></script>
<script type="text/javascript" src="/assets/js/color/colorPicker.data.js"></script>
<script type="text/javascript" src="/assets/js/color/colorPicker.js"></script>



<script type="text/javascript">
	var $colorA = $('input.clrpick').colorPicker({ noHexButton: false, allMixDetails: true, customBG: '#222', readOnly: false, init: function(elm, colors){ setColor(elm, colors); }, change: function(elm, colors){ setColor(elm, colors); } }).each(function(idx, elm) { });
	/*var $colorB = $('input.color2').colorPicker({ customBG: '#222', readOnly: false, init: function(elm, colors){ setColor(elm, colors); } }).each(function(idx, elm) { });
	var $colorC = $('input.color3').colorPicker({ customBG: '#222', readOnly: false, init: function(elm, colors){ setColor(elm, colors); } }).each(function(idx, elm) { });
	var $colorD = $('input.color4').colorPicker({ customBG: '#222', readOnly: false, init: function(elm, colors){ setColor(elm, colors); } }).each(function(idx, elm) { });
	var $colorE = $('input.color5').colorPicker({ customBG: '#222', readOnly: false, init: function(elm, colors){ setColor(elm, colors); } }).each(function(idx, elm) { });
	var $colorF = $('input.color6').colorPicker({ customBG: '#222', readOnly: false, init: function(elm, colors){ setColor(elm, colors); } }).each(function(idx, elm) { });
	*/

	function setColor(elm, colors) { // colors is a different instance (not connected to colorPicker)
      	elm.style.backgroundColor = elm.value;
      	elm.style.color = colors.rgbaMixCustom.luminance > 0.22 ? '#222' : '#ddd';

      	var toChange        = $(elm).attr('data-modifies');
      	console.log(toChange);
        var cssValue        = $(elm).attr('data-htmltag');
        var currentValue    = $("#the_template [data-attr="+toChange+"]").attr(cssValue);

        $("#the_template [data-attr="+toChange+"]").css(cssValue, elm.value);
	   	if(cssValue == "background-color"){
   		    $("#the_template [data-attr="+toChange+"]").attr('bgcolor', elm.value);
    	}
        if($(this).attr('data-background') == "1"){ $('#html_bg_color').attr('data-color', elm.value); }
    }
</script>



@if (Auth::check())
	<script>window.loggedIn = true;</script>
@else
	<script>window.loggedIn = false;</script>
@endif

<script>window.templateName = "{{ $template->slug }}"; window.saveCode = "{{ $saveCode }}"; $('#saveCode').html(window.saveCode); </script>

<script>
$(document).ready(function(){ setUpBuilder(); 
	@if($loading == "false	")
		loadTemplate("{{ $template->slug }}");
	@else
		loadTemplateFromCode(window.saveCode);
	@endif

	@if($purchased == "true")
		window.owned = true;
		$('#purchaseButton').hide();
	@endif
});


var editType = "image";
function closePopUp(imagePath){
	$('#blackout, #imageEditor').fadeOut(1000);
	$('#imageEditor iframe').attr('src', 'about:blank');
	if(editType == "image"){
		$(updatePath).parent().parent().parent().find('img.toModifyImage').attr('src', imagePath);
	}else{
		$('[data-element='+updatePath+']').css('background-image', 'url(\''+imagePath+'\')').attr('background', imagePath);
		editType = "image";
	}
	saveTemplate();
}
</script>

<div id="blackout">&nbsp;</div>
<div id="imageEditor">
	<iframe src="" width="100%" height="100%" frameborder="0" class="ImageEditor"></iframe>
	<a href="#" class="btn btn-third" onClick="closeImageEditor();"><i class="fa fa-times"></i></a>
</div>




<div id="purchaseNow">
<p>You need to purchase this template to get access to the export feature.</p>
<p class="black">
	<button class="btn btn-secondary" onClick="window.open('{{ $template->buy_url }}');">Buy Now</button>
	<button class="btn btn-grey" onClick="closePurchaser();">Cancel</button>
</p>
</div>

@endsection