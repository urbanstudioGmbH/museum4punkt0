<?php

if(!class_exists('usAboutbox_Widget')) {

  class usAboutbox_Widget extends WP_Widget {

    /**
    * Sets up the widgets name etc
    */
    public function __construct() {
      $widget_ops = array(
        'classname' => 'usaboutbox_widget',
        'description' => 'About Box',
      );
      parent::__construct( 'usaboutbox_widget', 'About Box', $widget_ops );
    }

    /**
    * Outputs the content of the widget
    *
    * @param array $args
    * @param array $instance
    */
    public function widget( $args, $instance ) {
      // outputs the content of the widget
      if ( ! isset( $args['widget_id'] ) ) {
        $args['widget_id'] = $this->id;
      }
      //echo '<pre>'.print_r($args,1).'</pre>';
      // widget ID with prefix for use in ACF API functions
      $widget_id = 'widget_' . $args['widget_id'];
      if ( !empty($instance['title']) ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
      }
      //$title = get_field( 'title', $widget_id ) ? get_field( 'title', $widget_id ) : '';
      $html = get_field( 'html', $widget_id ) ? get_field( 'html', $widget_id ) : '';
      $image_array = get_field( 'image', $widget_id );
      $image_src = $image_array["sizes"]["aboutbox"];
      //echo $args['before_widget'];
      echo '<div class="widget aboutbox_widget '.$widget_id.'"><div class="aboutbox_frame">';

      if($image_src && !empty($image_src)){
          echo '<div class="aboutbox_image"><img src="'.$image_src.'" alt="'.esc_html($title).'" title="'.esc_html($title).'"></div>';
      }
      if ( $title ) {
        echo '<h3>' . esc_html($title) . '</h3>';
      }
      
      if($html) {
          echo '<div class="text">'.$html.'</div>';
      }
      echo '</div></div>';
      //echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        // outputs the options form on admin
        if ( isset($instance['title']) ) {
            $title = $instance['title'];
          }
          else {
            $title = __( 'Name', 'uslang' );
          }
          ?>
          <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
          </p>
          <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     *
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }

  }

}
