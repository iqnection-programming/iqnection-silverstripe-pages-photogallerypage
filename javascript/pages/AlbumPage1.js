var current_source = 0;

$(document).ready(function(){
	preload(images);
	$('#photo_wrap a').fancybox();
	setupClicks();			
	ajax_image(first_id);
	ajax_text(first_id);
});	

$(window).resize(function(){
	setupClicks();	
});

function setupClicks(){
	if($(window).width() > 599){
		$('a.fancy_link').off('click.fb-start').unbind('click').click(function(event){
			event.preventDefault();
			var id = $(this).attr('data-id');
			switchContent(id);
		});	
	} else {
		$('a.fancy_link').unbind('click').fancybox({
			fitToView:'true',
			scrolling:'no',
			type:'ajax',
			live: false,
			helpers: {
				overlay : {
					locked: false
				}
			}
		});
	}
}

function ajax_image(image_id){
	$('#ajax-loader').fadeIn(100);
	$.ajax({
		url: page_link+"photo/ajax_image/"+image_id,
		global: false,
		dataType: "html",
		async: true,
		cache: true,
		success: function(data) {
			$('#ajax_image').html(data);
			$('#photo_wrap a').fancybox({
				'onUpdate': function () { current_source = $('.fancybox-image').attr('src').match(/assets(.+)/gi); },
				'beforeClose': function() { fancyClosed(); }
			});
			$('#ajax-loader').fadeOut(100);
			$('#ajax_image').fadeTo(350,1);
		}
	});
}

function ajax_text(image_id){
	$.ajax({
		url: page_link+"photo/ajax_text/"+image_id,
		global: false,
		dataType: "html",
		async: true,
		cache: true,
		success: function(data) {
			$('#ajax_text').html(data);
			$('#ajax_text').fadeIn(350);
		}
	});
}

function fancyClosed(){
	var id = $("#photo_wrap a[href='/"+current_source[0]+"']").attr('id');
	if(id){
		var current_image_id = id.replace(/[^\d]/g, "");
		switchContent(current_image_id);
	}
}

function switchContent(id){
	$('#ajax_text').fadeOut(150,function(){
		ajax_text(id);
	});
	$('#ajax_image').fadeTo(150,.01,function(){
		ajax_image(id);
	});	
}

function preload(arrayOfImages) {
	$(arrayOfImages).each(function(){
		$('<img/>')[0].src = this;
		// Alternatively you could use:
		// (new Image()).src = this;
	});
}