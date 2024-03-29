<?php
/**
*	AJAX action for preview export row
*/
function pmxe_wp_ajax_export_preview(){

	if ( ! check_ajax_referer( 'wp_all_export_secure', 'security', false )){
		exit( json_encode(array('html' => __('Security check', 'wp_all_export_plugin'))) );
	}

	if ( ! current_user_can('manage_options') ){
		exit( json_encode(array('html' => __('Security check', 'wp_all_export_plugin'))) );
	}
	
	ob_start();

	$values = array();
	
	parse_str($_POST['data'], $values);	

	$exportOptions = $values + (PMXE_Plugin::$session->has_session() ? PMXE_Plugin::$session->get_clear_session_data() : array()) + PMXE_Plugin::get_default_import_options();	

	XmlExportEngine::$exportOptions  = $exportOptions;
	XmlExportEngine::$is_user_export = $exportOptions['is_user_export'];
	XmlExportEngine::$is_comment_export = $exportOptions['is_comment_export'];

	if ( 'advanced' == $exportOptions['export_type'] ) 
	{		
		if ( XmlExportEngine::$is_user_export )
		{
			$exportQuery = eval('return new WP_User_Query(array(' . $exportOptions['wp_query'] . ', \'offset\' => 0, \'number\' => 10));');
		}
		elseif ( XmlExportEngine::$is_comment_export )
		{
			$exportQuery = eval('return new WP_Comment_Query(array(' . $exportOptions['wp_query'] . ', \'offset\' => 0, \'number\' => 10));');
		}
		else
		{
			$exportQuery = eval('return new WP_Query(array(' . $exportOptions['wp_query'] . ', \'offset\' => 0, \'posts_per_page\' => 10));');
		}		
	}
	else
	{
		XmlExportEngine::$post_types = $exportOptions['cpt'];

		if ( in_array('users', $exportOptions['cpt']))
		{			
			add_action('pre_user_query', 'wp_all_export_pre_user_query', 10, 1);
			$exportQuery = new WP_User_Query( array( 'orderby' => 'ID', 'order' => 'ASC', 'number' => 10 ));
			remove_action('pre_user_query', 'wp_all_export_pre_user_query');
		}
		elseif( in_array('comments', $exportOptions['cpt']))
		{
			add_action('comments_clauses', 'wp_all_export_comments_clauses', 10, 1);
			$exportQuery = new WP_Comment_Query( array( 'orderby' => 'comment_ID', 'order' => 'ASC', 'number' => 10 ));
			remove_action('comments_clauses', 'wp_all_export_comments_clauses');
		}
		else
		{
			add_filter('posts_join', 'wp_all_export_posts_join', 10, 1);
			add_filter('posts_where', 'wp_all_export_posts_where', 10, 1);
			$exportQuery = new WP_Query( array( 'post_type' => $exportOptions['cpt'], 'post_status' => 'any', 'orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => 10 ));			
			remove_filter('posts_where', 'wp_all_export_posts_where');
			remove_filter('posts_join', 'wp_all_export_posts_join');					
		}
	}	

	XmlExportEngine::$exportQuery = $exportQuery;	

	?>

	<div id="post-preview" class="wpallexport-preview">
		
		<div class="wpallexport-preview-content">
			
		<?php
		$wp_uploads = wp_upload_dir();	
		
		$functions = $wp_uploads['basedir'] . DIRECTORY_SEPARATOR . WP_ALL_EXPORT_UPLOADS_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'functions.php';
		if ( @file_exists($functions) )
			require_once $functions;

		switch ($exportOptions['export_to']) {

			case 'xml':				

				$dom = new DOMDocument('1.0', $exportOptions['encoding']);
				$old = libxml_use_internal_errors(true);
				
				if (XmlExportEngine::$is_user_export)
				{
					$xml = pmxe_export_users_xml($exportQuery, $exportOptions, true);	
				}
				elseif(XmlExportEngine::$is_comment_export)
				{
					$xml = pmxe_export_comments_xml($exportQuery, $exportOptions, true);	
				}
				else
				{
					$xml = pmxe_export_xml($exportQuery, $exportOptions, true);
				}
				
				$dom->loadXML($xml);
				libxml_use_internal_errors($old);
				$xpath = new DOMXPath($dom);
				if (($elements = @$xpath->query('/' . $exportOptions['main_xml_tag'])) and $elements->length){
					pmxe_render_xml_element($elements->item( 0 ), true);
				}			
													
				break;

			case 'csv':
				?>			
				<small>
				<?php
					if (XmlExportEngine::$is_user_export)
					{
						$csv = pmxe_export_users_csv($exportQuery, $exportOptions, true);
					}
					elseif(XmlExportEngine::$is_comment_export)
					{
						$csv = pmxe_export_comments_csv($exportQuery, $exportOptions, true);
					}
					else
					{
						$csv = pmxe_export_csv($exportQuery, $exportOptions, true);
					}					
					if (!empty($csv)){
						$csv_rows = array_filter(explode("\n", $csv));
						if ($csv_rows){
							?>
							<table class="pmxe_preview" cellpadding="0" cellspacing="0">
							<?php
							foreach ($csv_rows as $rkey => $row) {							
								$cells = str_getcsv($row, $exportOptions['delimiter']);															
								if ($cells){
									?>
									<tr>
										<?php
										foreach ($cells as $key => $value) {
											?>
											<td>
												<?php if (!$rkey):?><strong><?php endif;?>
												<?php echo $value; ?>
												<?php if (!$rkey):?></strong><?php endif;?>
											</td>
											<?php
										}
										?>
									</tr>
									<?php
								}							
							}
							?>
							</table>
							<?php
						}						
					}
					else{
						_e('Data not found.', 'wp_all_export_plugin');
					}
				?>
				</small>			
				<?php
				break;

			default:

				_e('This format is not supported.', 'wp_all_export_plugin');

				break;
		}
		wp_reset_postdata();
		?>

		</div>

	</div>

	<?php

	exit(json_encode(array('html' => ob_get_clean()))); die;
}
