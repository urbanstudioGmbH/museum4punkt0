<?php

if(!class_exists('usHotPicks_Widget')) {

  class usHotPicks_Widget extends WP_Widget {

    /**
    * Sets up the widgets name etc
    */
    public function __construct() {
      $widget_ops = array(
        'classname' => 'ushotpicks_widget',
        'description' => 'Hot Picks',
      );
      parent::__construct( 'ushotpicks_widget', 'Hot Picks', $widget_ops );
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
        extract($args, EXTR_SKIP);
        //echo $before_widget;
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $count = $instance['count'];

        //echo $before_title . $title . $after_title;
        wp_reset_query();
        rewind_posts();

        $recent_posts = new WP_Query(
            array(
                'posts_per_page' => $count,
                'post_status' => 'publish',
                'meta_key' => 'hotpick',
                'meta_value' => 1,
                'meta_compare' => '==',
                'nopaging' => 0,
                'suppress_filters' => 0,
                'post__not_in' => get_option('sticky_posts')
                )
            );

        $postnum = 0;
        if ($recent_posts->have_posts()){
            echo '<div class="widget hotpicks_widget '.$widget_id.'">';
                echo '<h3>' . esc_html($title) . '</h3>';
                echo '<div class="hotpicks">';
                while ($recent_posts->have_posts()) : $recent_posts->the_post();
                    $postnum++;
                    $class = ( $postnum % 2 ) ? ' even' : ' odd';
?>
                    <article class="widget_postentry <?php echo $class; ?>">
                        <a class="link" href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </article>
<?php
                endwhile;
                echo '</div>';
            echo "</div>";
        }
        
        wp_reset_query();
        rewind_posts();

        //echo $after_widget;
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
            $title = __( 'Hot Picks', 'uslang' );
          }
          ?>
          <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
          </p>
          <p>
                <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Anzahl Beiträge:', "uslang" ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" value="<?php echo esc_attr($count); ?>" />
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
        $instance['count'] = $new_instance['count'];
        return $instance;
    }

  }

}
