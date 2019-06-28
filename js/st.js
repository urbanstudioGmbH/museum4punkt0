  
        function US_validate(formtype){
        	//var formtype = jQuery("#formtype").val();
        	var tf = false;
        	jQuery("#errormessagetxt").html("Bitte füllen Sie alle mit Stern (*) markierten Felder aus um Ihre Anfrage zu senden!");
        	if(formtype == "contact"){
				if(
	                
	                jQuery("#name").val().length >= 5 &&
	                //jQuery("#company").val().length >= 2 &&
	                jQuery("#email").val().length >= 7 &&
	                jQuery("#message").val().length >= 1
	              )
	            {
	            	if(jQuery("input[name=ds]:checked").length == 1){
						tf = true;
	            	}else{
	            		jQuery("#errormessagetxt").html("Bitte stimmen Sie unseren Datenschutzhinweisen zu.");
	            	}
				}
        	}else if(formtype == "order"){
				if(
	                
	                jQuery("#name").val().length >= 5 &&
	                //jQuery("#company").val().length >= 2 &&
	                jQuery("#email").val().length >= 7 &&
	                jQuery("#phone").val().length >= 1
	              )
	            {
					if(jQuery("input[name=ds]:checked").length == 1){
						tf = true;
	            	}else{
	            		jQuery("#errormessagetxt").html("Bitte stimmen Sie unseren Datenschutzhinweisen zu.");
	            	}
				}
        	}
        	console.log("tf: "+tf);
        	if(tf == false){
        		jQuery("#errormessage").show();
                scrollToElem("errormessage");
				
	            jQuery("#success").hide();
	            grecaptcha.reset();
        	}else{
        		grecaptcha.execute();
        	}
		}
		
		function US_onsubmit(){
			var btn = jQuery(this);
		    if(jQuery("#formtype").val() == "contact"){          
	            var data = {
	                'action' : 'sendStData',
	                'security' : ''+MyAjax.security+'',
	                'company': ''+jQuery("#company").val()+'',
	                'name': ''+jQuery("#name").val()+'',
	                'email': ''+jQuery("#email").val()+'',
	                'phone': ''+jQuery("#phone").val()+'',
	                'message': ''+jQuery("#message").val()+'',
	                'sender': ''+jQuery("#sender").val()+'',
	                'sendername': ''+jQuery("#sendername").val()+'',
	                'receiver': ''+jQuery("#receiver").val()+'',
	                'subject': ''+jQuery("#subject").val()+'',
	                'g-recaptcha-response' : ''+grecaptcha.getResponse()+'' 
	            };
		    }else if(jQuery("#formtype").val() == "order"){          
	            var data = {
	                'action' : 'sendOrderData',
	                'security' : ''+MyAjax.security+'',
	                'company': ''+jQuery("#company").val()+'',
	                'name': ''+jQuery("#name").val()+'',
	                'email': ''+jQuery("#email").val()+'',
	                'phone': ''+jQuery("#phone").val()+'',
	                'message': ''+jQuery("#message").val()+'',
	                'domain': ''+jQuery("#domain").val()+'',
	                'product': ''+jQuery("#product").val()+'',
	                'sender': ''+jQuery("#sender").val()+'',
	                'sendername': ''+jQuery("#sendername").val()+'',
	                'receiver': ''+jQuery("#receiver").val()+'',
	                'subject': ''+jQuery("#subject").val()+'',
	                'subject_customer': ''+jQuery("#subject_customer").val()+'',
	                'g-recaptcha-response' : ''+grecaptcha.getResponse()+'' 
	            };
		    }
            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(MyAjax.ajaxurl, data, function(d)
            {
                //console.log(d);
                if(d.state == 1)
                {
                    //btn.text("Vielen Dank").unbind("click");
                    jQuery("#errormessage").hide();
                    jQuery("#success").show();
                    scrollToElem("success");
                    jQuery("#uscontact,#usorder").hide();
                    jQuery("#productinfo").hide();
                    grecaptcha.reset();
                }
                else
                {
                    //alert("Daten konnten nicht gesendet werden.");
                    jQuery("#errormessagetxt").html("Ihre Nachricht konnte nicht versandt werden. Bitte versuchen Sie es später erneut.");
                    jQuery("#errormessage").show();
                    scrollToElem("errormessage");
                    jQuery("#success").hide();
                    grecaptcha.reset();
                }//alert('Got this from the server: ' + response);
            },"json");

        }
       
       	jQuery("#wrapper").on("click", ".orderbtn", function(ev){
       		ev.preventDefault();
       		var p = jQuery(this).data("product");
       		var sp = p.split("|");
       		jQuery("#product").html('<option value="'+p+'">'+sp[0]+'</option>');
       		jQuery("#productinfo").find("h2").html(sp[2]);
       		jQuery("#productinfo").find("span").html(sp[3]);
       		var spi = jQuery("#productinfo").data("show_product_info");
       		if(spi == 1){
       			jQuery("#productinfo").removeClass("hide").show();
       			scrollToElem("errormessage");	
       		}
       		return false;
       	});
       	
       	jQuery("#wrapper").on("click", ".orderbtn2", function(ev){
       		ev.preventDefault();
       		var p = jQuery(this).data("product");
       		jQuery("#product").val(p);

       		scrollToElem("anfrage");	
       		return true;
       	});
       	
       	var scrollToElem = function(elemId){
       		jQuery('html, body').animate({
		        scrollTop: jQuery("#"+elemId+"").offset().top-80
		    }, 2000);
       	}

