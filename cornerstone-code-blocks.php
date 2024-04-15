<?php

/*
Plugin Name: Cornerstone Code Blocks
Plugin URI: https://theme.co
Description: Code blocks with Syntax Highlighting with Highlight.js
Version:      1.0.0
Author: Chuckfairy
Author URI: https://chuckfairy.com/
Text Domain: cornerstone
Themeco Plugin: cornerstone-code-blocks
*/

define('CS_CODE_BLOCKS_URI', plugin_dir_url(__FILE__));
define('CS_CODE_BLOCKS_VERSION', '1.0.0');

add_action('init', function() {
  if (!function_exists('cornerstone')) {
    trigger_error('Cornerstone is not installed, Cornerstone Code Blocks does not work without it');
    return;
  }

  require_once(__DIR__ . '/extension/Element.php');
});
