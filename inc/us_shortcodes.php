<?php

//toggle shortcode
function pp_toggle( $atts, $content = null ) {
   extract( shortcode_atts(
       array(
           'title' => 'Click To Open'),
       $atts ) );
   return '<h5 class="toggle-trigger"><a href="#">'. $title .'</a></h5><div class="toggle-container"><div class="content">' . do_shortcode($content) . '</div></div>';
}
add_shortcode('toggle', 'pp_toggle');

function usContact($atts, $content = null) {
    extract(shortcode_atts(array(
     "receiver" => '',
     "sender" => '',
     "dsmail" => ''.get_field("us_privacy_email", "options").'',
     "sendername" => "",
     "subject" => ''
     ), $atts));
     $contact = get_field("contact", "options");
     $recaptcha = get_field("recaptcha", "options");
     if(!$receiver) $receiver = $contact["contact_receiver"];
     if(!$sendername) $sendername = $contact["contact_sendername"];
     if(!$sender) $sender = $contact["contact_senderemail"];
     if(!$subject) $subject = $contact["contact_subject"];
    $output = '
       <div class="notification error hide" id="scderror"><p> '.$contact["contact_errormsg"].'</p></div><!-- errormessage -->
       <div class="notification success hide" id="scdsuccess"><p> '.$contact["contact_successmsg"].'</p></div><!-- success -->
       <div id="uscontact">
   
           <div class="resultForm form floating">
               <div class="column one-third no-margin-bottom clear">
                  <div class="usfield fit clear">
                       <label for="company">Firma</label>
                       <div class="usform-wrap"><input type="text" name="company" id="company" value="" size="40" class="usform-form-control emptychk" aria-required="true"></div>
                   </div>
                   <div class="usfield fit last">
                       <label for="country">Name *</label>
                       <div class="usform-wrap"><input type="text" name="name" id="name" value="" size="40" class="usform-form-control emptychk" aria-required="true"></div>
                   </div>
               </div>
               <div class="column one-third no-margin-bottom">	
                   <div class="usfield fit clear">
                       <label for="country">E-Mail-Adresse *</label>
                       <div class="usform-wrap"><input type="text" name="email" id="email" value="" size="40" class="usform-form-control emptychk" aria-required="true"></div>
                   </div>
                   <div class="usfield fit last">
                       <label for="phone">Telefon</label>
                       <div class="usform-wrap"><input type="text" name="phone" id="phone" value="" size="40" class="usform-form-control emptychk" aria-required="true"></div>
                   </div>
               </div>
               <div class="column one-third no-margin-bottom last">	
                   <div class="usfield fit clear last">
                       <label>Nachricht *</label>
                       <div class="usform-wrap"><textarea name="message" id="message" cols="40" rows="10" class="usform-form-control" aria-required="true"></textarea></div>
                   </div>
               </div>
               <div class="column full last no-margin-bottom">
                   <div class="usfield full clear last">
                       <div class="usform-horizontal-checklist">
                           <div class="usform-wrap" style="width:100%;">
                               <input type="checkbox" name="ds" id="ds" value="1"><label for="ds" class="mini">'.strip_tags($contact["contact_dslabel"], "<a>").'</label>
                           </div>
                       </div>
                   </div>
                   <div class="usfield full clear last">
                       <p class="info">'.strip_tags($contact["contact_dsnotice"],"<a>").'</p>
                   </div>
                   <input name="receiver" type="hidden" id="receiver" value="'.$receiver.'" />
                   <input name="subject" type="hidden" id="subject" value="'.$subject.'" />
                   <input name="sender" type="hidden" id="sender" value="'.$sender.'" />
                   <input name="sendername" type="hidden" id="sendername" value="'.$sendername.'" />
                   <input name="formtype" type="hidden" id="formtype" value="contact" />
                   <div class="g-recaptcha" data-sitekey="'.$recaptcha["theme_recaptcha_sitekey"].'" data-callback="US_onsubmit" data-size="invisible"></div>
                   <div class="usbutton align-center no-margin-bottom">
                       <a class="button green medium" onclick="US_validate(\'contact\');" id="sendForm">Absenden</a>
                   </div>
               </div>
           </div>
       </div>
   ';
   return $output;
   }
   add_shortcode("uscontact", "usContact");
   

   // Add the JS
   function uscontact_scripts() {
     wp_enqueue_script( "reCaptcha", "//www.google.com/recaptcha/api.js");
     wp_enqueue_script( 'uscontact', get_template_directory_uri() . '/js/uscontact.js', array('jquery'), '1.0.0', true );
     wp_localize_script( 'uscontact', 'MyAjax', array(
       // URL to wp-admin/admin-ajax.php to process the request
       'ajaxurl' => admin_url( 'admin-ajax.php' ),
       // generate a nonce with a unique ID "myajax-post-comment-nonce"
       // so that you can check it later when an AJAX request is sent
       'security' => wp_create_nonce( 'jhQ73T&vG' )
     ));
   }
   add_action( 'wp_enqueue_scripts', 'uscontact_scripts' );
   
    function sendContact(){
        $recaptcha = get_field("recaptcha", "options");
     if(check_ajax_referer( 'jhQ73T&vG', 'security', false ) === false)
     {
         $r = array("state" => 0, "msg" => "Security! ".$_POST["security"]);
     }else{
         $f = (object)$_POST;
         $postdata = http_build_query(
                  array(
                      'secret' => ''.$recaptcha["theme_recaptcha_secret"].'',
                      'response' => $_POST["g-recaptcha-response"]
                  )
              );
              
              $opts = array('http' =>
                  array(
                      'method'  => 'POST',
                      'header'  => 'Content-type: application/x-www-form-urlencoded',
                      'content' => $postdata
                  )
              );
              
              $context  = stream_context_create($opts);
              
              $result = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
              if(!$result || json_decode($result) == NULL)
              {
                  
                  $r = array("state" => 0, "msg" => "Robot-Check failed!");
              }
              else
              {
                  $json = json_decode($result);
                  if($json->success == true){
                      $PERSONALDATA = "<p>";
                   if($f->company) $PERSONALDATA .= "<strong>Firma:</strong> ".utf8_decode($f->company)."<br>";
                   $PERSONALDATA .= "<strong>Name:</strong> ".utf8_decode($f->name)."<br>";
                   $PERSONALDATA .= "<strong>E-Mail:</strong> ".sanitize_email($f->email)."<br>";
                   if($f->phone) $PERSONALDATA .= "<strong>Telefon:</strong> ".sanitize_text_field($f->phone)."</p>";
                   if($f->domain && $f->domain != "undefined") $PERSONALDATA .= "<strong>Domain:</strong> ".sanitize_text_field($f->domain)."</p>";
                   if($f->message) $PERSONALDATA .= "<p><strong>Nachricht</strong><br>";
                   if($f->message) $PERSONALDATA .= nl2br(stripslashes(utf8_decode($f->message)))."</p>";
   
                      $tpl = file_get_contents(get_template_directory_uri() . "/mails/contact.phtml");
                      $tpl = str_replace("[NAME]", " ".utf8_decode($f->name), $tpl);
                      $tpl = str_replace("[PERSONALDATA]", $PERSONALDATA, $tpl);
                      
                      $contact = get_field("contact", "options");
                      $req = sendMail(sanitize_email($f->email), sanitize_text_field($f->subject), '', $tpl, array("sender" => ($contact["contact_senderemail"]), "bcc" => ($contact["contact_receiver"]), "sendername" => $contact["contact_sendername"], "replyto" => sanitize_email($f->email), "notpl" => 1));
                      //$req = sendMail(sanitize_email($contact["contact_receiver"]), sanitize_text_field($f->subject), '', $tpl, array("sender" => sanitize_email($contact["contact_sender"]), "sendername" => sanitize_text_field($contact["contact_sendername"]), "replyto" => sanitize_email($f->email), "notpl" => 1));
                     if($req) $r = array("state" => 1); else $r = array("state" => 0, "msg" => "Mail could not been sent.");
                  }else{
                      $r = array("state" => 0, "msg" => "Robot-Check failed!");
                  }
              }
     }
     echo json_encode($r);
     die(); // this is required to return a proper result
   }
   add_action( 'wp_ajax_nopriv_sendContact', 'sendContact' );
   add_action( 'wp_ajax_sendContact', 'sendContact' );
 
// Columns shortcode
function us_columns( $atts, $content = null ){
 extract( shortcode_atts(
 array(
 'class' => ''),
 $atts ) );
 return '<div class="columns '.$class.'">'.do_shortcode($content).'<div class="clear"></div></div>';
}
 add_shortcode('columns', 'us_columns');
 
// Column shortcode
function us_column( $atts, $content = null ){
	extract( shortcode_atts(
 		array(
 			'type' => '',
			'class' => ''
 			),
 	$atts ) );

 	return '<div class="column '.$type.' '.$class.'">'.do_shortcode($content).'</div>';
}
 add_shortcode('column', 'us_column');
 
 // MiniText shortcode
function us_minitext( $atts, $content = null ){
	extract( shortcode_atts(
 		array(
 			'type' => '',
			'class' => ''
 			),
 	$atts ) );
 	return '<div class="minitext">'.do_shortcode($content).'</div>';
}
add_shortcode('minitext', 'us_minitext');



function usSlider( $atts, $content = null ){
    extract( shortcode_atts(
                array(
                    'active' => false,
                    'slides' => array()
                ),
                $atts
            )
    );
    wp_enqueue_script( 'usslider', get_template_directory_uri() . '/js/us_slider.js', array( 'jquery' ), '', true );
    $return = "";
    if($active && count($slides) >= 1){
        $return .= '<section id="headergap"></section>';
        $return .= '<div id="showcase">';
            $return .= '<div class="bottomline"></div>';
            $return .= '<div id="showcase-slider">';
                $return .= '<div class="slidePoints"></div>';
                $i = 0;
                foreach($slides AS $slide){
                    $link = $slide["linkslide"] == "intern" ? $slide["slidelink_intern"] : $slide["slidelink_extern"];
                    $return .= '<div class="sliderItem">';
                        if($slide["linkslide"] != "none") $return .= '<a href="'.$link.'" class="slideitem" target="'.$slide["linktarget"].'" title="'.$slide['slidename'].'">';          
                            //echo '<img src="'.$slide['slidepic']['sizes']['slides'].'" alt="'.$slide['slidename'].'" />';
                            $return .= '<picture>';
                                $return .= '<source media="(min-width: 1401px)" srcset="'.$slide["slide_desktop_wide"]["sizes"]["slide_desktop_wide"].'">';
                                $return .= '<source media="(min-width: 660px)" srcset="'.$slide["slide_desktop_wide"]["sizes"]["slide_desktop"].'">';
                                $return .= '<source srcset="'.$slide["slide_mobile"]["sizes"]["slide_mobile"].'">';
                                $return .= '<img src="'.$slide["slide_desktop_wide"]["sizes"]["slide_desktop_wide"].'" alt="'.$slide['slidename'].'">';
                            $return .= '</picture>';
                        if($slide["linkslide"] != "none") $return .= '</a>';
                        $return .= '</div>';
                    $i = !$i ? 1 : $i;
                }
            $return .= '</div>';
        $return .= '</div>';
    }
    return $return;
}
add_shortcode('usslider', 'usSlider');