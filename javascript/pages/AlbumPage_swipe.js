var isTouch = 'ontouchstart' in window || navigator.msMaxTouchPoints;
var c = false;

$(document).ready(function(){setup()});
$(window).load(function(){setup()});
$(window).resize(function(){checkSwiper()});

function setup()
{
	initSwiper();
	checkSwiper();
}

function initSwiper()
{
	$("#thumbs").swipe({
		excludedElements: [],
		allowPageScroll: "vertical",
		swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
			if(direction == "up" || direction == "right")
			{
				c.animate({'left':'+=50','opacity':0},250, function(){
					$(this).hide();
					c = $(this).prev().length ? $(this).prev() : $(this).parent().find('> li:last-child');					
					c.css('left',0).css('opacity',1).show();
				});				
			} 
			else if(direction == "down" || direction == "left")
			{
				c.animate({'left':'-=50','opacity':0},250, function(){
					$(this).hide();
					c = $(this).next().length ? $(this).next() : $(this).parent().find('> li:first-child');					
					c.css('left',0).css('opacity',1).show();
				});
			}			
		}
	});	
	
}

function checkSwiper()
{
	if($(window).width() > 399 || !isTouch)
	{
		$("#thumbs").removeClass().swipe("disable");
	}
	else
	{
		$("#thumbs").addClass("swiper").swipe("enable");
		c = $("#thumbs > li:first-child");
	}
}