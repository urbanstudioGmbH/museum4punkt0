<?php

/**
 * Adding a custom field to Attachment Edit Fields
 * @param  array $form_fields 
 * @param  WP_POST $post        
 * @return array              
 */
function us_add_media_custom_field( $form_fields, $post ) {
    $field_value = get_post_meta( $post->ID, 'copyright', true );
    $form_fields['copyright'] = array(
        'value' => $field_value ? $field_value : '',
        'label' => __( 'Copyright', "uslang" ),
        'helps' => __( 'Geben Sie eine Copyright-Information ein.' ),
        'input'  => 'text'
    );
    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'us_add_media_custom_field', null, 2 );

/**
 * Saving the attachment data
 * @param  integer $attachment_id 
 * @return void                
 */
function us_save_attachment( $attachment_id ) {
    if ( isset( $_REQUEST['attachments'][ $attachment_id ]['copyright'] ) ) {
        
        $copyright = $_REQUEST['attachments'][ $attachment_id ]['copyright'];
        update_post_meta( $attachment_id, 'copyright', $copyright );
    
    }
}
add_action( 'edit_attachment', 'us_save_attachment' );