(function($){
	$(document).ready(function()
	{	
	   // init accordion for module
	   $(".accordion").each(function(i, el) {
	   		if( $(".ui-state-active", el).length !== 0 ) {
	   			$(el).accordion({
					heightStyle: "content"
				});
	   		} else {
	   			$(el).accordion({
					heightStyle: "content",
					active: false,
    				collapsible: true 
				});
	   			
	   		}
	   })
		

	    // Do not change anything below this line
	
	    /*var el;
	    
	    var initialize = function()
	    {
	        $("div.block_us_faq").each(function(i,v)
	        {
	            $(this).children("div.faq-item.active").children("div.faq-answer").show(); 
	        });
	        setHandlers();    
	    }
	    
		var setHandlers = function()
		{ 
		   $("div.block_us_faq").on("click", "div.faq-item > div.faq-question", openclose);
		}
		
		var openclose = function()
		{
		    if(!$(this).parent().hasClass("active"))
		    {
		        el = $(this).parent();
		        $(this).parent().parent().children("div.faq-item").each(function(i,v)
		        {
		            //$(this).children("div.faq-answer").slideUp("slow")
		            $(this).children("div.faq-answer").animate({'opacity':'hide','height':'hide'})
		            $(this).removeClass("active");
		        });
		        el.children("div.faq-answer").animate({'opacity':'show','height':'show'});
		        el.addClass("active");
		    }else{
		    	$(this).parent().children("div.faq-answer").animate({'opacity':'hide','height':'hide'})
		        $(this).parent().removeClass("active");
		    }
		}
		*/
	});
})( window.jQuery );