
        jQuery('div.blog-filters').on("change", "select", function(){
        	var cat = jQuery("select#category").val();
        	var tag = jQuery("select#post_tag").val();
        	jQuery.get("/wp-json/blogfilters/v1/getposts/"+cat+"/"+tag, function(data){
       			//console.log(data);
       			if(data){
       				//$("div.masonry").html(data);
					//imagesLoaded( '.masonry', function() {
				    /*    var msnry = $('.masonry').masonry({
				            // options
				            columnWidth: '.loop',
				            itemSelector: '.loop',
				            percentPosition: true,
				            gutter: '.gutter-sizer'
						});*/
						var elems = msnry.masonry('getItemElements')
						msnry.masonry('remove', elems);

						var getNodes = str => new DOMParser().parseFromString(str, 'text/html').body.childNodes;
						var controlsNodes = getNodes(data);
						var nodeArray = Array.from(controlsNodes);
						//msnry.masonry('addItems', nodeArray);
						msnry.append( nodeArray ).masonry( 'appended', nodeArray );
						
						imagesLoaded( '.masonry', function() {
							msnry.masonry('layout');
							
						});
						jQuery("nav.pagination").remove();
				    //});
       			}	
       		});
        });

	
