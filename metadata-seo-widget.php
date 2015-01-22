<?PHP
// Register and load the widget
function metadata_seo_load_widget() {
	register_widget( 'metadata_seo_widget' );
}
add_action( 'widgets_init', 'metadata_seo_load_widget' );


// Creating the widget for random category view
class metadata_seo_widget extends WP_Widget {
	function __construct() {
		parent::__construct
		(
		'metadata_seo_widget', // UNIQUE Base ID of your widget
		__('FaceBook Like & Share', 'metadata_seo_widget', 'metadata-seo'), // Widget name will appear in UI
		array( 'description' => __( 'View Like & Share link for Facebook', 'metadata_seo_widget' , 'metadata-seo'), ) // Widget description
		);
	}
	/**
	* Front-end display of widget.
	*
	* @see WP_Widget::widget()
	*
	* @param array $args     Widget arguments.
	* @param array $instance Saved values from database.
	*/
	function widget( $args, $instance ) {
		$fb_title = apply_filters( 'fb_title', $instance['fb_title'] );
		$fb_showface = apply_filters( 'fb_showface', $instance['fb_showface'] );
		$fb_layout = apply_filters( 'fb_layout', $instance['fb_layout'] );
		
		$showface='false';
		if ($fb_showface!=0) { $showface='true'; }
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $fb_title ) )
		{
			echo $args['before_title'] . $fb_title . $args['after_title'];
		}
		// This is where you run the code and display the output ( e.g. name of template )
		echo metadata_seo_fb($showface, $fb_layout);
		echo $args['after_widget'];
	}
	
	/**
	* Back-end widget form.
	*
	* @see WP_Widget::form()
	*
	* @param array $instance Previously saved values from database.
	*/
	function form( $instance ) {
		$fb_title =  ! empty( $instance['fb_title'] ) ? $instance['fb_title'] : __( 'Facebook Like & Share', 'metadata_seo_widget' , 'metadata-seo');
		$fb_showface =  ! empty( $instance['fb_showface'] ) ? $instance['fb_showface'] : __( 'facebook', 'metadata_seo_widget' , 'metadata-seo');
		$fb_layout = ! empty( $instance['fb_layout'] ) ? $instance['fb_layout'] : __( 'standard', 'metadata_seo_widget' , 'metadata-seo');
	// Widget admin form
	?>
	<p>
	<label for="<?php echo $this->get_field_id( 'fb_title' ); ?>"><?php _e( 'Title:' , 'metadata-seo'); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'fb_title' ); ?>" name="<?php echo $this->get_field_name( 'fb_title' ); ?>" type="text" value="<?php echo esc_attr( $fb_title ); ?>" />

	<label for="<?php echo $this->get_field_id( 'fb_showface' ); ?>"><?php _e( 'Show Face:' , 'metadata-seo'); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'fb_showface' ); ?>" name="<?php echo $this->get_field_name( 'fb_showface' ); ?>" type="checkbox" value="true" <?php echo checked( $fb_showface ); ?> />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />

	<label for="<?php echo $this->get_field_id( 'fb_layout' ); ?>"><?php _e( 'Type:' , 'metadata-seo'); ?></label> 
    <select class="widefat" id="<?php echo $this->get_field_id( 'fb_layout' ); ?>" name="<?php echo $this->get_field_name( 'fb_layout' ); ?>">
		<option value="standard" <?php selected( $instance['fb_layout'], 'standard'); ?>>Standard</option>
        <option value="box_count" <?php selected( $instance['fb_layout'], 'box_count'); ?>>Box Count</option>
        <option value="button_count" <?php selected( $instance['fb_layout'], 'button_count'); ?>>Button Count</option>
        <option value="button" <?php selected( $instance['fb_layout'], 'button'); ?>>Button</option>
     </select>
	</p>
	<?php 
	}
	/**
	* Sanitize widget form values as they are saved.
	*
	* @see WP_Widget::update()
	*
	* @param array $new_instance Values just sent to be saved.
	* @param array $old_instance Previously saved values from database.
	*
	* @return array Updated safe values to be saved.
	*/
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['fb_title'] = ( ! empty( $new_instance['fb_title'] ) ) ? strip_tags( $new_instance['fb_title'] ) : '';
		$instance['fb_showface'] = ( ! empty( $new_instance['fb_showface'] ) ) ? true : false;
		$instance['fb_layout'] = ( ! empty( $new_instance['fb_layout'] ) ) ? strip_tags( $new_instance['fb_layout'] ) : 'standard';
		return $instance;
	}
} // metadata_seo_widget ends here

function open_graph_fb_show_shortcode( $atts )
{
	extract(shortcode_atts(array(
		  'showface' => 'false',
		  'layout' => 'standard'
	   ), $atts));	
	metadata_seo_fb( $showface, $layout );
}
add_shortcode( 'fb-view','open_graph_fb_show_shortcode');

function metadata_seo_fb($showface, $layout)
{
	$url=get_permalink();
	echo '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script>';

echo '<div class="fb-like" data-href="' . $url . '" data-layout="' . $layout .'" data-action="like" data-show-faces="' . $showface . '" data-share="true"></div>';

//echo '<div class="fb-like" data-href="' . $url . '" data-colorscheme="light" data-show-faces="' . $showface . '" data-header="true" data-stream="false" data-show-border="true" data-share="true" data-width="'. $width . '"></div>';

//echo '<div class="fb-facepile" data-href="' . $url . '" data-max-rows="1" data-colorscheme="light" data-size="medium" data-show-count="true"></div>';

//echo '<div class="fb-share-button" data-href="' . $url . '" data-layout="button_count"></div>';
}
?>