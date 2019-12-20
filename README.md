=== WPE Log Copier ===
Contributors: jerrychen017
Tags: wpengine, wpe, log, aws
Author:      Jerry Chen
Version:     1.0
License:     GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.txt

WPE Log Copier is a plugin that copies WPEngine access and error log files to your designated AWS S3 bucket on a hourly, daily, or twice daily basis.

== Description ==

WPEngine is a popular platform for hosting WordPress. It's always good to have a backup for logs but 
WPEngine only keeps log files for 24 hours. WPE Log Copier can automate the log copying process by 
copying access and error logs from WPEngine to your designated AWS bucket on an hourly, daily, or twice daily 
basis. Time in the plugin is in Coordinated Universal TIme (UTC)

== Installation ==

1. Download `wpe-log-copier` in `.zip` format
2. Go to `Plugin` in your WordPress admin page and click on `Add new` 
3. Click on `Upload Plugin` and upload `wpe-log-copier.zip`
4. Activate the plugin through the 'Plugins' menu in WordPress
5. You can find the plugin `Simple WPEngine Log` under `Settings`

== Frequently Asked Questions ==

= Where is this plugin located at = 
WPE Log Copier is located under `Settings`

= Where do I find WPE logs =
Within WordPress, you can find it in `General Settings `under `WP Engine`

= Where do I find my AWS Access  =
After you log in to your AWS Management Console, click on your username on the top-right of the screen. 
Choose `My Security Credentials` and expand the menu with description `Access Keys (access key ID and secrete access key)`

