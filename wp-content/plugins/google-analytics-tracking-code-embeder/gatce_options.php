<div class="wrap">
<div class="ico-gatce" id="icon-options-gatce"><br></div>
<h2>Google Analytics Tracking Code Embeder</h2>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">
<tr>
	<th>Google Analytics Tracking code:</th>
	<td>
	<textarea name="gatc_code" rows="12" cols="80"><?php echo get_option('gatc_code'); ?></textarea>
	</td>
</tr>
<tr>
	<th>GA Code Placement:</th>
	<td>
	<?php
	
		$gaPlacement = ($gaPlacement=get_option('gatc_placement'))?$gaPlacement:"B";	
		
	?>
	<select name="gatc_placement" onchange="gatc_showinfo(this.value);">
		<option value="H" <?php if("H" == $gaPlacement) echo "selected='selected'"; ?>>Before the closing &lt;/head&gt; tag</option>
		<option value="B" <?php if("B" == $gaPlacement) echo "selected='selected'"; ?>>Before the closing &lt;/body&gt; tag</option>
	</select>
	
	<div id="gatc_placement_head" style="display:<?php echo (("H" == $gaPlacement)? "block":"none"); ?>">
	 <a target="_blank" href="http://www.google.com/support/analytics/bin/answer.py?answer=174090">Recommended for the new asynchronous tracking code</a>. Requires <pre style="display:inline">&lt;?php wp_head();?&gt;</pre> template tag inside head section.
	</div>
	<div id="gatc_placement_body" style="display:<?php echo (("B" == $gaPlacement)? "block":"none"); ?>">
	 <a target="_blank" href="http://www.google.com/support/analytics/bin/answer.py?answer=55480">Recommended for the traditonal traking code</a>. Requires <pre style="display:inline">&lt;?php wp_footer();?&gt;</pre> template tag near the footer.
	</div>
	</td>
</tr>
<tr>
	<th>Disable Google Analytics Code</th>
	<td>
		<input id="gatc_disabled" type="checkbox" value='1' name="gatc_disabled" <?php echo (get_option('gatc_disabled')=='1')? "checked=\"checked\"" :  ""; ?> />
		<label for="gatc_disabled">Don't Embed the code.</label><br/><em>(Check this option if you temporarily don't want to embed the GA code through this plugin. Your GA code above will stay intact)</em>
		
	</td>
</tr>

</table>
<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="gatc_code,gatc_disabled,gatc_placement" />
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>


<p>
	Notes:
	<ol>
		<li>If you don't have your google analytics tracking code already <a href="http://www.google.com/analytics/">get your code</a>	from Google Analytics</li>
		<li>Make sure you don't have already a Google Analytics Tracking code hard-coded in your theme file.</li>
		<li>To function this plugin correctly make sure your theme file has required template tags:<br/><br/>
		<ol>
			<li><pre style="display:inline">&lt;?php wp_head(); ?&gt;</pre> before closing &lt;/head&gt; tag  if you want to embed the code inside the head section. <a target="_blank" href="http://www.google.com/support/analytics/bin/answer.py?answer=174090">Recommended for the new asynchronous tracking code</a>.</li>
			<li><pre style="display:inline">&lt;?php wp_footer(); ?&gt;</pre> before closing &lt;/body&gt; tag if you want to embed the code near the page footer. <a target="_blank" href="http://www.google.com/support/analytics/bin/answer.py?answer=55480">Recommended for the traditonal tracking code</a>.</li>
		</ol>

		Get <a href="http://www.mixedwaves.com/google-analytics-tracking-code-embeder/" target="_blank">more info</a>
		</li>
	</ol>
	</p>
</form>

<script language="javascript">

function gatc_showinfo(option){
	if("H" == option){
		jQuery("#gatc_placement_body").hide();
		jQuery("#gatc_placement_head").show();
	}
	else if("B" == option){
		jQuery("#gatc_placement_head").hide();
		jQuery("#gatc_placement_body").show();
	}
}
</script>


<!-- social -->
<hr/>
<h3>Help spread the word</h3>
<p>
<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.mixedwaves.com%2Fgoogle-analytics-tracking-code-embeder%2F&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
</p>
<p>
<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://www.mixedwaves.com/google-analytics-tracking-code-embeder/" data-text="Check out this cool plugin to easily embed the google analytics tracking code in your WordPress blog" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
</p>

<!-- soclial end -->
</div>