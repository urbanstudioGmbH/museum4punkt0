/*-----------------------------------------------------------------------------------
/*
/* Custom JS
/*
-----------------------------------------------------------------------------------*/

/* Start Document */
function US_toTop(){
	jQuery(window).scroll(function () {
		if(jQuery(window).scrollTop()>0){ jQuery('body').addClass('fixed'); } else { jQuery('body').removeClass('fixed'); }
    });
}

(function($){
	$(document).ready(function(){

        $('body').removeClass('no-js').addClass('js');

		$("#navigation > ul").append("<li id='searchbtn'><b><i class='fas fa-search'></i><span>Suche</span></b></li>");

		$("#navbtn").click(function(){
            if($("#navbtn").hasClass("opened")){
                $("#navigation").animate({'opacity':'hide','height':'hide'},"fast");
                $("#navbtn").removeClass("opened");
            }else{
                $("#navigation").animate({'opacity':'show','height':'show'},"slow");
                $("#navbtn").addClass("opened");
            }
		});

		$('#searchbtn').click(function() {
			if ($('#searchbtn').hasClass('opened')) {
				$('#searchbtn, #globalsearch').removeClass('opened');
				//$('#globalsearch').hide();
			} else {
				$('#searchbtn, #globalsearch').addClass('opened');
				//$('#globalsearch, #globalsearch').show();
				$('#globalsearch .search input').focus();


				if($(window).width() < 767){
					$("#navigation").animate({'opacity':'hide','height':'hide'},"fast");
	                $("#navbtn").removeClass("opened");
				}
			}
		});

		var lastScrollTop = 0;
		$(window).scroll(function(event){
		  var st = $(this).scrollTop();
		  if (st > lastScrollTop){
			if (!$('body').hasClass('down')) {
			  $('body').addClass('down');
			}
		   } else {
			 $('body').removeClass('down');
		   }
		   lastScrollTop = st;
		   if ($(this).scrollTop() <= 0) {
			 $('body').removeClass('down');
		   };
		});

		US_toTop();

		$('a.close').click(function(e){
			e.preventDefault();
			$(this).parent().fadeOut();
		});

		$('ul.wp-block-gallery li a').magnificPopup({
		  type: 'image',
		  closeOnContentClick: true,
		  mainClass: 'my-mfp-zoom-in',
		  gallery:{
			enabled:true
		  },

		});
		$('.wp-block-image a').magnificPopup({
		  type: 'image',
		  closeOnContentClick: true,
		  mainClass: 'my-mfp-zoom-in',
		  gallery:{
			enabled:true
		  },

		});

/* End Document */

});

})(this.jQuery);
