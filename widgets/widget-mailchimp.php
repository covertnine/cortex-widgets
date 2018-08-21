<?php

// Block direct requests
if ( !defined('ABSPATH') )
  die('-1');

require_once(CORTEX_WIDGETS_INCLUDES_PATH . '/mcapi.class.php');
require_once(CORTEX_WIDGETS_INCLUDES_PATH . '/ns_mc_plugin.class.php');
require_once(CORTEX_WIDGETS_INCLUDES_PATH . '/ns_widget_mailchimp.class.php');
require_once(CORTEX_WIDGETS_INCLUDES_PATH . '/mcapi-3.0.class.php');

$ns_mc_plugin = NS_MC_Plugin::get_instance();
?>
