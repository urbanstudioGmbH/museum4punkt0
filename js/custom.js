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

		// check if sortable exists

		// default: false
		var hasSortable = false;
		if ( $("#sortable").length !== 0 ) {

			// exists: true
			hasSortable = true;
			// add jump link hrefs
			$("#jump-menu a").each(function(i,el) {
				var type = $(el).text();
				var plainType = type.replace(/\W/g,'_');
				$(el).attr("href", "#"+plainType);
			});



			$('html').click(function() {
				console.log("click");
			  	if ( $("#sortable-menu ul").hasClass("show") ) {
					$("#sortable-menu ul").removeClass("show");
				}
			});

			$('#sortable-menu').click(function(event){
			    event.stopPropagation();
			});
		}
	  	
		// save last scroll pos
		var lastScrollTop = 0;
		var jumptop = 0;
		var diff = 100;
		// on scroll, update scroll pos
		$(window).scroll(function(event){
		  var st = $(this).scrollTop();
		  if ( $("body").hasClass("home") ) {
		  	var introOffset = $("main .intro").offset();
		  	if (st > introOffset.top) {
		  		$(".flyntComponent canvas").css("visibility", "hidden");
		  	} else {
		  		$(".flyntComponent canvas").css("visibility", "inherit");
		  	}
		  }
		  // if sortable exists
		  if ( hasSortable ) {
		  	// get offset of content following sortable
		  	var followingOffset = $(".following-content").offset();

		  	// default sortable offset
		  	var sortableOffset = 0;
		  	// get sortable offset top
			sortableOffset = $("#sortable").offset();
			sortableOffset = sortableOffset.top;

			// breakpoint for smaller headbar
			var intViewportWidth = window.innerWidth;
			var intViewportHeight = window.innerHeight;
			// get height of navigation based on css breakpoints
			diff = $("#header").height();

			var menuHeight = $(".sortable-menu-wrapper").height();
			$(".sortable-menu-placeholder").css("min-height", menuHeight + "px");


			jumptop = sortableOffset - diff;
			// fix sortable navigation if:
			// sortable offset not 0 (mobile)
			// and scrollpos is bigger than sortable offset - navigation height
			// and scrollpos smaller than sortable end (or bigger than following content offset)
			if (sortableOffset !== 0 && st > (sortableOffset - diff)  && intViewportWidth >= 768 && st < (followingOffset.top - diff - 100)) {
				$("#sortable").addClass("fixed");
				
				$(".sortable-menu-wrapper").css("top", diff + "px");
				if (st > jumptop) {
					$("#scrolltop-results").show();
				}
				

			} else if (sortableOffset !== 0 && st <= (sortableOffset - diff) || st >= (followingOffset.top - diff - 100)) {
				$("#sortable").removeClass("fixed");
				$("#scrolltop-results").hide();
			}
			// show fixed jump menu on mobile if 
			// is mobile (< tablet) 
			// and scrollpos is smaller than sortable end (or bigger than following content offset)
			if (intViewportWidth < 768 && st >= (followingOffset.top - intViewportHeight)) {
				$("#jump-menu").hide();
				$("#scrolltop-results").hide();
			} else {
				$("#jump-menu").show();
				if (intViewportWidth < 768 && st > jumptop) {
					$("#scrolltop-results").show();
				}
				
			}

		}


		  // menu

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

		// initiate isotope
		var $grid = $('#sortable-content');

		$grid.isotope({
		  // options
			itemSelector: '.item',
			layoutMode: 'fitRows',
			getSortData: {
				order: '[data-order] parseInt',
				projects: '[data-project] parseInt',
				original: '[data-original-order] parseInt' // not set here
			},
			sortBy: ["order","projects"]
		});
		// dropdown select for sort category on mobile
		$(".selected-helper").on("click", function(e) {
			$("#jump-menu ul.show-mobile").removeClass("show-mobile");
			if ( $("#sortable-menu ul").hasClass("show") ) {
				$("#sortable-menu ul").removeClass("show");
			} else {
				$("#sortable-menu ul").addClass("show");
			}
		});

		

		// select sort category
		$("#sortable-menu li a").on("click", function(e) {
			e.preventDefault();

			// reset height of sortable menu
			var menuHeight = $(".sortable-menu-wrapper").height();
			$(".sortable-menu-placeholder").css("min-height", menuHeight + "px");
			// get sortable offset top and scroll to it, to reset scroll pos
			var sortableOffset = 0;
			// breakpoint for smaller headbar
			
			// get height of navigation based on css breakpoints
			var diff = $("#header").height();
			sortableOffset = $("#sortable").offset();
			sortableOffset = sortableOffset.top;
			sortableOffset = sortableOffset - diff;

			if (lastScrollTop > sortableOffset) {
				$("html, body").animate({ scrollTop: sortableOffset }, 150); 
			}
			


			
			
			
			


			// get sort category
			var sortByValue = $(this).attr('data-sort-by');
			
			if ( $(this).hasClass("selected") ) {

				// empty state (deselect sort)

				// set isotope layoutmode
				layoutModeValue = 'fitRows';

				// remove class sorted to grid
				$grid.removeClass("sorted");
				
				// remove selected class for menu item
				$(this).removeClass("selected");

				// empty dropdown select
				$("#sortable-menu .selected-helper").addClass("empty").empty();

				// hide all jump-menus
				$("#jump-menu ul").hide();

				// hide dropdown select menu on mobile
				$("#sortable-menu ul").removeClass("show");

				// remove data attribute for sort order and separating headline names
				$(".item").each(function(i, el) {
					$(el).removeAttr("data-type data-order");
				});

				// remove separating headlines
				$("#sortable-content .separator").each( function(i,el) {
					$(el).remove();
				});

				// update isotope sorting: set back to default
				$grid.isotope('updateSortData')
				.isotope({
					layoutMode: layoutModeValue,
					sortBy: ["original", "projects"]
					//sortBy: 'original-order'
				});

			} else {

				// selected state (sort by selected category -> data order)

				// set isotope layoutmode
				layoutModeValue = 'typeRows';

				// set class sorted to grid
				$grid.addClass("sorted");
				
				// remove class empty for dropdown select on mobile
				$("#sortable-menu .selected-helper").removeClass("empty");

				// get selected category name and add to dropdown select on mobile
				$("#sortable-menu li a.selected").removeClass("selected");
				var selectedLabel = $(this).text();
				$("#sortable-menu .selected-helper").text(selectedLabel);

				// add selected class for menu item
				$(this).addClass("selected");

				// show dropdown select menu on mobile
				$("#sortable-menu ul").removeClass("show");

				// hide open jump-menus
				$("#jump-menu ul").hide();

				// get category
				var sortSelector = $(this).attr("href");


				// show selected jump-menu by category
				$(sortSelector).show();
				
				// remove old active class
				$('li', sortSelector).removeClass("active");
				// set active class to first headline
				$('li:first-child', sortSelector).addClass("active");

				//console.log(sortSelector);
				
				// get order of jump-menu items
				var sortOrderArray = [];
				$('li a', sortSelector).each(function (i, el) {
				  sortOrderArray.push($(el).attr("href").replace("#",''));
				});
				console.log(sortOrderArray);

				// set order and category values for separating headlines to item

				$(".item").each(function(i, el) {
					// set type attribute so that isotope knows what headlines
					// to use.
					var type = $('.'+ sortByValue, el).text().trim();
					$(el).attr("data-type", type);


					// set order by selected menu item (by sanitizing the type,
					// i.e. lowercase and underscores)
					var plainType = type.replace(/\W/g,'_');
					var itemIndex = sortOrderArray.indexOf(plainType);
					$(el).attr("data-order", itemIndex);
				});

				// set isotope sorting
				$grid.isotope('updateSortData')
				.isotope({
					layoutMode: layoutModeValue,
					sortBy: ["order","projects"]
				});

				// set nav points for jump-menu indication
				setTimeout(function() {
					$(sortSelector).navpoints({offset: 100});

				},1000);
			}

			

			
		});
		var jumping = false;
		// jump to headline with click on jump-menu item 
		$("#jump-menu a").on("click", function(e) {
			jumping = true;
			e.preventDefault();
			$("#sortable-menu ul").removeClass("show");
			

			// default (mobile)
			var fixedOffset = 0;
			var intViewportWidth = window.innerWidth;
			// if is desktop view with fixed navigations
			if (intViewportWidth >= 768) {
				fixedOffset = (160 + 107); // height of fixed navigation + fixed sortable menus
			}
			console.log(fixedOffset);
			var stopScroll = false;
			if (fixedOffset == 0) {
				var sortSelector = $("#sorts li a.selected").attr("href");
				if ( $(this).parents("ul").find("li:not(.active)").is(":hidden") ) {
					$(sortSelector).addClass("show-mobile");
					stopScroll = true;
				} else {
					$(sortSelector).removeClass("show-mobile");
				}
			}

			

			// get jump href
			var hRef = $(this).attr("href");

			// if jump target (separating headline) exists, scroll to target
			if ($(hRef).length !== 0 && stopScroll == false)  {
				// get target offset
				var hrefOffset = $(hRef).offset();
				// calculate with fixed navigations
				var scrollToPos = (hrefOffset.top - fixedOffset);
				// scroll
				$("html, body").animate({ scrollTop: scrollToPos }, 300); 
			} else {
				// no items with this tag
				console.log("no items for this target");
			}
			stopScroll = false;
			

		});
		$("#jump-menu ul").on("click", function(e) {
			if (jumping == false) {
				if ($(this).hasClass("show-mobile")) {
					$(this).removeClass("show-mobile");
				}
			} else {
				jumping = false;
			}
			
		});

		$("#scrolltop-results").on("click", function(e) {
			e.preventDefault();
			$("html, body").animate({ scrollTop: jumptop }, 150); 
		});
		$(".arrow-down").on("click", function(e) {
			e.preventDefault();
			var scrollto = $(this).attr("href");
			var scrolltoOffset = $(scrollto).offset().top;
			scrolltoOffset = scrolltoOffset - diff;
			$("html, body").animate({ scrollTop: scrolltoOffset }, 150); 
		});
		// toggle info box on result detail
		$(".infobox .arrow-plus").on("click", function(e) {
			e.preventDefault();
			if ( $(this).hasClass("show") ) {
				$(".infobox dl").slideUp();
				$(this).removeClass("show");
			} else {
				$(".infobox dl").slideDown();
				$(this).addClass("show");
			}
			
		});
		
		// init items slider
		$(".items.slider").slick({
			dots: false,
			infinite: false,
			speed: 300,
			slidesToShow: 4,
			slidesToScroll: 1,
			centerMode: false,
			responsive: [
				{
				  breakpoint: 1024,
				  settings: {
				    slidesToShow: 3,
				    slidesToScroll: 1,
				    infinite: false,
				    dots: true
				  }
				},
				{
				  breakpoint: 768,
				  settings: {
				    slidesToShow: 2,
				    slidesToScroll: 1,
				    dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
				  	infinite: true,
				    slidesToShow: 1,
				    slidesToScroll: 1,
				    dots: true
				  }
				}
			]
		});
		/*var animatedItem = false;
		var timer;
		$(".item a").mouseenter(function(e) {

			$(this).addClass("transition-init");
			animatedItem = $(this).data("item");

			timer = setTimeout(function () {
				
		       $(".item a[data-item="+animatedItem+"]").removeClass("transition-init");

		    }, 300);
			
			
		});


		$('.item a').on('mousemove', function(e) {

		  var item = $('article', this);

		 

		  var figure = $('figure', item);
		  var footer = $('footer', item);

		  var shadowX = e.pageX - $(item).offset().left;
		  var shadowY = e.pageY - $(item).offset().top;

		  shadowX =	( shadowX /50) + 5;
		  shadowY =	( shadowY /50) + 5;

		  


		  var figureX = e.pageX - $(figure).offset().left;
		  var figureY = e.pageY - $(figure).offset().top;

		  figureX = (-figureX /50) + 5;
		  figureY = (-figureY /50) + 5;
		  

		  var footerX = e.pageX - $(footer).offset().left;
		  var footerY = e.pageY - $(footer).offset().top;

		  footerX = (-footerX /43) + 5;
		  footerY = (-footerY /43) + 5;


		  $(item).attr('style','--x:'+ shadowX +'px; --y:'+ shadowY +'px; --figX:'+ figureX +'px; --figY:'+ figureY +'px');
		  $(footer).attr('style','--x:'+ footerX +'px; --y:'+ footerY +'px');
		 
		});*/

		

		

/* End Document */

});

})(this.jQuery);
