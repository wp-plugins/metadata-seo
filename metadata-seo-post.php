<?php

	global $prefix;
	$seo_meta_boxes = array(
		'id' => $prefix . 'id',
		'title' => 'Custom SEO',
		'pages' => array('page','post'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => 'Meta Keywords:',
				'desc' => 'List your Meta Keywords separated by commas (e.g. keyword one, keyword two, keyword three,...)',
				'id' => $prefix . 'keywords',
				'class'         => 'keywords',
				'type'          => 'textarea',
				'rows'          => 2
			),
			
			array(
				'name' => 'Meta Description:',
				'desc' => 'Enter your Meta Description here and keep it less than 150 characters.',
				'id' => $prefix . 'description',
				'class'         => 'description',
				'type'          => 'textarea',
				'rows'          => 5
			),
			array(
				'name'    => 'Meta Robot Request',
				'desc'    => 'Do NOT change this unless you know what you are doing',
				'id'      => $prefix . 'follow_nofollow_select',
				'class'   => 'follow_nofollow',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Follow and Index', 'value' => 'follow, index', ),
					array( 'name' => 'Follow but do not Index', 'value' => 'follow, noindex', ),
					array( 'name' => 'Index but do not follow', 'value' => 'nofollow, index', ),
					array( 'name' => 'Do not Index or Follow', 'value' => 'nofollow, noindex', ),
				),
			),
		)
	);

    add_action('admin_menu', 'metadata_seo_meta_box');
    function metadata_seo_meta_box() 
	{
        global $seo_meta_boxes;
        foreach($seo_meta_boxes['pages'] as $page)
		{
			add_meta_box($seo_meta_boxes['id'], $seo_meta_boxes['title'], 'metadata_seo_show_box', $page, $seo_meta_boxes['context'], $seo_meta_boxes['priority'], $seo_meta_boxes);
        }
    }

// function to show meta boxes
    function metadata_seo_show_box()  {
		
        global $post;
        global $seo_meta_boxes;

        // Use nonce for verification
        echo '<input type="hidden" name="seo_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
         
        echo '<table class="form-table">';
     
        foreach ($seo_meta_boxes['fields'] as $field) {
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
            }
			echo '<p class="metabox_description">', $field['desc'], '</p>';
            echo    '<td>',
                '</tr>';
        }
         
        echo '</table>';
    }   
     
    // Save data from meta box
    function metadata_seo_save($post_id) {
        global $post;
        global $seo_meta_boxes;
         
        // verify nonce
        if (!wp_verify_nonce($_POST['seo_meta_box_nonce'], basename(__FILE__))) {
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
         
        foreach ($seo_meta_boxes['fields'] as $field) {
         
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
				}
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    }
    add_action('save_post', 'metadata_seo_save');
?>