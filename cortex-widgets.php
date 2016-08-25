<?php
/*
Plugin Name: Cortex Widgets
Plugin URI:  http://cortex.covertnine.com
Description: For creating the widgets used in the Cortex Wordpress Theme.
Version:     1.0.4
Author:      COVERT NINE
Author URI:  http://www.covertnine.com
Text Domain: cortex-widgets
GitHub Plugin URI: https://github.com/covertnine/cortex-widgets
GitHub Branch: master
*/

defined( 'ABSPATH' ) or die( 'Restricted' );

// define some constants
define('CORTEX_WIDGETS_JS_URL', plugin_dir_url(__FILE__) . 'widgets/js');
define('CORTEX_WIDGETS_CSS_URL', plugin_dir_url(__FILE__) . 'widgets/css');
define('CORTEX_WIDGETS_IMAGES_URL', plugin_dir_url(__FILE__) . 'widgets/img');
define('CORTEX_WIDGETS_INSTAGRAM_WIDGET_BASE', 'widgets/widget-instagram.php');
define('CORTEX_WIDGETS_INSTAGRAM_WIDGET_FILE', 'widget-instagram.php');
define("CORTEX_WIDGETS_PATH", plugin_dir_path(__FILE__));
define('CORTEX_WIDGETS_INCLUDES_PATH', plugin_dir_path(__FILE__) . '/includes');
define('CORTEX_TEXTDOMAIN', 'cortex-widgets');

class CortexWidgets{

	public function __construct() {
		add_action( 'init', array( &$this, 'load_plugin_textdomain' ) );
	}

	public function load_plugin_textdomain() {
		$domain = CORTEX_TEXTDOMAIN;
		load_plugin_textdomain( $domain, FALSE, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages' );
	}
}

/**
 * Function to look in the theme directory for a custom template before loading the default template
 *
 * @since 1.0
 */

function cortex_widget_get_template( $template ) {

    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';

    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    if ( $theme_file = locate_template( array( 'widget-templates/' . $template ) ) ) {
        $file = $theme_file;
    }
    else {
        $file = CORTEX_WIDGETS_PATH . '/widget-templates/' . $template;
    }

    return apply_filters( 'rc_repl_template_' . $template, $file );
}

require_once( CORTEX_WIDGETS_PATH . '/widgets/widget-about.php');
require_once( CORTEX_WIDGETS_PATH . '/widgets/widget-instagram.php');
require_once( CORTEX_WIDGETS_PATH . '/widgets/widget-subscribe.php');
require_once( CORTEX_WIDGETS_PATH . '/widgets/widget-mailchimp.php');
require_once( CORTEX_WIDGETS_PATH . '/widgets/widget-twitter.php');
require_once( CORTEX_WIDGETS_PATH . '/widgets/widget-contact.php');
require_once( CORTEX_WIDGETS_PATH . '/widgets/widget-latest-category.php');
require_once( CORTEX_WIDGETS_PATH . '/widgets/widget-upcoming-events.php');