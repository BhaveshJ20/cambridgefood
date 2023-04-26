<?php

function pmxe_wp_loaded() {				
	
	@ini_set("max_input_time", PMXE_Plugin::getInstance()->getOption('max_input_time'));
	@ini_set("max_execution_time", PMXE_Plugin::getInstance()->getOption('max_execution_time'));

	if ( ! empty($_GET['zapier_subscribe']) and ! empty($_GET['api_key']) )
	{				
		$zapier_api_key = PMXE_Plugin::getInstance()->getOption('zapier_api_key');

		if ( ! empty($zapier_api_key) and $zapier_api_key == $_GET['api_key'] )
		{
			$subscriptions = get_option('zapier_subscribe', array());

			$body = json_decode(file_get_contents("php://input"), true);

			if ( ! empty($body))
			{
				$subscriptions[basename($body['target_url'])] = $body;
			}

			update_option('zapier_subscribe', $subscriptions);			

			exit(json_encode(array('status' => 200)));
		}		
		else
		{
			http_response_code(401);
			exit(json_encode(array('status' => 'error')));
		}
	}

	if ( ! empty($_GET['zapier_unsubscribe']) and ! empty($_GET['api_key']) )
	{
		$zapier_api_key = PMXE_Plugin::getInstance()->getOption('zapier_api_key');

		if ( ! empty($zapier_api_key) and $zapier_api_key == $_GET['api_key'] )
		{
			$subscriptions = get_option('zapier_subscribe', array());

			$body = json_decode(file_get_contents("php://input"), true);

			if ( ! empty($subscriptions[basename($body['target_url'])]) ) unset($subscriptions[basename($body['target_url'])]);

			update_option('zapier_subscribe', $subscriptions);

			exit(json_encode(array('status' => 200)));
		}
		else
		{
			http_response_code(401);
			exit(json_encode(array('status' => 'error')));
		}
	}

	/* Check if cron is manualy, then execute export */
	$cron_job_key = PMXE_Plugin::getInstance()->getOption('cron_job_key');
	
	if ( ! empty($cron_job_key) and ! empty($_GET['export_id']) and ! empty($_GET['export_key']) and $_GET['export_key'] == $cron_job_key and !empty($_GET['action']) and in_array($_GET['action'], array('processing', 'trigger'))) {		
		
		$logger = create_function('$m', 'echo "<p>$m</p>\\n";');								

		$export = new PMXE_Export_Record();
		
		$ids = explode(',', $_GET['export_id']);

		if (!empty($ids) and is_array($ids)){			

			foreach ($ids as $id) { if (empty($id)) continue;

				$export->getById($id);	

				if ( ! $export->isEmpty() ){					

					switch ($_GET['action']) {

						case 'trigger':							

							if ( (int) $export->executing )
							{
								wp_send_json(array(
									'status'     => 403,
									'message'    => sprintf(__('Export #%s is currently in manually process. Request skipped.', 'wp_all_export_plugin'), $id)
								));								
							}
							elseif ( ! $export->processing and ! $export->triggered )
							{								
								$export->set(array(
									'triggered' => 1,						
									'exported' => 0,									
									'last_activity' => date('Y-m-d H:i:s')									
								))->update();	

								wp_send_json(array(
									'status'     => 200,
									'message'    => sprintf(__('#%s Cron job triggered.', 'wp_all_export_plugin'), $id)
								));																															
							}
							elseif( $export->processing and ! $export->triggered) 
							{
								wp_send_json(array(
									'status'     => 403,
									'message'    => sprintf(__('Export #%s currently in process. Request skipped.', 'wp_all_export_plugin'), $id)
								));								
							}													
							elseif( ! $export->processing and $export->triggered)
							{
								wp_send_json(array(
									'status'     => 403,
									'message'    => sprintf(__('Export #%s already triggered. Request skipped.', 'wp_all_export_plugin'), $id)
								));								
							}

							break;

						case 'processing':

							if ( $export->processing == 1 and (time() - strtotime($export->registered_on)) > 120){ // it means processor crashed, so it will reset processing to false, and terminate. Then next run it will work normally.
								$export->set(array(
									'processing' => 0									
								))->update();
							}
							
							// start execution imports that is in the cron process												
							if ( ! (int) $export->triggered )
							{
								wp_send_json(array(
									'status'     => 403,
									'message'    => sprintf(__('Export #%s is not triggered. Request skipped.', 'wp_all_export_plugin'), $id)
								));								
							}
							elseif ( (int) $export->executing )
							{
								wp_send_json(array(
									'status'     => 403,
									'message'    => sprintf(__('Export #%s is currently in manually process. Request skipped.', 'wp_all_export_plugin'), $id)
								));								
							}
							elseif ( (int) $export->triggered and ! (int) $export->processing )
							{																															
								$response = $export->set(array('canceled' => 0))->execute($logger, true);								

								if ( ! (int) $export->triggered and ! (int) $export->processing )
								{
									wp_send_json(array(
										'status'     => 200,
										'message'    => sprintf(__('Export #%s complete', 'wp_all_export_plugin'), $export->id)
									));
								}
								else
								{
									wp_send_json(array(
										'status'     => 200,
										'message'    => sprintf(__('Records Processed %s.', 'wp_all_export_plugin'), (int) $export->exported)
									));									
								}

							}
							else 
							{
								wp_send_json(array(
									'status'     => 403,
									'message'    => sprintf(__('Export #%s already processing. Request skipped.', 'wp_all_export_plugin'), $id)
								));								
							}

							break;															
					}								
				}					
			}
		}		
	}

	if ( ! empty($_GET['action']) and $_GET['action'] == 'get_data' and ! empty($_GET['export_id']) and ! empty($_GET['export_hash']))
	{

		if ( $_GET['export_hash'] == substr(md5($cron_job_key . $_GET['export_id']), 0, 16) )
		{
			$export = new PMXE_Export_Record();
		
			$export->getById($_GET['export_id']);

			if ( ! $export->isEmpty())
			{
				$is_secure_import = PMXE_Plugin::getInstance()->getOption('secure');

				if ( ! $is_secure_import)
				{
					$filepath = get_attached_file($export->attch_id);					
				}
				else
				{
					$filepath = wp_all_export_get_absolute_path($export->options['filepath']);
				}	

				if ( ! empty($_GET['part']) and is_numeric($_GET['part'])) $filepath = str_replace(basename($filepath), str_replace('.' . $export->options['export_to'], '', basename($filepath)) . '-' . $_GET['part'] . '.' . $export->options['export_to'], $filepath);
				
				if (file_exists($filepath))
				{
					$uploads  = wp_upload_dir();						
					$fileurl = $uploads['baseurl'] . str_replace($uploads['basedir'], '', str_replace(basename($filepath), rawurlencode(basename($filepath)), $filepath));								
					wp_redirect($fileurl);
				}							
				else
				{
					wp_send_json(array(
						'status'     => 403,
						'message'    => __('File doesn\'t exist', 'wp_all_export_plugin')
					));		
				}
			}
		}
		else
		{
			wp_send_json(array(
				'status'     => 403,
				'message'    => __('Export hash is not valid.', 'wp_all_export_plugin')
			));		
		}		
	}
}