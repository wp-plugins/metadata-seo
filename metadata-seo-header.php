<?php
    function metadata_seo_header() 
	{
	global $post;
	global $prefix;

	//Get assigned keywords
	$DD_meta_keywords = get_post_meta( $post->ID, $prefix . 'keywords', true );
	//Get assigned meta description
	$DD_meta_description = get_post_meta( $post->ID, $prefix . 'description', true );
	//Get search engine Meta Robot overwrite options
	$DD_follow_nofollow_select = get_post_meta( $post->ID, $prefix . 'follow_nofollow_select', true );

	//Get the global keywords
	$global_keywords = get_option( $prefix . 'global_keywords', '' );
	$global_description = get_option( $prefix . 'global_description','');

//Get the WordPress global privacy setting and if it's blocking serach engines
		if ( '0' == get_option('blog_public') ){?>
		<meta name="robots" content="nofollow, noindex">
		<?php }else{

//Check if the user specified a robot request, if not, treat it as default (follow, index)
		if (empty($DD_follow_nofollow_select)) {?>
		<meta name="robots" content="follow, index">
		<?php } else{
//Check if the user specified a robot request, if yes, replace the default
		?>
			<meta name="robots" content="<?php echo $DD_follow_nofollow_select; ?>">
		<?php }}
		
//If keyword is empty, echo global keywords set in the general setting
		if (empty($DD_meta_keywords)) {?>
		<meta name="keywords" content="<?php echo $global_keywords; ?>" />
		<?php } else{
//If the user has entered custom keywords, replace the global keywords
		?>
			<meta name="keywords" content="<?php echo $DD_meta_keywords; ?>" />
		<?php } 
		
//If meta description is empty, use the site description as meta description
		if (empty($DD_meta_description)) {?>
		<meta name="description" content="<?php echo $global_description; ?>" />
		<?php } else{
//If meta description is set by the user, replace the default description
		?>
			<meta name="description" content="<?php echo $DD_meta_description; ?>" />
		<?php } 

	}
	
add_action('wp_head', 'metadata_seo_header');

?>
