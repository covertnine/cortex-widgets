=== Cortex Widgets ===
Contributors: COVERTNINE
Donate link: https://www.covertnine.com/
Tags: widgets
Requires at least: 4.0
Tested up to: 4.9
Stable tag: 4.8.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin that enables you to utilize widgets for the Cortex Wordpress Theme including Twitter and Instagram feeds

== Description ==

This plugin creates several widgets that are used throughout the Cortex Wordpress theme. Widgets include a simple hCard supported "get in touch" widget, an instagram widget that pulls in the latest instagram photos from a specific user, a Twitter feed widget that pulls in latest tweets with proper API credentials, a MailChimp sign up widget, a simple social "subscribe" widget with social media icons, an upcoming events widget that automatically hides events after they have passed, and a latest posts widget with featured image icon.


== Installation ==


1. Upload the plugin files to the `/wp-content/plugins/cortex-widgets` directory, or install the plugin through the WordPress plugins screen directly after activating the Cortex Theme or Cortex Child Theme.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the fields under the Cortex Options screen to configure the widget API keys. (These are pulled from MailChimp & Dev.Twitter.com)
4. Drag & drop widgets into the various sidebars and configure them from the Appearance > Widgets screen


== Frequently Asked Questions ==

= Is this plugin required? =

Yes this plugin is required for the Cortex Wordpress Theme

= Does this plugin work with other themes? =

At this time the Cortex Widgets plugin only works with the Cortex Theme



== Changelog ==
1.2.6 =
* added support for Mailchimp API version 3.0

1.2.5 =
* updated bugs related to PHP 7.2 and limit of mailchimp lists to 25 items

1.2.3 =
* updated Instagram widget to work with new object

 1.2.24 =
 * updated function for mailchimp class to use __construct

 1.2.21 =
 * removed additional alt text from avatar image in basic template

 1.2.2 =
 * Added new image size for event posters and bigger screens Tested up to 4.9

 1.2.1 =
 * Changed date format to match theme.

 1.2 =
 * Removed about widget as it's been replaced by WordPress' built-in text widget. Updated translation functions and file names. Tested up to 4.9

 1.1 =
 * Added more HTML for template changes and fixed dates to use new custom fields. Tested up to 4.8.2

 1.0.11 =
 * Removed first_post_image function, which was broken

  1.0.10 =
 * Added HTTPS for twitter image

 1.0.9 =
 * Added messaging for scrape limit for Instagram to 12

= 1.0.8 =
* Stable
* Added checks to look for blank API keys for Twitter so users have to enter them before the widget options will show up. Template fixes

= 1.0.6 =
* Stable
* updated date fields to match up with new ACF fields and fixed up some formatting. Also changed link if you haven't filled in Mail Chimp API keys.

= 1.0 =
* Stable
* API entry moved to Cortex Theme Options page away from Customizer

