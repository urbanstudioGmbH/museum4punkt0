(function($){


	var initializeBlock = function( block ) {
		//console.log(block);
       	block.on("click", "a.play-btn", function(){
       		console.log("clicked");
        	var vc = $(this).parent().parent();
        	//console.log(vc);
        	if($(this).attr("data-action") == "check"){
        		showVideo(vc,"check");
        	}else{
        		$.post("/wp-json/block_us_slider/v1/allow/"+$(this).attr("data-type"), function(data){
        			console.log(data);
        			if(data){
        				showVideo(vc,"allow");
        			}	
        		});
        	}
        });

        $(".center",block).slick({
			adaptiveHeight: true
		});
		$(".center",block).on('beforeChange', 
			function(event, slick, currentSlide, nextSlide){
		  		var currentSlideItem = $(this).find('.slick-slide[data-slick-index='+currentSlide+']');
		  		if ( $(".video", currentSlideItem).length !== 0 && $("a.play-btn", currentSlideItem).length == 0 ) {
		  			var src = $('iframe', currentSlideItem).attr("src");
		  			var newsrc = src.replace("autoplay=1","autoplay=0");
		  			$('iframe', currentSlideItem).attr("src", newsrc);
		  		} else {
		  			console.log("no-video, no checked video");
		  		}
		  		
			}
		);
	        
    }
    
	if( window.acf ) {
        window.acf.addAction( 'render_block_preview', initializeBlock );
    }
    
    var showVideo = function(el, type){ 
	    if(type == "allow"){
		    $(".block_us_slider").each(function(i,v){
		    	$(this).find("div.privacy").remove();
		    	$(this).find("div.poster > a.play-btn").attr("data-action", "check");
		    });
	    }
	    el.find("div.video > iframe").attr("src", el.find("div.video > iframe").attr("data-src") );
	    el.find("div.video").show();
	    el.find("figcaption").show();
	    el.find("div.poster").remove();
	}
			
	$(document).ready(function(){
		console.log("in docready");
    	$('.block_us_slider').each(function(){
    		var block = this;
    		$('img', this).load(function() {
			    initializeBlock($(block));
			});
        });
	});
})(jQuery);