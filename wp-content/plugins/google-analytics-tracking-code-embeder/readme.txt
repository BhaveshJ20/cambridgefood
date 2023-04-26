=== Google Analytics Tracking Code Embeder ===
Contributors: penuel
Tags: google, google analytics, GA tracking code, GA asynchronus code
Requires at least: 2.5
Tested up to: 3.1.1
Author URI: http://www.mixedwaves.com
Plugin URI: http://www.mixedwaves.com/google-analytics-tracking-code-embeder/
Stable tag: trunk


This simple plugin dynamically embeds your Google Analytics Tracking Code in your Wordpress theme.

== Description ==

This is a small easy plugin that embeds your Google Analytics Tracking Code inside your theme files dynamically without you needing to hard-code it in your template files.

This is pretty useful if you frequently change your Wordpress Theme files, and now you don’t need to worry about leaving out your Google Analytics code accidently just because you switched to a new theme.

== Installation ==

This section describes how to install the plugin and get it working.

1. Download the plugin and upload and unzip to your plugins directory as you would usually do.
1. Activate the plugin from your Wordpress Admin.
1. Go to the plugin’s options page to add your Google Analytics Tracking Code. You can find the options page under Settings >> GA Tracking Code
1. Save your changes. You have now successfully added your GA tracking code, and it will be automatically added to all your blog pages.
1. To verify if your Google Analytics Tracking code has been added correctly, go to any of your blog page and View the source of your page. If the plugin is working correctly you should be able to see your Google Analytics tracking code near to the end of the page (near to the closing </body> tag). If you don’t find your Google Analytics code, please refer to the Prerequisites section below.

== Prerequisites ==

The plugin requires that your theme files have one of the following action/template tags depending on where you want to place your GA tracking code.

`<?php wp_head(); ?>`

If you want to place the tracking code inside the head section before the closing &lt;/head&gt; tag.

`<?php wp_footer(); ?>`

If you want to place the tracking code near page end/footer before the closing &lt;/body&gt; tag

While these actions/template tags are widely supported by most of the theme authors, chances are there that these actions are not available in your theme file. In such a case, the plugin won’t be able to embed the Google Analytics tracking code to your theme.

However, you can easily edit your header.php file and add the `<?php wp_head(); ?>` tag just before the closing &lt;/head&gt; tag or for footer place the `<?php wp_footer(); ?>` tag towards the end of the file, just before the closing </body> tag.

== Changelog ==

= 1.5.1 =
* Fixed a typo in help text.

= 1.5 =
* Added support for the new asynchronus google analytics code. Tracking code can now be embeded inside the head section. 
* Added more help text.
* Added social plugins to make plugin popular.

= 1.0 =
* Support for embeding tracking code at the page footer before closing body tag

== Upgrade Notice ==

= 1.5.1 =
Minor update: Fixed a typo in help text.