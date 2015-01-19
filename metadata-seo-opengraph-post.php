<?php

	global $metadata_prefix;
	$seo_meta_og_boxes = array(
		'id' => $metadata_prefix . 'og_id',
		'title' => 'Metadata SEO Open Graph for facebook',
		'pages' => array('page','post'), // post type
		'context' => 'normal',
		'priority' => 'low',
		'fields' => array(
			array(
				'name' => 'Title:',
				'desc' => '',
				'id' => $metadata_prefix . 'og_title',
				'class'         => 'title',
				'type'          => 'text',
			),
			
			array(
				'name' => 'Description:',
				'desc' => '',
				'id' => $metadata_prefix . 'og_description',
				'class'         => 'description',
				'type'          => 'textarea',
				'rows'          => 5
			),
			array(
				'name'    => 'Type',
				'desc'    => '',
				'id'      => $metadata_prefix . 'og_type',
				'class'   => 'og_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Website', 'value' => 'website', ),
					array( 'name' => 'Article', 'value' => 'article', ),
					array( 'name' => 'Blog', 'value' => 'blog', ),
					array( 'name' => 'Activity', 'value' => 'activity', ),
					array( 'name' => 'Sport', 'value' => 'sport', ),
					array( 'name' => 'Bar', 'value' => 'bar', ),
					array( 'name' => 'Company', 'value' => 'company', ),
					array( 'name' => 'Cafe', 'value' => 'cafe', ),
					array( 'name' => 'Hotel', 'value' => 'hotel', ),
					array( 'name' => 'Restaurant', 'value' => 'restaurant', ),
					array( 'name' => 'Government', 'value' => 'government', ),
					array( 'name' => 'Non_profit', 'value' => 'non_profit', ),
					array( 'name' => 'School', 'value' => 'school', ),
					array( 'name' => 'University', 'value' => 'university', ),
					array( 'name' => 'Actor', 'value' => 'actor', ),
					array( 'name' => 'City', 'value' => 'city', ),
					array( 'name' => 'Country', 'value' => 'country', ),
					array( 'name' => 'Landmark', 'value' => 'landmark', ),
					array( 'name' => 'Book', 'value' => 'book', ),
					array( 'name' => 'Product', 'value' => 'product', ),
				),
			),
			array(
				'name' => 'Image:',
				'desc' => '',
				'id' => $metadata_prefix . 'og_image',
				'class'         => 'image',
				'type'          => 'image',
			),			
		)
	);

    add_action('admin_menu', 'metadata_seo_og_meta_box');
    function metadata_seo_og_meta_box() 
	{
        global $seo_meta_og_boxes;
		$post_types = get_post_types();
        foreach($post_types as $page)
		{
			add_meta_box($seo_meta_og_boxes['id'], $seo_meta_og_boxes['title'], 'metadata_seo_og_show_box', $page, $seo_meta_og_boxes['context'], $seo_meta_og_boxes['priority']); //, $seo_meta_og_boxes);
        }
    }

// function to show meta boxes
    function metadata_seo_og_show_box()  {

		wp_enqueue_style('thickbox');
		wp_enqueue_script('thickbox');
		
        global $post;
        global $seo_meta_og_boxes;

        // Use nonce for verification
        echo '<input type="hidden" name="seo_og_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
         
        echo '<table class="form-table">';
     
        foreach ($seo_meta_og_boxes['fields'] as $field) {
            // get current post meta data
     
            $meta = get_post_meta($post->ID, $field['id'], true);
            echo '<tr>',
                    '<th style="width:20%"><label for="', $field['id'], '">', stripslashes($field['name']), '</label></th>',
                    '<td class="seo_field_type_' . str_replace(' ', '_', $field['type']) . '">';
            switch ($field['type']) {

                case 'text':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" maxlength="' . $field['max'] . '" /><br/>', '', stripslashes($field['desc']);
                    break;

                case 'chk':
                    echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '" value="true"' , $meta ? 'checked' : '' , ' "/><br/>', '', stripslashes($field['desc']);
                    break;

                case 'textarea':
					echo '<textarea name="', $field['id'] ,'" id="', $field['id'],'" rows="', $field['rows'] , '"  style="width:97%" >';
					echo $meta ? $meta : $field['std'];
					echo '</textarea>';

                    break;
					
                case 'wysiwyg':
					wp_editor($meta ? $meta : $field['std'], $field['id'], array(
						'wpautop'       =>      true,
						'media_buttons' =>      false,
						'textarea_name' =>      $field['id'],
						'textarea_rows' =>      $field['rows'],
						'teeny'         =>      false,
						'tinymce'       =>      true
						));
                    break;
					
				case 'select':
					if( empty( $meta ) && !empty( $field['std'] ) ) $meta = $field['std'];
					echo '<select name="', $field['id'], '" id="', $field['id'], '">';
					foreach ($field['options'] as $option) {
						echo '<option value="', $option['value'], '"', $meta == $option['value'] ? ' selected="selected"' : '', '>', $option['name'], '</option>';
					}
					echo '</select>';

					break;

				case 'image':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:95%" /><br/>', '', stripslashes($field['desc']);
					
					
					echo '<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery("#metadata_seo_og_image").click(function() 
								{
									tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
									return false;
								})
								window.send_to_editor = function(html) {
										jQuery("#metadata_seo_og_image").val( jQuery("img",html).attr("src") );
										tb_remove();
									}
							});
						</script>';
					
                    break;

            }
			echo '<p class="metabox_description">', $field['desc'], '</p>';
            echo    '<td>',
                '</tr>';
        }
         
        echo '</table>';
    }   

    // Save data from meta box
    function metadata_seo_og_save($post_id) {
        global $post;
        global $seo_meta_og_boxes;
         
        // verify nonce
        if (!wp_verify_nonce($_POST['seo_og_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
     
        // check permissions
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
         
        foreach ($seo_meta_og_boxes['fields'] as $field) {
         
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];
             
            if ($new && $new != $old) {
				switch ($field['type']) {
					 case 'text':
						 update_post_meta($post_id, $field['id'], $new);
						 break;
						 
					 case 'chk':
						$my_chk = $_POST[$field['id']] ? true : false;
						update_post_meta($post_id, $field['id'], $my_chk);
						break;

					 case 'textarea':
						 update_post_meta($post_id, $field['id'], $new);
						 break;

                     case 'wysiwyg':
						 update_post_meta($post_id, $field['id'], $new);
						 break;

					 case 'select':
					     update_post_meta($post_id, $field['id'], $new);
					 	 break;

					 case 'image':
					     update_post_meta($post_id, $field['id'], $new);
					 	 break;

				}
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    }
    add_action('save_post', 'metadata_seo_og_save');
?>