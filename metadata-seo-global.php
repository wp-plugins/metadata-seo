<?php
//Add Global keyword field to setting
$new_general_setting = new metadata_seo_new_general_setting();
 
class metadata_seo_new_general_setting {
    function metadata_seo_new_general_setting() {
        add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
    }
    function register_fields() {
        global $prefix; 
        register_setting( 'general', $prefix . 'global_keywords', 'esc_attr' );
        add_settings_field('SEO_global_keywords', '<label for="' . $prefix . 'global_keywords">'.__('Global SEO Keywords:' , $prefix . 'global_keywords' ).'</label>' , array(&$this, 'fields_keywords_html') , 'general' );

        register_setting( 'general', $prefix . 'global_description', 'esc_attr' );
        add_settings_field('SEO_global_description', '<label for="' . $prefix . 'global_description">'.__('Global SEO Description:' , $prefix . 'global_description' ).'</label>' , array(&$this, 'fields_description_html') , 'general' );

    }

    function fields_keywords_html() {
	global $prefix; 
        $value = get_option( $prefix . 'global_keywords', '' );
        echo '<div class="seo_keywords"><textarea rows="3" name="' . $prefix . 'global_keywords" style="width:97%">' . $value . '</textarea></div>';
    }

    function fields_description_html() {
	global $prefix;
        $value = get_option( $prefix . 'global_description', '' );
        echo '<div class="seo_description"><textarea rows="3" name="' . $prefix .  'global_description" style="width:97%">' . $value . '</textarea></div>';
    }
}

?>