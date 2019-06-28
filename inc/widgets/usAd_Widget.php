<?php

if(!class_exists('usAd_Widget')) {

  class usAd_Widget extends WP_Widget {

    /**
    * Sets up the widgets name etc
    */
    public function __construct() {
      $widget_ops = array(
        'classname' => 'usad_widget',
        'description' => 'Ad Widget MPU',
      );
      parent::__construct( 'usad_widget', 'MPU Ad Widget', $widget_ops );
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
        if ( !empty($instance['code']) ) {
            $code = $instance['code'];
        }
        ?>
            
            <div class="mpu_rennab">
                <?php echo $code; ?>
            </div>
        
        <?php

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
        } else {
            $title = __( 'Name', 'uslang' );
        }
        if ( isset($instance['code']) ) {
            $code = $instance['code'];
        } else {
            $code = "";
        }
        ?>
          <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
          </p>
          <p>
            <label for="<?php echo $this->get_field_id( 'code' ); ?>"><?php _e( 'HTML-Code:', "uslang" ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'code' ); ?>" name="<?php echo $this->get_field_name( 'code' ); ?>"><?php echo esc_attr( $code ); ?></textarea>
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
        $instance['code'] = ( ! empty( $new_instance['code'] ) ) ? ( $new_instance['code'] ) : '';
        return $instance;
    }

  }

}
