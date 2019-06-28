<?php

//TODO latest posts with thumbnail


add_action('widgets_init', 'urbanstudio_load_widgets');

// US_Widgets

$us_widgetpath = dirname(__FILE__)."/widgets/";
$usw = scandir($us_widgetpath); $us_widgets = array();
foreach($usw AS $i => $us_widgetfile)
{
	if(is_file($us_widgetpath.$us_widgetfile) && !in_array($us_widgetfile, array(".","..")))
	{
		$tmp = explode(".", $us_widgetfile);
		array_push($us_widgets, $tmp[0]);
		require_once($us_widgetpath.$us_widgetfile);
	}
}


    function urbanstudio_load_widgets() {
		global $us_widgets;
        //register_widget('incredible_flickr');
       // register_widget('incredible_popular');
        //register_widget('urbanstudio_latest');
        //register_widget('urbanstudio_twitter_widget');
		foreach($us_widgets AS $us_widget)
		{
			register_widget(''.$us_widget.'');
		}
		//register_widget('urbanstudio_sidebarad');
        //register_widget('incredible_followers_widget');

    }



    ?>