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
					caption : this.description,
					width : this.fullsize_image.width,
					height: this.fullsize_image.height,
					photo_id : this.id
				}
			});
		});

		$(".album-image").click(function(e){
			e.preventDefault();
			var specs=getImageById($(this).attr('data-photo-id'));
			var index=specs.index;
			$.fancybox.open( fancybox_collection, { padding:0 },index );
		});
		
	});	
	
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