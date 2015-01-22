<?php
/* 
Plugin Name: Metadata SEO
Plugin URI: http://www.hpinfosys.com/ 
Description: Add Keywords, Description to Global / Individual Pages/ Individual Post for SEO, working with OPEN GRAPH Metadata for Facebook
Version: 2.3
Author: Hitesh Patel
Author URI: http://hpinfosys.com
*/
global $metadata_prefix;
$metadata_prefix='metadata_seo_';

include( plugin_dir_path( __FILE__ ) . 'metadata-seo-options.php');
include( plugin_dir_path( __FILE__ ) . 'metadata-seo-post.php');
include( plugin_dir_path( __FILE__ ) . 'metadata-seo-opengraph-post.php');
include( plugin_dir_path( __FILE__ ) . 'metadata-seo-header.php');
include( plugin_dir_path( __FILE__ ) . 'metadata-seo-widget.php');

?>