<form>	
	<div class="wp-all-export-field-options">
		<div class="input" style="margin-bottom:10px;">
			<label for="column_value_default" style="padding:4px; display: block;"><?php _e('What field would you like to export?', 'wp_all_export_plugin' )?></label>
			<div class="clear"></div>
			<select class="wp-all-export-chosen-select" name="column_value_type" style="width:350px;">
				<optgroup label="Standard">
					<option value="comment_ID"><?php _e("ID", "wp_all_export_plugin"); ?></option>						
					<option value="comment_post_ID"><?php _e("Post ID", "wp_all_export_plugin"); ?></option>					
					<option value="comment_author"><?php _e("Author", "wp_all_export_plugin"); ?></option>
					<option value="comment_author_email"><?php _e("Author Name", "wp_all_export_plugin"); ?></option>
					<option value="comment_author_url"><?php _e("Author URL", "wp_all_export_plugin"); ?></option>					
					<option value="comment_author_IP"><?php _e("Author IP", "wp_all_export_plugin"); ?></option>
					<option value="comment_date"><?php _e("Date", "wp_all_export_plugin"); ?></option>					
					<option value="comment_content"><?php _e("Content", "wp_all_export_plugin"); ?></option>		
					<option value="comment_karma"><?php _e("Karma", "wp_all_export_plugin"); ?></option>																																																																	
					<option value="comment_approved"><?php _e("Approved", "wp_all_export_plugin"); ?></option>					
					<option value="comment_agent"><?php _e("Agent", "wp_all_export_plugin"); ?></option>										
					<option value="comment_type"><?php _e("Type", "wp_all_export_plugin"); ?></option>										
					<option value="comment_parent"><?php _e("Comment Parent", "wp_all_export_plugin"); ?></option>										
					<option value="user_id"><?php _e("User ID", "wp_all_export_plugin"); ?></option>										
				</optgroup>
				<optgroup label="Advanced">					
					<option value="cf"><?php _e("Custom Field / Comment Meta", "wp_all_export_plugin"); ?></option>
					<option value="sql"><?php _e("SQL Query", "wp_all_export_plugin"); ?></option>					
				</optgroup>				
			</select>																													
		</div>			

		<input type="hidden" name="export_data_type" value="comment"/>

		<div class="input cc_field cf_field_type" style="margin-left: 20px; margin-bottom: 10px;">
			<label style="padding:4px; display: block;"><?php _e('Field Name', 'wp_all_export_plugin'); ?></label>
			<input type="text" class="cf_direct_value autocomplete" value="" style="width:50%;"/>
		</div>		
		
		<div class="input">
			<label style="padding:4px; display: block;"><?php _e('What would you like to name the column/element in your exported file?','wp_all_export_plugin');?></label>
			<div class="clear"></div>
			<input type="text" class="column_name" value="" style="width:50%"/>
		</div>
		
		<a href="javascript:void(0);" class="wp-all-export-advanced-field-options"><span>+</span> <?php _e("Advanced", 'wp_all_export_plugin'); ?></a>

		<div class="wp-all-export-advanced-field-options-content">
			<div class="input cc_field sql_field_type">
				<a href="#help" rel="sql" class="help" style="display:none;" title="<?php _e('%%ID%% will be replaced with the ID of the post being exported, example: SELECT meta_value FROM wp_postmeta WHERE post_id=%%ID%% AND meta_key=\'your_meta_key\';', 'wp_all_export_plugin'); ?>">?</a>								
				<textarea style="width:100%;" rows="5" class="column_value"></textarea>										
			</div>			
			<div class="input cc_field date_field_type">
				<select class="date_field_export_data" style="width: 100%; height: 30px;">
					<option value="unix"><?php _e("UNIX timestamp - PHP time()", "wp_all_export_plugin");?></option>
					<option value="php"><?php _e("Natural Language PHP date()", "wp_all_export_plugin");?></option>									
				</select>
				<div class="input pmxe_date_format_wrapper">
					<label><?php _e("date() Format", "wp_all_export_plugin"); ?></label>
					<br>
					<input type="text" class="pmxe_date_format" value="" placeholder="Y-m-d H:i:s" style="width: 100%;"/>
				</div>
			</div>		
			<div class="input php_snipped" style="margin-top:10px;">
				<input type="checkbox" id="coperate_php" name="coperate_php" value="1" class="switcher" style="float: left; margin: 2px;"/>
				<label for="coperate_php"><?php _e("Export the value returned by a PHP function", "wp_all_export_plugin"); ?></label>								
				<a href="#help" class="wpallexport-help" title="<?php _e('The value of the field chosen for export will be passed to the PHP function.', 'wp_all_export_plugin'); ?>" style="top: 0;">?</a>								
				<div class="switcher-target-coperate_php" style="margin-top:5px;">
					<?php echo "&lt;?php ";?>
					<input type="text" class="php_code" value="" style="width:50%;" placeholder='your_function_name'/> 
					<?php echo "(\$value); ?&gt;"; ?>

					<?php
						$uploads = wp_upload_dir();
						$functions = $uploads['basedir'] . DIRECTORY_SEPARATOR . WP_ALL_EXPORT_UPLOADS_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'functions.php';
						$functions_content = file_get_contents($functions);
					?>

					<div class="input" style="margin-top: 10px;">

						<h4><?php _e('Function Editor', 'wp_all_export_plugin');?><a href="#help" class="wpallexport-help" title="<?php printf(__("Add functions here for use during your export. You can access this file at %s", "wp_all_export_plugin"), preg_replace("%.*wp-content%", "wp-content", $functions));?>" style="top: 0;">?</a></h4>
						
					</div>									

					<textarea id="wp_all_export_code" name="wp_all_export_code"><?php echo (empty($functions_content)) ? "<?php\n\n?>": $functions_content;?></textarea>						

					<div class="input" style="margin-top: 10px;">

						<div class="input" style="display:inline-block; margin-right: 20px;">
							<input type="button" class="button-primary wp_all_export_save_functions" value="<?php _e("Save Functions", 'wp_all_export_plugin'); ?>"/>							
							<div class="wp_all_export_functions_preloader"></div>
						</div>						
						<div class="input wp_all_export_saving_status" style="display:inline-block;">

						</div>

					</div>
				</div>								
			</div>	
		</div>
	</div>																	
	<br>
	<div class="input wp-all-export-edit-column-buttons">			
		<input type="button" class="delete_action" value="<?php _e("Delete", "wp_all_export_plugin"); ?>" style="border: none;"/>									
		<input type="button" class="save_action" value="<?php _e("Done", "wp_all_export_plugin"); ?>" style="border: none;"/>	
		<input type="button" class="close_action" value="<?php _e("Close", "wp_all_export_plugin"); ?>" style="border: none;"/>
	</div>

</form>