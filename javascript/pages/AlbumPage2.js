$(document).ready(function(){
	preload(images);
	$('a.fancy_link').fancybox({
		fitToView:'true',
		scrolling:'auto',
		scrollOutside:false,
		arrows:true,
		type:'ajax',
		helpers: {
			overlay : {
				locked: false
			}
		}
	});
});	

function preload(arrayOfImages) {
	$(arrayOfImages).each(function(){
		$('<img/>')[0].src = this;
		// Alternatively you could use:
		// (new Image()).src = this;
	});
}	