<?php

class block_us_pricingtable{

    function __construct(){
        add_action('acf/init', array($this, "block_us_pricingtable_register"));
    }

    public function block_us_pricingtable_register(){
        $this->block_us_pricingtable_fields();
        acf_register_block(array(
            'name'				=> 'block_us_pricingtable',
            'title'				=> __('Preistabelle', "uslang"),
            'description'		=> __('erzeugt eine Preistabelle mit 3 angeboten', "uslang"),
            'render_callback'	=> array($this, 'block_us_pricingtable_render'),
            'category'		=> 'usblocks',
            'icon'			=> '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="euro-sign" class="svg-inline--fa fa-euro-sign fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M310.706 413.765c-1.314-6.63-7.835-10.872-14.424-9.369-10.692 2.439-27.422 5.413-45.426 5.413-56.763 0-101.929-34.79-121.461-85.449h113.689a12 12 0 0 0 11.708-9.369l6.373-28.36c1.686-7.502-4.019-14.631-11.708-14.631H115.22c-1.21-14.328-1.414-28.287.137-42.245H261.95a12 12 0 0 0 11.723-9.434l6.512-29.755c1.638-7.484-4.061-14.566-11.723-14.566H130.184c20.633-44.991 62.69-75.03 117.619-75.03 14.486 0 28.564 2.25 37.851 4.145 6.216 1.268 12.347-2.498 14.002-8.623l11.991-44.368c1.822-6.741-2.465-13.616-9.326-14.917C290.217 34.912 270.71 32 249.635 32 152.451 32 74.03 92.252 45.075 176H12c-6.627 0-12 5.373-12 12v29.755c0 6.627 5.373 12 12 12h21.569c-1.009 13.607-1.181 29.287-.181 42.245H12c-6.627 0-12 5.373-12 12v28.36c0 6.627 5.373 12 12 12h30.114C67.139 414.692 145.264 480 249.635 480c26.301 0 48.562-4.544 61.101-7.788 6.167-1.595 10.027-7.708 8.788-13.957l-8.818-44.49z"></path></svg>',
            'align'         => 'wide',
            'supports'      => array("align" => array("wide","full")),
            'keywords'		=> array("article", "featured")
        ));
    }

    public function block_us_pricingtable_render($block, $content = '', $is_preview = false){
        $pt = get_field('block_us_pricingtable_data');
        $blockid = 'block_pricingtable-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = $block['align'] ? 'align' . $block['align'] : 'alignwide';
        wp_enqueue_style("block_us_pricingtable", get_template_directory_uri()."/css/block_pricingtable.css");
        //wp_enqueue_script("block_us_pricingtable", get_template_directory_uri()."/js/block_faq.js");
        $maxrows = max(count($pt[0]["rows"]), count($pt[1]["rows"]), count($pt[2]["rows"]));
        //echo "<pre>".print_r($pt,1)."</pre>";
        $c = "";

        if($pt && count($pt)){
            echo '<div class="prices '.$alignclass.'" id="'.$blockid.'">';
            foreach($pt AS $i => $table){
                echo '<div class="pricing_table '.(!$i ? "first" : ($i == 1 ? "second recommended" : "third")).'">';
                    echo '<div class="pricing_title"><h4>'.$table["title"].'</h4></div>';
                    echo '<div class="pricing"> <span class="price">'.$table["price"].'</span> <span class="price_sub">'.$table["priceinfo"].'</span></div>';
                    echo '<ul>';
                    $rc = 0;
                    foreach($table["rows"] AS $rowid => $row){
                        $rc++;
                        echo '<li>'.$row["row"].'</li>';
                    }
                    if($rc < $maxrows){
                        for($er = $rc; $er < $maxrows; $er++){
                            echo '<li class="pricetabhide">&nbsp;</li>';
                        }
                    }
                    echo '</ul>';
                    echo '<div class="order"> <a href="'.$table["btnlink"]["url"].'" class="theme-button orderbtn" title="'.$table["btnlink"]["title"].'" '.($table["btnlink"]["target"] ? ' target="'.$table["btnlink"]["target"].'"' : '').' data-product="'.$table["title"].'">'.$table["btntext"].'</a></div>';    
                echo '</div>';   
            }
                echo '<div class="clear"></div>';
            echo '</div>';
        }else{
            if(\is_admin()){
                $c .= '<div class="block_us_pricingtable '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
            }
        }
        echo $c;
    }

    public function block_us_pricingtable_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5c5bd0bd001a3',
                'title' => 'Block: Pricing Table',
                'fields' => array(
                    array(
                        'key' => 'field_5c5bd0cc25d3e',
                        'label' => 'Preistabelle',
                        'name' => 'block_us_pricingtable_data',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'collapsed' => '',
                        'min' => 3,
                        'max' => 3,
                        'layout' => 'block',
                        'button_label' => 'Preisblock hinzufügen',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5c5bd11e25d3f',
                                'label' => 'Name',
                                'name' => 'title',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 1,
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
                                'key' => 'field_5c5bd17b25d40',
                                'label' => 'Preis',
                                'name' => 'price',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
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
                                'key' => 'field_5c5bd1a925d41',
                                'label' => 'Preisinfo',
                                'name' => 'priceinfo',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => 'Euro / Monat',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                            ),
                            array(
                                'key' => 'field_5c5bd1f325d42',
                                'label' => 'Angebotszeilen',
                                'name' => 'rows',
                                'type' => 'repeater',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'collapsed' => '',
                                'min' => 3,
                                'max' => 10,
                                'layout' => 'block',
                                'button_label' => 'Zeile hinzufügen',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_5c5bd21925d43',
                                        'label' => 'Zeile',
                                        'name' => 'row',
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
                                ),
                            ),
                            array(
                                'key' => 'field_5c5bd28425d44',
                                'label' => 'Button-Text',
                                'name' => 'btntext',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
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
                                'key' => 'field_5c5bd29925d45',
                                'label' => 'Button-Link',
                                'name' => 'btnlink',
                                'type' => 'link',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'return_format' => 'array',
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-pricingtable',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'field',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
            ));
            
            endif;
    }
}
$block_us_pricingtable = new block_us_pricingtable();