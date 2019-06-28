<?php
/**
 * "Kontakt 'n Text" Block for Gutenberg
 * 
 * @version 1.0.0
 * @package usblocks
 * @author Marian Feiler <mf@urbanstudio.de>
 * @copyright 2019 urbanstudio GmbH
 * @license Commercial
 * @link https://www.urbanstudio.de
 */

/**
 * Block class for "Kontakt 'n Text" Block for Gutenberg
 */
class block_us_contactntext{
    /**
     * constructor adds action on "acf/init" to register block
     */
    function __construct(){
        add_action('acf/init', array($this, "block_us_contactntext_register"));
    }
    /**
     * Register block in Wordpress Gutenberg editor
     *
     * @return void
     */
    public function block_us_contactntext_register(){
        $this->block_us_contactntext_fields();
        acf_register_block(array(
            'name'				=> 'block_us_contactntext',
            'title'				=> __('Kontakt plus Text', "uslang"),
            'description'		=> __('erzeugt einen Block, mit Kontakt sowie Text jeweils links oder rechts.', "uslang"),
            'render_callback'	=> array($this, 'block_us_contactntext_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'format-image',
            'mode'          => 'auto',
            'keywords'		=> array("article", "related"),
            'supports'      => array("align" => false)
        ));
        add_editor_style("inc/blocks/contactntext/contactntext.css");
    }
    /**
     * Render block HTML to display in frontend or preview in Gutenberg
     *
     * @param array $block
     * @param string $content
     * @param boolean $is_preview
     * @param int $post_id
     * @return void
     */
    public function block_us_contactntext_render($block, $content = '', $is_preview = false, $post_id = null){
        $person = get_field('block_us_contactntext_person');
        $personlr = get_field('block_us_contactntext_lr');
        $hl = get_field('block_us_contactntext_text_hl');
        $text = get_field('block_us_contactntext_text');

        $blockid = 'block_contactntext-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = $block['align'] ? 'align' . $block['align'] : '';
        $alignclass = '';
        $c = "";
        if(!\is_admin()) wp_enqueue_style("block_contactntext_style", get_template_directory_uri()."/inc/blocks/contactntext/contactntext.css");
        $tc = '<div class="grid-column '.($personlr == "left" ? "right" : "left").'">';
            $tc .= '<div class="grid-text">';
                $tc .= '<h3>'.$hl.'</h3>';
                $tc .= '<div class="text">'.$text.'</div>';
            $tc .= '</div>';
        $tc .= '</div>';
        if($hl && $person){
            $extrafields = get_field(strtolower(ICL_LANGUAGE_CODE), $person);
            echo '<div class="block_contactntext contact-text-container '.$alignclass.'" id="'.$blockid.'">';
			//echo '<div class="center">';
                if($personlr == "right") echo $tc;
				echo '<div class="grid-column '.$personlr.'">';
                    echo '<div class="grid-contact">';
                        echo '<div class="list-contacts-picture">';
                            if (has_post_thumbnail($person)) {
                                $tnid = get_post_thumbnail_id($person);
                                $imagearr = wp_get_attachment_image_src($tnid, 'aboutbox');
                                $image = $imagearr[0];
                            }else{
                                $image = get_template_directory_uri()."/inc/blocks/contactntext/persons_default.jpg";
                            }
                            echo '<img class="image-responsive list-contacts-image-item" src="'.$image.'" alt="'.esc_attr(get_the_title($person)).'">';
                        echo '</div>';
                        echo '<div class="list-contacts-person-details">';
                            echo '<h3 class="list-contacts-name">'.esc_html(get_the_title($person)).'</h3>';
                            $position = $extrafields["postition"];
                            //echo "<pre>".print_r($extrafields,1)."</pre>";
                            //echo $extrafields["postition"];
                            if (!empty($position)) {
                                echo '<p class="list-contacts-position">'.esc_html($position).'</p>';
                            }
                            $telefon = $extrafields["telefon"];
                            if (!empty($telefon)) {
                                echo '<a class="list-contacts-fon" href="tel:'.esc_attr($telefon).'">'.esc_html($telefon).'</a>';
                            }
                            $email = $extrafields["email"];
                            if (!empty($email)) {
                                echo '<a class="list-contacts-email" href="mailto:'.esc_attr($email).'">'.esc_html($email).'</a>';
                            }
                            $link = $extrafields["url"];
                            if ($link) {
                                $link_target = $link['target'] ? $link['target'] : '_blank';
                                echo '<a class="list-contacts-url" href="'.esc_attr($link["url"]).'" target="'.$link_target.'">'.esc_html($link["title"]).'</a>';
                            }
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                if($personlr == "left") echo $tc;
            //echo '</div>';
            echo '</div>';
        }else{
            if(\is_admin()){
                $c .= '<div class="block_related '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
                echo $c;
            }
        }
    }
    /**
     * Register additional fields via ACF
     *
     * @return void
     */
    public function block_us_contactntext_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5cb3756457099',
                'title' => 'Block: Kontakt plus Text',
                'fields' => array(
                    array(
                        'key' => 'field_5cb375749b60f',
                        'label' => 'Kontakt',
                        'name' => '',
                        'type' => 'column',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'column-type' => '1_2',
                    ),
                    array(
                        'key' => 'field_5cb375cc170a5',
                        'label' => 'Kontakt auwählen',
                        'name' => 'block_us_contactntext_person',
                        'type' => 'post_object',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'post_type' => array(
                            0 => 'kontakt',
                        ),
                        'taxonomy' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'return_format' => 'object',
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_5cb37605170a6',
                        'label' => 'Kontakt anzeigen...',
                        'name' => 'block_us_contactntext_lr',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'left' => 'Links',
                            'right' => 'Rechts',
                        ),
                        'allow_null' => 0,
                        'default_value' => 'left',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                    ),
                    array(
                        'key' => 'field_5cb37655170a7',
                        'label' => 'Text-Bereich',
                        'name' => '',
                        'type' => 'column',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'column-type' => '1_2',
                    ),
                    array(
                        'key' => 'field_5cb3766a170a8',
                        'label' => 'Überschrift',
                        'name' => 'block_us_contactntext_text_hl',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_5cb37681170a9',
                        'label' => 'Text',
                        'name' => 'block_us_contactntext_text',
                        'type' => 'wysiwyg',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'tabs' => 'all',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                        'delay' => 0,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-contactntext',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
            
            endif;
    }
}
$block_us_contactntext = new block_us_contactntext();
