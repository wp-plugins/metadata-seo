<?php
global $metadata_prefix;

add_option( $metadata_prefix . 'global_keywords', '' );
add_option( $metadata_prefix . 'global_description', '' );
add_option( $metadata_prefix . 'fb_title', '' );
add_option( $metadata_prefix . 'fb_description', '' );
add_option( $metadata_prefix . 'fb_image', '' );
add_option( $metadata_prefix . 'fb_type', 'website' );
add_option( $metadata_prefix . 'fb_admins', '' );
add_option( $metadata_prefix . 'fb_appid', '' );

function metadata_seo_plugin_menu()
{
	add_options_page( 'Metadata SEO', 'Metadata SEO', 'manage_options', 'metadata_seo_global', 'metadata_seo_plugin_options' );

// here is the code for creating my option field
	add_action( 'admin_init', 'metadata_seo_settings' );
}
add_action( 'admin_menu', 'metadata_seo_plugin_menu' );

function metadata_seo_settings() 
{
  global $metadata_prefix;
  register_setting( 'metadata_seo_settings_group', $metadata_prefix . 'global_keywords' );
  register_setting( 'metadata_seo_settings_group', $metadata_prefix . 'global_description' );
  register_setting( 'metadata_seo_settings_group', $metadata_prefix . 'fb_title' );
  register_setting( 'metadata_seo_settings_group', $metadata_prefix . 'fb_description' );
  register_setting( 'metadata_seo_settings_group', $metadata_prefix . 'fb_image' );
  register_setting( 'metadata_seo_settings_group', $metadata_prefix . 'fb_type' );
  register_setting( 'metadata_seo_settings_group', $metadata_prefix . 'fb_admins' );
  register_setting( 'metadata_seo_settings_group', $metadata_prefix . 'fb_appid' );
}

function metadata_seo_plugin_options() 
{
	if ( !current_user_can( 'manage_options' ) )  
	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
?>
<form method="post" action="options.php">
<?php 
	global $metadata_prefix;
	settings_fields( 'metadata_seo_settings_group' ); 
	do_settings_sections( 'metadata_seo_settings_group' );

    wp_enqueue_style('thickbox');
    wp_enqueue_script('thickbox');

?>
    <table class="form-table" style="border:1px solid #000;">
    	<tr>
        <th colspan="2" bgcolor="#999999" style="color:#fff; padding-left:10px;">
			Global Settings
        </th>
        </tr>
        <tr valign="top">
	        <th scope="row" style="padding-left:10px;">Global Keywords:</th>
            <td>
                <?php
                $value = get_option( $metadata_prefix . 'global_keywords', '' );
                echo '<textarea rows="3" name="' . $metadata_prefix . 'global_keywords" style="width:97%">' . $value . '</textarea>';
                ?>
            </td>
        </tr>
        <tr valign="top">
	        <th scope="row" style="padding-left:10px;">Global Description:</th>
            <td>
                <?php
                $value = get_option( $metadata_prefix . 'global_description', '' );
                echo '<textarea rows="3" name="' . $metadata_prefix .  'global_description" style="width:97%">' . $value . '</textarea>';
                ?>
            </td>
        </tr>
    </table>
    
    <table class="form-table" style="border:1px solid #36C;">
    	<tr>
        <th colspan="2" bgcolor="#36C" style="color:#fff; padding-left:10px;">
			facebook (Open Graph) Defaults
        </th>
        </tr>
        <tr valign="top">
	        <th scope="row" style="padding-left:10px;">Title:</th>
            <td>
                <?php
                $value = get_option( $metadata_prefix . 'fb_title', '' );
                echo '<input type="text" name="' . $metadata_prefix . 'fb_title" value="' . $value . '" style="width:70%">';
                ?>
                <br />
                (When empty the default title will be used.)
            </td>
        </tr>
		<tr valign="top">
	        <th scope="row" style="padding-left:10px;">Description:</th>
            <td>
                <?php
                $value = get_option( $metadata_prefix . 'fb_description', '' );
                echo '<textarea rows="3" name="' . $metadata_prefix .  'fb_description" style="width:97%">' . $value . '</textarea>';
                ?>
                <br />
                (When empty the global description will be used.)
            </td>
        </tr>
        <tr valign="top">
			<th scope="row" style="padding-left:10px;">Image:</th>
			<td>
            <?php $value = get_option( $metadata_prefix . 'fb_image', '' );
			?>
            <input type="text" name="<?php echo $metadata_prefix; ?>fb_image" id="<?php echo $metadata_prefix; ?>fb_image" value="<?php echo $value; ?>" style="width:95%" />
            <br />
            Minimum size in pixels is 600x315, Recommended size is 1200x630,<br />
            Aspect ratio should be 1.91:1
					</td>
				</tr>
                <?php
				echo '<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#metadata_seo_fb_image").click(function() 
							{
								tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
								return false;
							})
							window.send_to_editor = function(html) {
									jQuery("#metadata_seo_fb_image").val( jQuery("img",html).attr("src") );
									tb_remove();
								}
						});
					</script>';
				?>
		<tr valign="top">
	        <th scope="row" style="padding-left:10px;">Type:</th>
            <td>
                <?php
                $value = get_option( $metadata_prefix . 'fb_type', '' );
                ?>
                <select name="<?php echo $metadata_prefix; ?>fb_type">
                        <option value="website" <?php echo (get_option($metadata_prefix . 'fb_type')=='website') ? 'selected="selected"' : ''; ?>>Website</option>
                        <option value="article" <?php echo (get_option($metadata_prefix . 'fb_type')=='article') ? 'selected="selected"' : ''; ?>>Article</option>
                        <option value="blog" <?php echo (get_option($metadata_prefix . 'fb_type')=='blog') ? 'selected="selected"' : ''; ?>>Blog</option>
                        <option value="activity" <?php echo (get_option($metadata_prefix . 'fb_type')=='activity') ? 'selected="selected"' : ''; ?>>Activity</option>
                        <option value="sport" <?php echo (get_option($metadata_prefix . 'fb_type')=='sport') ? 'selected="selected"' : ''; ?>>Sport</option>
                        <option value="bar" <?php echo (get_option($metadata_prefix . 'fb_type')=='bar') ? 'selected="selected"' : ''; ?>>Bar</option>
                        <option value="company" <?php echo (get_option($metadata_prefix . 'fb_type')=='company') ? 'selected="selected"' : ''; ?>>Company</option>
                        <option value="cafe" <?php echo (get_option($metadata_prefix . 'fb_type')=='cafe') ? 'selected="selected"' : ''; ?>>Cafe</option>
                        <option value="hotel" <?php echo (get_option($metadata_prefix . 'fb_type')=='hotel') ? 'selected="selected"' : ''; ?>>Hotel</option>
                        <option value="restaurant" <?php echo (get_option($metadata_prefix . 'fb_type')=='restaurant') ? 'selected="selected"' : ''; ?>>Restaurant</option>
                        <option value="government" <?php echo (get_option($metadata_prefix . 'fb_type')=='government') ? 'selected="selected"' : ''; ?>>Government</option>
                        <option value="non_profit" <?php echo (get_option($metadata_prefix . 'fb_type')=='non_profit') ? 'selected="selected"' : ''; ?>>Non_profit</option>
                        <option value="school" <?php echo (get_option($metadata_prefix . 'fb_type')=='school') ? 'selected="selected"' : ''; ?>>school</option>
                        <option value="university" <?php echo (get_option($metadata_prefix . 'fb_type')=='university') ? 'selected="selected"' : ''; ?>>University</option>
                        <option value="actor" <?php echo (get_option($metadata_prefix . 'fb_type')=='actor') ? 'selected="selected"' : ''; ?>>Actor</option>
                        <option value="city" <?php echo (get_option($metadata_prefix . 'fb_type')=='city') ? 'selected="selected"' : ''; ?>>City</option>
                        <option value="country" <?php echo (get_option($metadata_prefix . 'fb_type')=='country') ? 'selected="selected"' : ''; ?>>Country</option>
                        <option value="landmark" <?php echo (get_option($metadata_prefix . 'fb_type')=='landmark') ? 'selected="selected"' : ''; ?>>Landmark</option>
                        <option value="book" <?php echo (get_option($metadata_prefix . 'fb_type')=='book') ? 'selected="selected"' : ''; ?>>Book</option>
                        <option value="product" <?php echo (get_option($metadata_prefix . 'fb_type')=='product') ? 'selected="selected"' : ''; ?>>Product</option>
                 </select>
            </td>
        </tr>        
		<tr valign="top">
	        <th scope="row" style="padding-left:10px;">Facebook App ID <font color="#FF0000">&#9830;</font> :</th>
            <td>
                <?php
                $value = get_option( $metadata_prefix . 'fb_appid', '' );
                echo '<input type="text" name="' . $metadata_prefix . 'fb_appid" value="' . $value . '" style="width:50%">';
                ?>
                <br />
                Facebook scraper associate the meta data with your app (fb:app_id)
            </td>
        </tr>
<tr valign="top">
	        <th scope="row" style="padding-left:10px;">Facebook Admins ID <font color="#FF0000">&#9830;</font> :</th>
            <td>
                <?php
                $value = get_option( $metadata_prefix . 'fb_admins', '' );
                echo '<input type="text" name="' . $metadata_prefix . 'fb_admins" value="' . $value . '" style="width:80%">';
                ?>
                <br />
                Facebook associate admins for the website (fb:admins).<br />
                multiple ID's seperated by (comma)
            </td>
        </tr>
        <tr valign="top">
        	<td colspan="2">
            	<font color="#FF0000">&#9830;</font> open http://graph.facebook.com/PROFILENAME for getting IDs
        	</td>
        </tr>
	</table>    
    
    <?php submit_button(); ?>

</form>
<?php
}
?>