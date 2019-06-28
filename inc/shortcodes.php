<?php
/**
 * SHORTCODES
 */


function purelist($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => ''
        ), $atts));
    return '<div class="'.$type.'">'.$content.'</div>';
}
add_shortcode('list', 'purelist');






require_once 'us_shortcodes.php';
?>