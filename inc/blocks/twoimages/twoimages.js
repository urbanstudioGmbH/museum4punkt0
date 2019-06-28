(function($){
	$(document).ready(function(){
		$('.grid-images a').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			mainClass: 'my-mfp-zoom-in',
			gallery:{
				enabled:true
			},
		});
	});
})(jQuery);