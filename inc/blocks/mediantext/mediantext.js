(function($){
	
	var initializeBlock = function( block ) {
		console.log(block);
       	block.on("click", "a.play-btn", function(){
       		console.log("clicked");
        	var vc = $(this).parent().parent();
        	if($(this).attr("data-action") == "check"){
        		showVideo(vc,"check");
        	}else{
        		$.post("/wp-json/block_us_mediantext/v1/allow/"+$(this).attr("data-type"), function(data){
        			console.log(data);
        			if(data){
        				showVideo(vc,"allow");
        			}	
        		});
        	}
        });
	        
    }
    
	if( window.acf ) {
        window.acf.addAction( 'render_block_preview', initializeBlock );
    }
    
    var showVideo = function(el, type){ 
	    if(type == "allow"){
		    $(".block_mediantext").each(function(i,v){
		    	$(this).find("div.privacy").remove();
		    	$(this).find("div.poster > a.play-btn").attr("data-action", "check");
		    });
	    }
	    el.find("div.video > iframe").attr("src", el.find("div.video > iframe").attr("data-src") );
	    el.find("div.video").show();
	    el.find("div.poster").remove();
	}
			
	$(document).ready(function(){
		console.log("in docready");
    	$('.block_mediantext').each(function(){
            initializeBlock( $(this) );
        });
        
	});
})(jQuery);