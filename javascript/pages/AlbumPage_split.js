(function($){
	"use strict";
	$(document).ready(function(){
		preloadImages();
		var fancybox_collection = [];
		$.each(images, function(){
			fancybox_collection.push({
				type : 'image',
				src : this.fullsize_image.url,
				opts : {
					caption : this.full_description,
					width : this.fullsize_image.width,
					height: this.fullsize_image.height,
					photo_id : this.id,
					beforeShow : function(instance, slide){
						setPreviewImageById(slide.opts.photo_id);
					}
				}
			});
		});

		// show fancybox when preview image is clicked
		$("#preview_image > a").click(function(){
			var specs=getImageById($(this).attr('data-photo-id'));
			var index=specs.index;
			$.fancybox.open( fancybox_collection, { padding:0 },index );
		});
		// show preview image when thumbnail is clicked
		$(".album-image").click(function(e){
			e.preventDefault();
			if($("#gallery_right").is(":visible")){
				setPreviewImageById($(this).attr('data-photo-id'));
			}else{
				var specs=getImageById($(this).attr('data-photo-id'));
				var index=specs.index;
				$.fancybox.open( fancybox_collection, { padding:0 },index );
			}
		});
	});
	function setPreviewImageById(id){
		var image=getImageById(id);
		if(!image) { return; }
		$("#preview_image > a").attr('data-photo-id',id);
		$("#preview_image").stop(true,false).fadeTo(100,0.01,'linear',function(){
			var bHeight=$(this).height();
			$(this).find('img').attr('src',image.large_image.url);
			var aHeight=$(this).height();
			$(this).height(bHeight).animate({
				'height':aHeight+'px',
				'opacity':'1.00'
			},100,'linear',function(){
				$(this).css('height','');
			});			
		});
		var it=$("#image-text");
		var bith=it.height();
		it.empty().append($(image.description));
		var aith=it.height();
		it.height(bith).animate({
			'height':aith+'px'
		},200,'linear',function(){
			$(this).css('height','');
		});
	}
	function getImageIndexById(id){
		for(var i=0;i<images.length;i++){
			if(images[i].id===parseInt(id)){
				return i;
			}
		}
		return false;
	}
	function getImageById(id){
		var i=getImageIndexById(id);
		if(typeof images[i] === 'object'){
			images[i].index=i;
			return images[i];
		}
		return false;
	}	
	function preloadImages() {
		$(images).each(function(){
			$('<img/>')[0].src = this.large_image.url;
		});
	}	
}(jQuery));