(function($){
    $(document).ready(function()
    {
        
    	var self = this;
    	var slider = $("#showcase-slider");
    	var ani = false;
    	var aniInterval;
    	
    	var slidesNum = 0;
    	var activeSlideId;
    	var nextSlideId;
    	var usslider_zindex = 100;
    	
    	var initialize = function()
    	{
    	    console.log(slider.children("div.sliderItem:not(:first)"));
    	    slider.children("div.sliderItem").each(function(i,v)
    		{
    		    if(i == 0)
    		    {
    		        $(this).css({opacity:1,'z-index':usslider_zindex}).addClass("active");
    		    }
    		    else
    		    {
    		        $(this).css({opacity:0}); 
    		    }
    		});
    		//slider.children("div.sliderItem:not(:first)").css({opacity:0});
    		//slider.children("div.sliderItem:first").css({opacity:1,'z-index':usslider_zindex}).addClass("active");
    
    		setSlidePoints();
    		startAnimation();
    		setHandlers();
    	}
    	
    	var setHandlers = function()
    	{
    		slider.children(".slidePoints").on("click", "a", slidePointClick);
    	}
    	
    	var slidePointClick = function(ev)
    	{
    		ev.preventDefault();
    		ani = false;
    		clearInterval(aniInterval);
    		var slideId = $(this).attr("slideid");
    		slider.children(".slidePoints").children("a.active").removeClass("active");
    		$(this).addClass("active");
    		slider.children("div.sliderItem.active").removeClass("active").animate({opacity: 0}, "slow");
    		slider.children("div.sliderItem").eq(slideId).addClass("active").animate({opacity: 1,'z-index':usslider_zindex}, "slow");
    		ani = true;
    		startAnimation();
    		return false;
    	}
    	
    	var setSlidePoints = function()
    	{
    		var points = [];
    		slider.children("div.sliderItem").each(function(i,v)
    		{
    			$(this).css({position:"absolute",top:"0",left:"0"});
    			points.push('<a href="#setSlide" slideid="'+i+'"></a>');
    			slidesNum++;
    		});
    		slider.children(".slidePoints").html(points.join(""));
    		ani = true;
    		slider.children(".slidePoints").children("a:first").addClass("active");
    		//console.log(slidesNum);
    		//console.log(points.join(""));
    	}
    	
    	var startAnimation = function()
    	{
    		aniInterval = setInterval(function()
    		{
    			if(ani == true)
    			{
    				animate();
    			}
    		},
    		7000);
    	}
    	
    	var animate = function()
    	{
    		slider.children(".slidePoints").children("a.active").removeClass("active");
    		slider.children("div.sliderItem").each(function(i,v)
    		{
    			if($(this).hasClass("active")) activeSlideId = i;
    		});
    		//var activeSlideId = slider.children("div.sliderItem.active").attr("slideid");
    		//console.log("Active: "+activeSlideId);
    		if(activeSlideId == (slidesNum-1))
    		{
    			slider.children(".slidePoints").children("a:first").addClass("active");
    			slider.children("div.sliderItem.active").removeClass("active").animate({opacity: 0}, "slow");
    			slider.children("div.sliderItem").eq(0).addClass("active").animate({opacity: 1}, "slow").css('z-index',usslider_zindex);
    			usslider_zindex = usslider_zindex + 1;
    	
    		}
    		else
    		{
    			var nextSlideId = activeSlideId+=1;
    			//console.log("Next: "+nextSlideId);
    			slider.children(".slidePoints").children("a").eq(nextSlideId).addClass("active");
    			slider.children("div.sliderItem.active").removeClass("active").animate({opacity: 0}, "slow");
    			slider.children("div.sliderItem").eq(nextSlideId).addClass("active").animate({opacity: 1}, "slow").css('z-index',usslider_zindex);
    			usslider_zindex = usslider_zindex + 1;
    		}
    	}
    	
    	initialize(); 
    });
})( window.jQuery || window.Zepto );