<?php
// Creating the widget 
class austeve_gallery_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
        // Base ID of your widget
        'austeve_gallery_widget', 

        // Widget name will appear in UI
        __('AUSteve Gallery Widget', 'austeve_gallery_widget_domain'), 

        // Widget description
        array( 'description' => __( 'Preview for a gallery', 'austeve_gallery_widget_domain' ), ) 
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        // This is where you run the code and display the output
        $widgetOutput = "<div class='container'>";
        $widgetOutput .= "<div class='layover'>";
        $widgetOutput .= "<div class='header'><h2 class='title'>".$instance['title']."</h2></div>";
        $widgetOutput .= "<div class='middle'><div class='description'>".$instance['description']."</div></div>";
        
        if (isset($instance['action_url'])) {
            $widgetOutput .= "<div class='footer'><a href='".$instance['action_url']."' class='button' title='".$instance['title']."'>".$instance['action_verb']."</a></div>";
        }
        $widgetOutput .= "</div>"; //div.layover
        $widgetOutput .= "<div class='img'><img src='".$instance['preview_image']."'/></div>";
        $widgetOutput .= "</div>"; //div.container

        echo __( $widgetOutput, 'austeve_gallery_widget_domain' );
        echo $args['after_widget'];
    }
        
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Gallery title', 'austeve_gallery_widget_domain' );
        }

        if ( isset( $instance[ 'preview_image' ] ) ) {
            $preview_image = $instance[ 'preview_image' ];
        }
        else {
            $preview_image = __( '%image url%', 'austeve_gallery_widget_domain' );
        }
        
        if ( isset( $instance[ 'description' ] ) ) {
            $description = $instance[ 'description' ];
        }
        else {
            $description = __( '', 'austeve_gallery_widget_domain' );
        }
        
        if ( isset( $instance[ 'action_url' ] ) ) {
            $action_url = $instance[ 'action_url' ];
        }
        else {
            $action_url = __( '', 'austeve_gallery_widget_domain' );
        }
        
        if ( isset( $instance[ 'action_verb' ] ) ) {
            $action_verb = $instance[ 'action_verb' ];
        }
        else {
            $action_verb = __( 'Text to show on link button', 'austeve_gallery_widget_domain' );
        }

        // Widget admin form
?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        <label for="<?php echo $this->get_field_id( 'preview_image' ); ?>"><?php _e( 'Preview image:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'preview_image' ); ?>" name="<?php echo $this->get_field_name( 'preview_image' ); ?>" type="text" value="<?php echo esc_attr( $preview_image ); ?>" />
        <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Short description:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>" />
        <label for="<?php echo $this->get_field_id( 'action_url' ); ?>"><?php _e( 'Link URL:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'action_url' ); ?>" name="<?php echo $this->get_field_name( 'action_url' ); ?>" type="text" value="<?php echo esc_attr( $action_url ); ?>" />
        <label for="<?php echo $this->get_field_id( 'action_verb' ); ?>"><?php _e( 'Link wording:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'action_verb' ); ?>" name="<?php echo $this->get_field_name( 'action_verb' ); ?>" type="text" value="<?php echo esc_attr( $action_verb ); ?>" />
        </p>
<?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['preview_image'] = ( ! empty( $new_instance['preview_image'] ) ) ? strip_tags( $new_instance['preview_image'] ) : '';
        $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
        $instance['action_url'] = ( ! empty( $new_instance['action_url'] ) ) ? strip_tags( $new_instance['action_url'] ) : '';
        $instance['action_verb'] = ( ! empty( $new_instance['action_verb'] ) ) ? strip_tags( $new_instance['action_verb'] ) : 'Details';
        return $instance;
    }
} // Class austeve_gallery_widget ends here


// Register and load the widget itself
function austeve_gallery_load_widget() {
    register_widget( 'austeve_gallery_widget' );

    $options = get_option('austeve_image_gallery_options');
    $s = isset($options['num_sidebars']) ? $options['num_sidebars'] : '1';
    $pf = isset($options['preview_format']) ? $options['preview_format'] : '0';

    for ( $i = 1; $i <= $s; $i++ ) {
        register_sidebar( array(
            'name'          => 'Gallery preview sidebar '.$i,
            'id'            => 'austeve_gallery_'.$i,
            'before_widget' => '<li class="widget_austeve_gallery_widget preview-format-'.$pf.'">',
            'after_widget'  => '</li>',
            'before_title'  => '',
            'after_title'   => '',
        ) );
    }
}
add_action( 'widgets_init', 'austeve_gallery_load_widget' );
?>
