<?php
function metadata_seo_header() 
	{
	global $post;
	global $metadata_prefix;

	//Get assigned keywords
	$DD_meta_keywords = get_post_meta( $post->ID, $metadata_prefix . 'keywords', true );
	//Get assigned meta description
	$DD_meta_description = get_post_meta( $post->ID, $metadata_prefix . 'description', true );
	//Get search engine Meta Robot overwrite options
	$DD_follow_nofollow_select = get_post_meta( $post->ID, $metadata_prefix . 'follow_nofollow_select', true );

	//Get the global keywords
	$global_keywords = get_option( $metadata_prefix . 'global_keywords', '' );
	$global_description = get_option( $metadata_prefix . 'global_description','');

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



/* Metadata SEO Open Graph for facebook */
function metadata_seo_og_header() 
	{

	global $post;
	global $metadata_prefix;

	$metadata_seo_fb_url = get_permalink();
	$metadata_seo_fb_admins = get_option( $metadata_prefix . 'fb_admins', '' );
	$metadata_seo_fb_appid = get_option( $metadata_prefix . 'fb_appid', '' );
	

	$metadata_seo_fb_title = get_post_meta( $post->ID, $metadata_prefix . 'og_title', true );
	$metadata_seo_fb_description = get_post_meta( $post->ID, $metadata_prefix . 'og_description', true );
	$metadata_seo_fb_type = get_post_meta( $post->ID, $metadata_prefix . 'og_type', true );
	$metadata_seo_fb_image = get_post_meta( $post->ID, $metadata_prefix . 'og_image', true );

	if (empty($metadata_seo_fb_description)) {
		$metadata_seo_fb_description = get_option( $metadata_prefix . 'fb_description', ''); }
	if (empty($metadata_seo_fb_description)) {
		$metadata_seo_fb_description = get_option( $metadata_prefix . 'global_description','');	}

	if (empty($metadata_seo_fb_title)) {
		$metadata_seo_fb_title = get_option( $metadata_prefix . 'fb_title', ''); }
	if (empty($metadata_seo_fb_title)) {
		$metadata_seo_fb_title = get_the_title(); }
		
	if (empty($metadata_seo_fb_type)) {
		$metadata_seo_fb_type = get_option( $metadata_prefix . 'fb_type', ''); }
	
	if (empty($metadata_seo_fb_image)) {
		$metadata_seo_fb_image = get_option( $metadata_prefix . 'fb_image', ''); }

	if (!empty($metadata_seo_fb_admins) or !empty($metadata_seo_fb_appid))
	{
		?>
        <meta property="og:url" content="<?php echo $metadata_seo_fb_url; ?>" />
        <meta property="og:title" content="<?php echo $metadata_seo_fb_title; ?>" />
		<meta property="og:description" content="<?php echo $metadata_seo_fb_description; ?>" />
        <meta property="og:image" content="<?php echo $metadata_seo_fb_image; ?>" />
        <meta property="og:type" content="<?php echo $metadata_seo_fb_type; ?>" />
        <?php
		if (!empty($metadata_seo_fb_appid)) {
		?>
        <meta property="fb:app_id" content="<?php echo $metadata_seo_fb_appid; ?>" />
        <?php }
		if (!empty($metadata_seo_fb_admins)) {
			?>
        <meta property="fb:admins" content="<?php echo $metadata_seo_fb_admins; ?>" />
		<?php }
	}
}
add_action('wp_head', 'metadata_seo_og_header');


?>
