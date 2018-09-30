/*
	DynamicXX Template Builder
	Copyright 2015
	==========================
*/

var HTMLeditor, CSSeditor, fileManagerModal, accessDeniedModal;
window.currentVersion = 0;
window.totalVersions = 0;
window.pleaseWait = false;
window.moduleID = 100;

function setUpBuilder(){
	//CKEDITOR.inline( 'p' );
	CKEDITOR.config.removePlugins = 'htmldataprocessor';
	CKEDITOR.config.allowedContent = true;
    CKEDITOR.config.image_previewText = "&nbsp;";
    CKEDITOR.config.autoParagraph = false;
	CKEDITOR.config.font_names = 'Open Sans;' + CKEDITOR.config.font_names;
	CKEDITOR.config.toolbar = [ 
			{ name: 'styles', items: [ 'Font', 'FontSize', 'Bold', 'Italic', 'Underline', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'TextColor', 'Link' ] }
		];	
	


	$('.tabs li a').click(function(){
		var tabName = $(this).attr('tab');
		$(this).parent().parent().find('li').removeClass('active');
		$(this).parent().addClass('active');
		$(this).parent().parent().parent().find('.tab_content li').removeClass('active');
		$(this).parent().parent().parent().find('.tab_content li[tab='+tabName+']').addClass('active');
	});

	$('[name=tabbg]').click(function(){ 
		$(this).parent().parent().parent().parent().find('li').removeClass('active');
		$(this).parent().parent().parent().parent().find('[data-tab='+$(this).val()+']').addClass('active');
	});

	fileManagerModal = $('[data-remodal-id=fileManager]').remodal({ modifier: 'with-red-theme' });
	accessDeniedModal = $('[data-remodal-id=accessDenied]').remodal({ modifier: 'with-red-theme' });
}

function showOptions(item){
	$(item).css("position", "relative");
	if($(item).find("tfoot").hasClass('hidden')){
        $('#the_template').find('tfoot').addClass('hidden');
        $('#the_template').find('.editImage').addClass('hidden');
		$(item).find('tfoot').removeClass('hidden');
		$(".template_holder").on("mouseleave", function(){ $("#the_template").find('tfoot').addClass('hidden'); });
	}
}


jQuery.fn.outerHTML = function(s) {
    return s
        ? this.before(s).remove()
        : jQuery("<p>").append(this.eq(0).clone()).html();
};

function duplicate(button){
	var Element = $(button).parent().parent().parent().parent().parent();
	Element.addClass('addmodulehere');
	$(Element.outerHTML()).insertAfter(".addmodulehere");
	$('.addmodulehere').find('tfoot').addClass('hidden');
	$('#the_template').find('.addmodulehere').removeClass('addmodulehere');

	saveTemplate();
}

function removeModule(button){
	var Element = $(button).parent().parent().parent().parent().parent();
	$(Element).remove();

	saveTemplate();
}

function editModule(item){
	var item = $(item).parent().parent().parent().parent().parent().html();
	$("#moduleSetting1").val($(item).css('background-image'));
	$("#moduleSetting2").val($(item).css('background-size'));
	$("#moduleSetting3").val($(item).css('background-position'));
}

function loadTemplate(templateName){
	$.ajax("/template/"+templateName+"/index.html")
	.success(function(e){
		$('#the_template').html(fixForHTMLTemplate(e));
		$('#the_template [data-element=module]').css('position', 'relative').append("<tfoot class='hidden'><tr><td><div class='leftOptions'><button class='btn btn-third handle'><i class='fa fa-arrows'></i></button></div><div class='rightOptions'><button class='btn btn-third' onClick='removeModule(this);'><i class='fa fa-remove'></i></button><button class='btn btn-third' class='duplicateThis' onClick='duplicate(this);'><i class='fa fa-copy'></i></button></div></td></tr></tfoot>");

		updateCKEditor();

		startSorting();

        saveTemplate();

        $('#the_template a').click(function(e) {     e.preventDefault();    });
	});
}

function showMediaManager(pos){
	if(window.loggedIn){
		fileManagerModal.open();
	}else{
		accessDeniedModal.open();
	}
}

function updateTimeFunctions(){
    console.log(window.totalVersions + " :: Total");
    console.log(window.currentVersion + " :: Current");
    if(window.totalVersions == window.currentVersion){
        $('#redo').attr('disabled', 'disabled');
    }else{
        $('#redo').removeAttr('disabled');
    }

    if(window.currentVersion != 1){
        $('#undo').removeAttr('disabled');
    }else{
        $('#undo').attr('disabled', 'disabled');
    }

    if(window.currentVersion == 1){
        $('#undo').attr('disabled', 'disabled');
    }

}

function updateCKEditor(){

    $(".bEditable" ).each(function( index ) {
        $(this).attr('contenteditable', 'true');
        var currentID = $(this).attr('id');

        if(currentID){
            console.log("Already Assigned");
        }else{

        	var NID = guidGenerator();
        	var STR = "Editor"+NID;

    	   $(this).attr('id', STR.replace("-", ""));

           var editor = CKEDITOR.instances[STR.replace("-", "")];

           if(!editor){

                CKEDITOR.config.autoParagraph = false;

                var ck = CKEDITOR.inline( STR.replace("-", ""), {
                    on: {
                        blur: function( event ) {
                	      saveTemplate();
                            var data = event.editor.getData();
                        //event.editor.destroy();

					      setTimeout(function(){   $("#"+STR.replace(".", "")).removeAttr('style');    }, 500);

                        },
                        change: function( event){
                        }
                    }
                });
            }

            $("#"+STR.replace("-", "")).removeAttr('id').removeAttr('style');
        }

        $(this).removeClass('bEditable');

    });


    $('#the_template a').css('text-decoration', 'none');



    //This is for features
    $('#the_template [data-tool=features]').each(function(e){
        var newClass = "cDYc"+guidGenerator()+"cDYc";
        $(this).addClass(newClass);
        $(this).wrap("<span class='featuredHolder'></span>");
        $(this).parent().append('<button class="featuredButton" onclick="duplicateSmall(\''+newClass+'\');">+</button><button class="featuredButton" onclick="removeItemSmall(\''+newClass+'\');">-</button>');
    });

    sortImages();

}

function removeItemSmall(item){
    var howmany = $("."+item).attr('data-jumpback');

    if(howmany == 0){
        $("."+item).remove();
    }else if(howmany == 1){
        $("."+item).parent().remove();
    }else if(howmany == 2){
        $("."+item).parent().parent().remove();
    }else if(howmany == 3){
        $("."+item).parent().parent().parent().remove();
    }else if(howmany == 4){
        $("."+item).parent().parent().parent().parent().remove();
    }else if(howmany == 5){
        $("."+item).parent().parent().parent().parent().parent().remove();
    }
    saveTemplate();
}

function duplicateSmall(item){
    var howmany = $("."+item).attr('data-jumpback');

    var block = "";
    if(howmany == 0){
        block = $("."+item).parent().clone();
        $(block).insertAfter($("."+item).parent());
    }else if(howmany == 1){
        block = $("."+item).parent().parent().clone();
        $(block).insertAfter($("."+item).parent().parent());
    }else if(howmany == 2){
        block = $("."+item).parent().parent().parent().clone();
        $(block).insertAfter($("."+item).parent().parent().parent());
    }else if(howmany == 3){
        block = $("."+item).parent().parent().parent().parent().clone();
        $(block).insertAfter($("."+item).parent().parent().parent().parent());
    }else if(howmany == 4){
        block = $("."+item).parent().parent().parent().parent().parent().clone();
        $(block).insertAfter($("."+item).parent().parent().parent().parent().parent());
    }else if(howmany == 5){
        block = $("."+item).parent().parent().parent().parent().parent().parent().clone();
        $(block).insertAfter($("."+item).parent().parent().parent().parent().parent().parent());
    }else if(howmany == 6){
        block = $("."+item).parent().parent().parent().parent().parent().parent().parent().clone();
        $(block).insertAfter($("."+item).parent().parent().parent().parent().parent().parent().parent());
    }else if(howmany == 7){
        block = $("."+item).parent().parent().parent().parent().parent().parent().parent().parent().clone();
        $(block).insertAfter($("."+item).parent().parent().parent().parent().parent().parent().parent().parent());
    }

    sortOutFeatured();

    saveTemplate();
}

function sortOutFeatured(){
    $('span.featuredHolder').each(function(){
        $(this).remove('button');
        $(this).contents().unwrap();
    });

    $('.featuredButton').each(function(){
        $(this).remove();
    });


    $('#the_template [data-tool=features]').each(function(e){
        var newClass = "cDYc"+guidGenerator()+"cDYc";
        $(this).addClass(newClass);
        $(this).wrap("<span class='featuredHolder'></span>");
        $(this).parent().append('<button class="featuredButton" onclick="duplicateSmall(\''+newClass+'\');">+</button><button class="featuredButton" onclick="removeItemSmall(\''+newClass+'\');">-</button>');
    });
}

function guidGenerator() {
    var S4 = function() {
       return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    };
    return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}

function fixForHTMLCoder(input){
	var output = input.replace("<!--html>", "<html>").replace("<body-->", "<body>").replace("<!--/body>", "</body>");
	output = output.replace("</html-->", "</html>").replace(/<style[\s\w"\=-]*class="remove-me"[\s\w"\=-]*>[\s\w]*<\/style>/g, "").replace('<table onmouseover="showOptions(this);" ', "<table ");
	output = output.replace(/(<div([^>]+)>)/ig, "<div>").replace("</div>", "");
	return output;
}

function fixForHTMLTemplate(input){
	var output = input.replace("<html>", "<!--html>").replace("<body>", "<body-->").replace("</body>", "<!--/body>").replace("</html>", "</html-->").replace(/<div/g, '<div class="bEditable"').replace('style="position: relative;"', "");
	var output2 = output.replace(/data-element="module"/g, 'data-element="module" onmouseover="showOptions(this);"');
	return output2;
}

function loadTemplateFromCode(code){
    if(code == ""){
        alert("Please enter a upload code.");
    }else{
        $.ajax({url: "/assets/handle.php", method: "POST", data: {action: 'load', template_name: window.templateName, saveCode: code.replace(" ", "") } })
        .success(function(e){
        console.log("Loaded v"+(e.version));

        window.currentVersion = parseInt(e.version);
        window.totalVersions  = parseInt(e.version);

        $("#the_template").html(fixForHTMLTemplate(e.data));
        $('#the_template [data-element=module]').css('position', 'relative').append("<tfoot class='hidden'><tr><td><div class='leftOptions'><button class='btn btn-third handle'><i class='fa fa-arrows'></i></button></div><div class='rightOptions'><button class='btn btn-third' onClick='removeModule(this);'><i class='fa fa-remove'></i></button><button class='btn btn-third' onClick='duplicate(this);'><i class='fa fa-copy'></i></button></div></td></tr></tfoot>");


        updateCKEditor();
        startSorting();
        updateTimeFunctions();

        window.saveCode = code;

        window.pleaseWait = false;

        if(e.new == "true"){ saveTemplate(); }
        $('#undo').html('Undo <i class="fa fa-undo"></i>');
        $('#redo').html('Redo <i class="fa fa-repeat"></i>');

        $('#the_template a').click(function(e) {     e.preventDefault();    });
        });
    }
}

function saveTemplate(){
    $('#the_template a').css('text-decoration', 'none');

    //if(!window.pleaseWait){
        $('#undo').html("<i class='fa fa-circle-o-notch fa-spin'></i>");
        $('#redo').html("<i class='fa fa-circle-o-notch fa-spin'></i>");
    //window.pleaseWait = true;
	var output = $("#the_template").html();


	$.ajax({url: "/assets/handle.php", method: "POST", data: {action: 'save', template_name: window.templateName, saveCode: window.saveCode, template_data: output, version: (window.currentVersion + 1) } })
	.success(function(e){
        //window.pleaseWait = false;
		console.log("Saved successfully v"+(window.currentVersion - 1));

        $('#undo').html('Undo <i class="fa fa-undo"></i>');
        $('#redo').html('Redo <i class="fa fa-repeat"></i>');
	});


    window.currentVersion += 1;

    if(window.totalVersions > window.currentVersion){
        window.totalVersions  = window.currentVersion;
    }else{
        window.totalVersions  += 1;
    }

    updateTimeFunctions();
    //}
}

$(document).ready(function(){
    $('#backgroundTab li p').click(function(e){
        $('#backgroundTab li').each(function(){
            $(this).addClass('collapsed');
            $(this).find('span').slideUp(500);
        })

        $(this).parent().find('span').removeClass('hidden').css('display', 'none').slideDown(500);
        $(this).parent().removeClass('collapsed');
    });

    $( ".min-slider" ).each(function(e){
    	var max = parseInt($(this).attr('data-max'));
    	var min = parseInt($(this).attr('data-min'));
    	max.to
    	$(this).slider({
    		max: max, 
    		min: min,
    		value: $(e).attr('data-default'),
    		slide: function( event, ui ) {
    			$(this).parent().find('.number').html( ui.value + "px");
    			var toChange = $(this).attr('data-modifies');
    			$("#the_template [data-attr*="+toChange+"]").css($(this).attr('data-cssmodifer'), ui.value+"px");
      		}
		});

		$(this).slider("value", $(this).attr('data-default'));
	});


    $('.tabSelect a').click(function(){
    	$('.tabSelect li').removeClass('active');
    	$(this).parent().addClass('active');
    	var Tab = $(this).attr('data-tab');
    	$('.tabLeft').removeClass('active');
    	$('#'+Tab+'Tab').addClass('active');
    });


    $("input.clrpick").on('blur', function(e){
        var newColor 	= $(this).val();
        var toChange 	= $(this).attr('data-modifies');
        var cssValue    = $(this).attr('data-htmltag');
        $("#the_template [data-attr*="+toChange+"]").css(cssValue, newColor);
        if(cssValue == "background-color"){
            $("#the_template [data-attr*="+toChange+"]").attr('bgcolor', newColor);
        }

        if($(this).attr('data-background') == "1"){ $('#html_bg_color').attr('data-color', newColor); }

        if($("#the_template [data-attr*="+toChange+"]").attr('background-color') != newColor){ saveTemplate(); }
    });


    $('.desktopPreview').click(function(){
    	$("#the_template").removeClass('mobile').removeClass('tablet');
    	$(".desktopPreview").addClass('hidden');
    	$(".tabletPreview").removeClass('hidden');
    	$(".mobilePreview").removeClass('hidden');
    });
    $('.tabletPreview').click(function(){
    	$("#the_template").removeClass('mobile').addClass('tablet');
    	$(".desktopPreview").removeClass('hidden');
    	$(".tabletPreview").addClass('hidden');
    	$(".mobilePreview").removeClass('hidden');
    });
    $('.mobilePreview').click(function(){
    	$("#the_template").addClass('mobile').removeClass('tablet');
    	$(".desktopPreview").removeClass('hidden');
    	$(".tabletPreview").removeClass('hidden');
    	$(".mobilePreview").addClass('hidden');
    });
    

});

function startSorting(){
		$( "#the_template" ).sortable({
    	  items: "[data-element=module]",
    	  handle: ".leftOptions",
    	  placeholder: "ui-state-highlight",
    	  cancel: '',
    	  connectWith: '.connectedSortable',
    	  stop: function(evt, ui){
    	  	setTimeout(saveTemplate, 2000);
    	  }, 
    	  update: function(evt, ui){
            setTimeout(saveTemplate, 2000);
    	  },
          axis: 'y'
    	});

    	$('.moduleSelect').sortable({
    		items: "li",
    		helper: "clone",
            placeholder: "ui-state-highlight",
    		connectWith: '.connectedSortable',
    		remove: function(e, li) {
    			$(li.item).addClass('newlyAdded');
                copyHelper= li.item.clone().insertAfter(li.item);
    		    $(this).sortable('cancel');
		        return $(li).clone();
            },
            sort: function(e, li){
            	$(li).html($(li).attr('data-codetoadd'));
            },
    	  	update: function(evt, ui){
    	  		setTimeout(function(){
    	  			var newHTML = $('#the_template li.newlyAdded').attr('data-codetoadd');
    		  		var newCode = $(newHTML).insertAfter('#the_template li.newlyAdded');
                    $(newCode).addClass('newModule');
                    $('#the_template .newModule[data-element=module]').attr('onmouseover', 'showOptions(this);').css('position', 'relative').append("<tfoot class='hidden'><tr><td><div class='leftOptions'><button class='btn btn-third handle'><i class='fa fa-arrows'></i></button></div><div class='rightOptions'><button class='btn btn-third' onClick='removeModule(this);'><i class='fa fa-remove'></i></button><button class='btn btn-third' onClick='duplicate(this);'><i class='fa fa-copy'></i></button></div></td></tr></tfoot>");
                    $('.newModule').attr('data-cmid', window.moduleID+1);
                    window.moduleID += 1;
                    $('#the_template .newModule[data-element=module] div').addClass('bEditable');
                    $('#the_template .newModule[data-element=module] tfoot div').removeClass('bEditable');
                    $(newCode).removeClass('newModule');
                    $('#the_template li.newlyAdded').each(function(){ $(this).remove() });
                    updateCKEditor();
                    $('#the_template a').click(function(e) {     e.preventDefault();    });
    		  	}, 10);
                setTimeout(saveTemplate, 2000);
	    	}
    	}); 
}



$('#undo').click(function(){    
    if(!window.pleaseWait){
    window.pleaseWait = true;

    $('#undo').html("<i class='fa fa-circle-o-notch fa-spin'></i>");
    $('#redo').html("<i class='fa fa-circle-o-notch fa-spin'></i>");

    if(window.currentVersion == 1){
        alert("Nothing to undo.");
    }else{
        console.log("Loading version ::"+(window.currentVersion - 1));
        $.ajax({url: "/assets/handle.php", method: "POST", data: { template_name: window.templateName, version: (window.currentVersion - 1), action: 'load', saveCode: window.saveCode } })
        .success(function(e){
            window.currentVersion -= 1;
            $("#the_template").html(fixForHTMLTemplate(e));
            $('#the_template [data-element=module]').css('position', 'relative').append("<tfoot class='hidden'><tr><td><div class='leftOptions'><button class='btn btn-third handle'><i class='fa fa-arrows'></i></button></div><div class='rightOptions'><button class='btn btn-third' onClick='removeModule(this);'><i class='fa fa-remove'></i></button><button class='btn btn-third' onClick='duplicate(this);'><i class='fa fa-copy'></i></button></div></td></tr></tfoot>");
            updateCKEditor();
            updateTimeFunctions();

            window.pleaseWait = false;

            $('#undo').html('Undo <i class="fa fa-undo"></i>');
            $('#redo').html('Redo <i class="fa fa-repeat"></i>');
        })
        .error(function(e){
            alert("Error loading that version.");
            window.pleaseWait = false;
        });
    }
    }
});

$('#redo').click(function(){
    if(!window.pleaseWait){

        $('#undo').html("<i class='fa fa-circle-o-notch fa-spin'></i>");
        $('#redo').html("<i class='fa fa-circle-o-notch fa-spin'></i>");

        window.pleaseWait = true;
        console.log("Loading version ::"+(window.currentVersion + 1));
        $.ajax({url: "/assets/handle.php", method: "POST", data: { template_name: window.templateName, version: (window.currentVersion + 1), action: 'load', saveCode: window.saveCode } })
        .success(function(e){
            window.currentVersion += 1;
            $("#the_template").html(fixForHTMLTemplate(e));
            $('#the_template [data-element=module]').css('position', 'relative').append("<tfoot class='hidden'><tr><td><div class='leftOptions'><button class='btn btn-third handle'><i class='fa fa-arrows'></i></button></div><div class='rightOptions'><button class='btn btn-third' onClick='removeModule(this);'><i class='fa fa-remove'></i></button><button class='btn btn-third' onClick='duplicate(this);'><i class='fa fa-copy'></i></button></div></td></tr></tfoot>");
            updateCKEditor();
            updateTimeFunctions();

            $('#undo').html('Undo <i class="fa fa-undo"></i>');
            $('#redo').html('Redo <i class="fa fa-repeat"></i>');

            window.pleaseWait = false;
        })
        .error(function(e){
                alert("Error loading that version.");
                window.pleaseWait = false;
        });
    }
});

function exportTemplate(type){
    if(window.owned){
        $.ajax("/assets/export.php?template_name="+window.templateName+"&saveCode="+window.saveCode+"&type="+type)
        .success(function(e){
            console.log("Awaiting Download...");
            $('body').append('<iframe src="'+e.URL.replace("+", " ")+'" width="1" height="1" frameborder="0"></iframe>');
        }).error(function(e){ console.log(e); });
    }else{
        showPurchaser();
    }
}

function updateBG(value, element){
    if(value != ""){
        $('[data-element='+element+']').attr('background', value);
        $('[data-element='+element+']').css('background-image', "url("+value+")");
        saveTemplate();
    }
}

$('#reset').click(function(e){
    window.location = "/templates/"+window.templateName+"/?reset=t";
});

function sortImages(){
    //$('#the_template img').each(function(){
    $('#the_template [data-element=editableImage]').each(function(){
        var Imaged = $(this).find('img');
        $(Imaged).addClass('toModifyImage');
        $(this).css('position', 'relative');
        var sizes = $(Imaged).width()+"px x " + $(Imaged).height() + "px";
        $(this).click(function(){ $("#the_template .editImage").addClass('hidden'); $(this).find('.editImage').toggleClass('hidden'); $(this).find('.editImage input[name=link]').val($(this).find('a').attr('href')); });

        var ImageID = (new Date).getTime();
        ImageID = ImageID + "l" + Math.random();
        ImageID = ImageID.toString(10);
        ImageID = "cDYc"+ImageID.replace(".", "")+"cDYc";
        $(Imaged).addClass(ImageID);
        $(this).addClass(ImageID+"holder");
        
        if($(this).find('a').length){
            var link = '';
        }else{
            var link = 'hidden';
        }

        if($(this).attr('data-position') == "bottom"){ var classNa = "bottom"; }else{ var classNa = ""; }
        $(this).append("<div class='editImage hidden "+classNa+"'>"
            +"<div class='col-sm-6 text-left'><a href='#' class='"+link+"' onClick='showLink(this);'><img src='/assets/img/image/link_icon_edit_img.png' style='width: 12px!important;' /></a> <a href='#' onClick='removeImage(this);'><img src='/assets/img/image/eye_icon_edit_img.png' style='width: 12px!important;' /></a>"
            +"&nbsp;&nbsp;<a href='#' onClick='loadImageEditor(this)' style='padding-top: 2px;'>Editor</a>"
            +"</div><div class='col-sm-6 text-right'>"+sizes+"</div>"
            +"<div class='col-sm-12'><input type='text' onChange='updateImageLink(this);' name='link' class='hidden' placeholder='http://www.' /></div>"
            +"<div class='col-sm-12'><input type='text' onChange='updateImageURL(this);' name='url' placeholder='Please enter a valid URL' /></div>"
            +"<div class='col-sm-12'>"
            +'<button class="btn btn-white uploadBTN" onclick="uploadImagePress(this);"><span class="one">UPLOAD FROM DESKTOP</span><span class="two hidden"><i class="fa fa-circle-o-notch fa-spi"></i></span></button>'
            +'<form action="/assets/uploadImage.php" method="post" enctype="multipart/form-data" target="uploadFrame" style="display: none;">'
            +'<input type="file" name="fileToUpload" class="fileToUpload" onchange="$(this).parent().submit();">'
            +'<input type="hidden" name="saveCode" value="'+window.saveCode+'" />'
            +'<input type="hidden" name="template" value="'+window.templateName+'" />'
            +'<input type="hidden" name="callBack" value="callbackIG'+ImageID+'" />'
            +'<input type="submit" value="Upload" />'
            +'</form>'
            +"<script>function callbackIG"+ImageID+"(newPath){ $('."+ImageID+"holder').find('.uploadBTN span.one').removeClass('hidden'); $('."+ImageID+"holder').parent().find('.uploadBTN span.two').addClass('hidden');  $('."+ImageID+"').attr('src', newPath); saveTemplate(); }</script>"
            +"</div></div><end></end>");

        if($(Imaged).width() < 250){
            $(this).find('.editImage').css('width', "250px");
            $(this).find('.editImage').css('left', "calc(50% - 125px)");
        }else if($(Imaged).width() > 350){
            $(this).find('.editImage').css('width', "350px");
            $(this).find('.editImage').css('left', "calc(50% - 175px)");
        }else{
            $(this).find('.editImage').css('width', $(Imaged).width());
            $(this).find('.editImage').css('left', "calc(50% - "+(parseInt(($(Imaged).width()+" ").replace(" ", "").replace("px", ""))/2)+'px)');
        }


    });
}

function uploadImagePress(ele){
    $(ele).find('span.one').addClass('hidden');
    $(ele).find('span.two').removeClass('hidden');
    $(ele).parent().find('.fileToUpload').click();
}

function removeImage(ele){
    $(ele).parent().parent().parent().html('');
    saveTemplate();
}

function showLink(ele){
    $(ele).parent().parent().find('[name=link]').toggleClass('hidden');
}

function updateImageURL(ele){
    if(ele.value != ""){
        if (ele.value.indexOf("http://") !=-1 || ele.value.indexOf("https://") !=-1) {
            $(ele).parent().parent().parent().find('img.toModifyImage').attr('src', ele.value);
        }else{
            $(ele).parent().parent().parent().find('img.toModifyImage').attr('src', "http://www."+ele.value);
        }
        saveTemplate();
    }
}

function updateImageLink(ele){
    if(ele.value != ""){
        if (ele.value.indexOf("http://") !=-1 || ele.value.indexOf("https://") !=-1) {
            $(ele).parent().parent().parent().find('img.toModifyImage').parent().attr('href', ele.value);
        }else{
            $(ele).parent().parent().parent().find('img.toModifyImage').parent().attr('href', "http://www."+ele.value);
        }
        saveTemplate();
    }
}

function showPurchaser(){
    $('#blackout').fadeIn(500);
    $('#purchaseNow').fadeIn(500);
}

function closePurchaser(){
    $('#blackout').fadeOut(500);
    $('#purchaseNow').fadeOut(500);
}

$('#the_template a').on('click', function(e){
    e.preventDefault();
});

if(self.location != top.location){
    top.location = self.location;
}

function closeImageEditor(){
    $('#blackout, #imageEditor').fadeOut();
    $('iframe.ImageEditor').attr('src', 'about:blank');
    editType = "image";
}

function editorBackground(element){
    editType = "background";
    var justURL = $('[data-element='+element+']').css('background-image').toString();
    justURL = justURL.replace("url('", "").replace('url("', "").replace('url(', "").replace("')", "").replace('")', "").replace(")", "");
    $('#blackout, #imageEditor').fadeIn();

    updatePath = element;
    
    $('iframe.ImageEditor').attr('src', '/imageeditor/index.php?imageURL='+justURL+'&cacheCode='+window.saveCode+"&template="+window.templateName);
}

var updatePath;
function loadImageEditor(toEdit){
    updatePath = toEdit;
    $('#blackout, #imageEditor').fadeIn();
    $(toEdit).parent().parent().parent().find('img.toModifyImage').addClass('editedImage');
    $('iframe.ImageEditor').attr('src', '/imageeditor/index.php?imageURL='+$(toEdit).parent().parent().parent().find('img.toModifyImage').attr('src')+'&cacheCode='+window.saveCode+"&template="+window.templateName);
}

