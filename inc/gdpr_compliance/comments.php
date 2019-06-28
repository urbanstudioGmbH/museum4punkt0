<?php
/**
 * Comment Form
 *
 * @package     GDPRComments\CommentForm
 * @since       1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Maybe adjust default comment form fields
 *
 * @param $fields
 *
 * @return mixed
 */
function us_comment_form_default_fields( $fields ) {

	if ( isset( $fields['cookies'] ) ){ unset( $fields['cookies'] ); }
    return $fields;
}
add_filter( 'comment_form_default_fields', 'us_comment_form_default_fields' );

/**
 * Add our fields before the comment form button appears
 *
 * @param $submit_field
 * @param $args
 *
 * @return mixed
 */
function us_comment_form_add_fields( $submit_field, $args ) {

 
    ob_start();

    us_comment_form_scripts();
    $ca = get_field("comments_agreement", "options");
    $ct = get_field("datenschutz_infotext", "options");
    if(defined("ICL_LANGUAGE_CODE")){
        $fields = get_field('ds_'.ICL_LANGUAGE_CODE, 'options');
        $ca = $fields["comments_agreement"];
        $ct = $fields["datenschutz_infotext"];
    }
    ?>
    <div id="us-gdpr-comments-compliance">
        <!-- Checkbox -->
        <div id="us-gdpr-comments-checkbox-wrap">
            <input id="us-gdpr-comments-checkbox" type="checkbox" name="us-gdpr_comments_checkbox" value="1" required="required" />
            <label for="us-gdpr-comments-checkbox" class="us-gdpr-comments-label"><?php echo $ca; ?></label>
        </div>
        <!-- Text -->
        <div id="gdpr-comments-compliance-text">
            <?php echo $ct; ?>
        </div>
    </div>

    <?php
    $compliance_fields = ob_get_clean();

    // Return
    return $compliance_fields . $submit_field;
};

// add the filter
add_filter( 'comment_form_submit_field', 'us_comment_form_add_fields', 99, 2 );

/**
 * Output form scripts
 */
function us_comment_form_scripts() {

    ?>
    <script type="text/javascript">
        jQuery(document).ready(function( $ ) {

            var submitCommentButton = $('#commentform input#submit');
            var commentCheckbox = $('#us-gdpr-comments-checkbox');

            // Disable button by default
            submitCommentButton.prop( "disabled", true );

            // Handle checkbox actions
            commentCheckbox.change(function(){

                if ( this.checked ) {
                    submitCommentButton.prop( "disabled", false );
                } else {
                    submitCommentButton.prop( "disabled", true );

                }
            });

        });
    </script>
    <?php
}

add_action( 'set_comment_cookies', function( $comment, $user ) {
    setcookie( 'ta_comment_wait_approval', '1', 0, '/' );
}, 10, 2 );

add_action( 'init', function() {
    if( isset( $_COOKIE['ta_comment_wait_approval'] ) && $_COOKIE['ta_comment_wait_approval'] === '1' ) {
        setcookie( 'ta_comment_wait_approval', '0', 0, '/' );
        add_action( 'comment_form_before', function() {
            echo '<div id="wait_approval"><span>'.__("Kommentar wurde eingereicht und wartet auf Freischaltung.", "uslang").'</span></div>';
        });
    }
});

add_filter( 'comment_post_redirect', function( $location, $comment ) {
    $location = get_permalink( $comment->comment_post_ID ) . '#wait_approval';
    return $location;
}, 10, 2 );