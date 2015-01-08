<?php
/* 
Plugin Name: Metadata SEO
Plugin URI: http://www.hpinfosys.com/ 
Description: Add Keywords, Description to Global / Individual Pages/ Individual Post for SEO
Version: 1.0
Author: Hitesh Patel
Author URI: http://hpinfosys.com
*/

$prefix='metadata_seo_';

include( plugin_dir_path( __FILE__ ) . 'metadata-seo-global.php');
include( plugin_dir_path( __FILE__ ) . 'metadata-seo-post.php');
include( plugin_dir_path( __FILE__ ) . 'metadata-seo-header.php');


?>