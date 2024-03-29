<?php
/**
*	AJAX action export processing
*/
function pmxe_wp_ajax_wpallexport(){

	if ( ! check_ajax_referer( 'wp_all_export_secure', 'security', false )){
		exit( __('Security check', 'wp_all_export_plugin') );
	}

	if ( ! current_user_can('manage_options') ){
		exit( __('Security check', 'wp_all_export_plugin') );
	}
	
	$input  = new PMXE_Input();	
	$export_id = $input->get('id', 0);
	if (empty($export_id))
	{
		$export_id = ( ! empty(PMXE_Plugin::$session->update_previous)) ? PMXE_Plugin::$session->update_previous : 0;		
	} 

	$wp_uploads = wp_upload_dir();	

	$export = new PMXE_Export_Record();

	$export->getById($export_id);	
	
	if ( $export->isEmpty() ){
		exit( __('Export is not defined.', 'wp_all_export_plugin') );
	}

	$exportOptions = $export->options + PMXE_Plugin::get_default_import_options();		

	wp_reset_postdata();	

	XmlExportEngine::$exportOptions     = $exportOptions;	
	XmlExportEngine::$is_user_export    = $exportOptions['is_user_export'];
	XmlExportEngine::$is_comment_export = $exportOptions['is_comment_export'];
	XmlExportEngine::$exportID = $export_id;

	$posts_per_page = $exportOptions['records_per_iteration'];	

	if ('advanced' == $exportOptions['export_type']) 
	{ 
		if (XmlExportEngine::$is_user_export)
		{
			$exportQuery = eval('return new WP_User_Query(array(' . $exportOptions['wp_query'] . ', \'offset\' => ' . $export->exported . ', \'number\' => ' . $posts_per_page . ' ));');
		}
		elseif(XmlExportEngine::$is_comment_export)
		{
			$exportQuery = eval('return new WP_Comment_Query(array(' . $exportOptions['wp_query'] . ', \'offset\' => ' . $export->exported . ', \'number\' => ' . $posts_per_page . ' ));');
		}
		else
		{
			$exportQuery = eval('return new WP_Query(array(' . $exportOptions['wp_query'] . ', \'offset\' => ' . $export->exported . ', \'posts_per_page\' => ' . $posts_per_page . ' ));');
		}		
	}
	else
	{
		XmlExportEngine::$post_types = $exportOptions['cpt'];

		if (in_array('users', $exportOptions['cpt']))
		{	
			add_action('pre_user_query', 'wp_all_export_pre_user_query', 10, 1);
			$exportQuery = new WP_User_Query( array( 'orderby' => 'ID', 'order' => 'ASC', 'number' => $posts_per_page, 'offset' => $export->exported));
			remove_action('pre_user_query', 'wp_all_export_pre_user_query');							
		}
		elseif(in_array('comments', $exportOptions['cpt']))
		{
			add_action('comments_clauses', 'wp_all_export_comments_clauses', 10, 1);
			$exportQuery = new WP_Comment_Query( array( 'orderby' => 'comment_ID', 'order' => 'ASC', 'number' => $posts_per_page, 'offset' => $export->exported));
			remove_action('comments_clauses', 'wp_all_export_comments_clauses');							
		}
		else
		{
			add_filter('posts_join', 'wp_all_export_posts_join', 10, 1);
			add_filter('posts_where', 'wp_all_export_posts_where', 10, 1);
			$exportQuery = new WP_Query( array( 'post_type' => $exportOptions['cpt'], 'post_status' => 'any', 'orderby' => 'ID', 'order' => 'ASC', 'offset' => $export->exported, 'posts_per_page' => $posts_per_page ));			
			remove_filter('posts_where', 'wp_all_export_posts_where');
			remove_filter('posts_join', 'wp_all_export_posts_join');
		}	
	}		

	XmlExportEngine::$exportQuery = $exportQuery;	

	if (XmlExportEngine::$is_comment_export)
	{		
		add_action('comments_clauses', 'wp_all_export_comments_clauses', 10, 1);
		$postCount  = count($exportQuery->get_comments());
		$result = new WP_Comment_Query( array( 'orderby' => 'comment_ID', 'order' => 'ASC', 'number' => 10, 'count' => true));
		$foundPosts = $result->get_comments();
		remove_action('comments_clauses', 'wp_all_export_comments_clauses');	
	}
	else
	{
		$foundPosts = ( ! XmlExportEngine::$is_user_export ) ? $exportQuery->found_posts : $exportQuery->get_total();
		$postCount  = ( ! XmlExportEngine::$is_user_export ) ? $exportQuery->post_count : count($exportQuery->get_results());
	}	

	if ( ! $export->exported )
	{
		$attachment_list = $export->options['attachment_list'];
		if ( ! empty($attachment_list))
		{
			foreach ($attachment_list as $attachment) {
				if ( ! is_numeric($attachment))
				{					
					@unlink($attachment);
				}
			}
		}
		$exportOptions['attachment_list'] = array();
		$export->set(array(			
			'options' => $exportOptions
		))->save();

		$is_secure_import = PMXE_Plugin::getInstance()->getOption('secure');

		if ( $is_secure_import and ! empty($exportOptions['filepath'])){

			// if 'Create a new file each time export is run' disabled remove all previously generated source files
			// if ( ! $exportOptions['creata_a_new_export_file'] or ! $export->iteration ){
			// 	wp_all_export_remove_source(wp_all_export_get_absolute_path($exportOptions['filepath']));
			// }

			$exportOptions['filepath'] = '';

		}
		
		PMXE_Plugin::$session->set('count', $foundPosts);		
		PMXE_Plugin::$session->save_data();
	}

	// if posts still exists then export them
	if ( $postCount )
	{
		
		$functions = $wp_uploads['basedir'] . DIRECTORY_SEPARATOR . WP_ALL_EXPORT_UPLOADS_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'functions.php';
		if ( @file_exists($functions) )
			require_once $functions;		

		switch ( $exportOptions['export_to'] ) {

			case 'xml':		
				
				if ( XmlExportEngine::$is_user_export )
				{
					pmxe_export_users_xml($exportQuery, $exportOptions);
				}
				elseif ( XmlExportEngine::$is_comment_export )
				{
					pmxe_export_comments_xml($exportQuery, $exportOptions);
				}				
				else
				{
					pmxe_export_xml($exportQuery, $exportOptions);					
				}

				break;

			case 'csv':
				
				if ( XmlExportEngine::$is_user_export )
				{
					pmxe_export_users_csv($exportQuery, $exportOptions);
				}
				elseif ( XmlExportEngine::$is_comment_export )
				{
					pmxe_export_comments_csv($exportQuery, $exportOptions);
				}
				else
				{
					pmxe_export_csv($exportQuery, $exportOptions);					
				}


				break;								

			default:
				# code...
				break;
		}		

		wp_reset_postdata();	

	}

	if ($postCount){

		$export->set(array(
			'exported' => $export->exported + $postCount
		))->save();		
		
	}

	if ($posts_per_page != -1 and $postCount){		

		wp_send_json(array(
			'exported' => $export->exported,										
			'percentage' => ceil(($export->exported/$foundPosts) * 100),			
			'done' => false,
			'records_per_request' => $exportOptions['records_per_iteration']
		));	
	
	}
	else
	{

		wp_reset_postdata();		

		if ( file_exists(PMXE_Plugin::$session->file)){

			if ($exportOptions['export_to'] == 'xml') file_put_contents(PMXE_Plugin::$session->file, '</'.$exportOptions['main_xml_tag'].'>', FILE_APPEND);					

			$is_secure_import = PMXE_Plugin::getInstance()->getOption('secure');

			if ( ! $is_secure_import ){
				
				if ( ! $export->isEmpty() ){

					$wp_filetype = wp_check_filetype(basename(PMXE_Plugin::$session->file), null );
					$attachment_data = array(
					    'guid' => $wp_uploads['baseurl'] . '/' . _wp_relative_upload_path( PMXE_Plugin::$session->file ), 
					    'post_mime_type' => $wp_filetype['type'],
					    'post_title' => preg_replace('/\.[^.]+$/', '', basename(PMXE_Plugin::$session->file)),
					    'post_content' => '',
					    'post_status' => 'inherit'
					);		

					if ( empty($export->attch_id) )
					{
						$attach_id = wp_insert_attachment( $attachment_data, PMXE_Plugin::$session->file );			
					}					
					elseif($export->options['creata_a_new_export_file'])
					{
						$attach_id = wp_insert_attachment( $attachment_data, PMXE_Plugin::$session->file );			
					}
					else
					{
						$attach_id = $export->attch_id;						
						$attachment = get_post($attach_id);
						if ($attachment)
						{
							update_attached_file( $attach_id, PMXE_Plugin::$session->file );
							wp_update_attachment_metadata( $attach_id, $attachment_data );	
						}
						else
						{
							$attach_id = wp_insert_attachment( $attachment_data, PMXE_Plugin::$session->file );				
						}						
					}

					if ( ! in_array($attach_id, $exportOptions['attachment_list'])) $exportOptions['attachment_list'][] = $attach_id;

					$export->set(array(
						'attch_id' => $attach_id,
						'options' => $exportOptions
					))->save();
				}

			}
			else{

				$exportOptions['filepath'] = wp_all_export_get_relative_path(PMXE_Plugin::$session->file);
				
				if ( ! $export->isEmpty() ){
					$export->set(array(
						'options' => $exportOptions
					))->save();	
				}

			}

			// Generate templa for WP All Import
			if ($exportOptions['is_generate_templates']){

				$custom_type = (empty($exportOptions['cpt'])) ? 'post' : $exportOptions['cpt'][0];

				$templateOptions = array(
					'type' => ( ! empty($exportOptions['cpt']) and $exportOptions['cpt'][0] == 'page') ? 'page' : 'post',
					'wizard_type' => 'new',
					'deligate' => 'wpallexport',
					'custom_type' => (XmlExportEngine::$is_user_export) ? 'import_users' : $custom_type,
					'status' => 'xpath',
					'is_multiple_page_parent' => 'no',
					'unique_key' => '',
					'acf' => array(),
					'fields' => array(),
					'is_multiple_field_value' => array(),				
					'multiple_value' => array(),
					'fields_delimiter' => array(),				
					
					'update_all_data' => 'no',
					'is_update_status' => 0,
					'is_update_title'  => 0,
					'is_update_author' => 0,
					'is_update_slug' => 0,
					'is_update_content' => 0,
					'is_update_excerpt' => 0,
					'is_update_dates' => 0,
					'is_update_menu_order' => 0,
					'is_update_parent' => 0,
					'is_update_attachments' => 0,
					'is_update_acf' => 0,
					'update_acf_logic' => 'only',
					'acf_list' => '',					
					'is_update_product_type' => 1,
					'is_update_attributes' => 0,
					'update_attributes_logic' => 'only',
					'attributes_list' => '',
					'is_update_images' => 0,
					'is_update_custom_fields' => 0,
					'update_custom_fields_logic' => 'only',
					'custom_fields_list' => '',												
					'is_update_categories' => 0,
					'update_categories_logic' => 'only',
					'taxonomies_list' => '',
					'export_id' => $export->id
				);		

				if ( in_array('product', $exportOptions['cpt']) )
				{
					$templateOptions['_virtual'] = 1;
					$templateOptions['_downloadable'] = 1;
					$templateOptions['put_variation_image_to_gallery'] = 1;
					$templateOptions['disable_auto_sku_generation'] = 1;
				}			

				if ( XmlExportEngine::$is_user_export )
				{					
					$templateOptions['is_update_first_name'] = 0;
					$templateOptions['is_update_last_name'] = 0;
					$templateOptions['is_update_role'] = 0;
					$templateOptions['is_update_nickname'] = 0;
					$templateOptions['is_update_description'] = 0;
					$templateOptions['is_update_login'] = 0;
					$templateOptions['is_update_password'] = 0;
					$templateOptions['is_update_nicename'] = 0;
					$templateOptions['is_update_email'] = 0;
					$templateOptions['is_update_registered'] = 0;
					$templateOptions['is_update_display_name'] = 0;
					$templateOptions['is_update_url'] = 0;
				}

				if ( 'xml' == $exportOptions['export_to'] ) 
				{						
					wp_all_export_prepare_template_xml($exportOptions, $templateOptions);															
				}
				else
				{						
					wp_all_export_prepare_template_csv($exportOptions, $templateOptions);																		
				}					

				//$template = new PMXI_Template_Record();

				$tpl_options = $templateOptions;

				if ( 'csv' == $exportOptions['export_to'] ) 
				{						
					$tpl_options['delimiter'] = $exportOptions['delimiter'];
				}
				
				$tpl_options['update_all_data'] = 'yes';
				$tpl_options['is_update_status'] = 1;
				$tpl_options['is_update_title']  = 1;
				$tpl_options['is_update_author'] = 1;
				$tpl_options['is_update_slug'] = 1;
				$tpl_options['is_update_content'] = 1;
				$tpl_options['is_update_excerpt'] = 1;
				$tpl_options['is_update_dates'] = 1;
				$tpl_options['is_update_menu_order'] = 1;
				$tpl_options['is_update_parent'] = 1;
				$tpl_options['is_update_attachments'] = 1;
				$tpl_options['is_update_acf'] = 1;
				$tpl_options['update_acf_logic'] = 'full_update';
				$tpl_options['acf_list'] = '';
				$tpl_options['is_update_product_type'] = 1;
				$tpl_options['is_update_attributes'] = 1;
				$tpl_options['update_attributes_logic'] = 'full_update';
				$tpl_options['attributes_list'] = '';
				$tpl_options['is_update_images'] = 1;
				$tpl_options['is_update_custom_fields'] = 1;
				$tpl_options['update_custom_fields_logic'] = 'full_update';
				$tpl_options['custom_fields_list'] = '';
				$tpl_options['is_update_categories'] = 1;
				$tpl_options['update_categories_logic'] = 'full_update';
				$tpl_options['taxonomies_list'] = '';					

				$tpl_data = array(						
					'name' => $exportOptions['template_name'],
					'is_keep_linebreaks' => 0,
					'is_leave_html' => 0,
					'fix_characters' => 0,
					'options' => $tpl_options,							
				);

				$exportOptions['tpl_data'] = $tpl_data;

				$export->set(array(
					'options' => $exportOptions
				))->save();		

				// if ( ! empty($exportOptions['template_name'])) { // save template in database
				// 	$template->getByName($exportOptions['template_name'])->set($tpl_data)->save();						
				// }

			}

			// associate exported posts with new import
			if ( wp_all_export_is_compatible() and $exportOptions['is_generate_import']){

				$options = $templateOptions + PMXI_Plugin::get_default_import_options();											
										
				$import = new PMXI_Import_Record();

				$import->getById($exportOptions['import_id']);	

				if ( ! $import->isEmpty() and $import->parent_import_id == 99999 ){

					$xmlPath = PMXE_Plugin::$session->file;

					$root_element = '';

					$historyPath = PMXE_Plugin::$session->file;

					if ( 'csv' == $exportOptions['export_to'] ) 
					{
						$options['delimiter'] = $exportOptions['delimiter'];

						include_once( PMXI_Plugin::ROOT_DIR . '/libraries/XmlImportCsvParse.php' );	

						$path_info = pathinfo($xmlPath);

						$path_parts = explode(DIRECTORY_SEPARATOR, $path_info['dirname']);

						$security_folder = array_pop($path_parts);

						$target = $is_secure_import ? $wp_uploads['basedir'] . DIRECTORY_SEPARATOR . PMXE_Plugin::UPLOADS_DIRECTORY . DIRECTORY_SEPARATOR . $security_folder : $wp_uploads['path'];						

						$csv = new PMXI_CsvParser( array( 'filename' => $xmlPath, 'targetDir' => $target ) );		

						if ( ! in_array($xmlPath, $exportOptions['attachment_list']) )
						{
							$exportOptions['attachment_list'][] = $csv->xml_path;							
						}
						
						$historyPath = $csv->xml_path;

						$root_element = 'node';

					}
					else
					{
						$root_element = 'post';
					}

					$import->set(array(						
						'xpath' => '/' . $root_element,
						'type' => 'upload',											
						'options' => $options,
						'root_element' => $root_element,
						'path' => $xmlPath,
						'name' => basename($xmlPath),
						'imported' => 0,
						'created' => 0,
						'updated' => 0,
						'skipped' => 0,
						'deleted' => 0,
						'iteration' => 1,		
						'count' => PMXE_Plugin::$session->count						
					))->save();				

					$history_file = new PMXI_File_Record();
					$history_file->set(array(
						'name' => $import->name,
						'import_id' => $import->id,
						'path' => $historyPath,
						'registered_on' => date('Y-m-d H:i:s')
					))->save();		

					$exportOptions['import_id']	= $import->id;					
					
					$export->set(array(
						'options' => $exportOptions
					))->save();		
				}													
			}
		}

		$export->set(array(
			'executing' => 0,
			'canceled'  => 0
		))->save();

		do_action('pmxe_after_export', $export->id);

		wp_send_json(array(
			'exported' => $export->exported,										
			'percentage' => 100,			
			'done' => true,
			'records_per_request' => $exportOptions['records_per_iteration'],
			'file' => PMXE_Plugin::$session->file
		));	

	}

}