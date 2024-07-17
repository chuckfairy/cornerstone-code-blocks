<?php

namespace Cornerstone\CodeBlocks\Enqueue;

const MAIN_SCRIPT_NAME = 'cornerstone-code-blocks';

// Script URI use .min if not running SCRIPT_DEBUG
$SCRIPT_URI = defined('SCRIPT_DEBUG') && !empty(SCRIPT_DEBUG)
  ? CS_CODE_BLOCKS_URI . '/dist/js/cornerstone-code-blocks.js'
  : CS_CODE_BLOCKS_URI . '/dist/js/cornerstone-code-blocks.min.js';

// Setup script registery
wp_register_script(
  MAIN_SCRIPT_NAME,
  $SCRIPT_URI,
  ['cs'],
  CS_CODE_BLOCKS_VERSION
);

// Registry base styles
wp_register_style(
  MAIN_SCRIPT_NAME,
  CS_CODE_BLOCKS_URI . '/css/code-blocks.css',
  ['cs'],
  CS_CODE_BLOCKS_VERSION
);


/**
 * Enqueue main script if loading a code block
 */
function enqueue() {
  wp_enqueue_script(MAIN_SCRIPT_NAME);
}

/**
 * Enqueue hljs language registration script
 */
function enqueue_language(string $language) {
  $name = MAIN_SCRIPT_NAME . '-' . $language;
  $src = CS_CODE_BLOCKS_URI . 'dist/js/languages/' . $language . '.js';

  // Setup script registery
  wp_register_script(
    $name,
    $src,
    ['cs', MAIN_SCRIPT_NAME],
    CS_CODE_BLOCKS_VERSION
  );

  wp_enqueue_script($name);
}

function enqueue_color_scheme(string $colorScheme) {
  $style_name = 'cs-code-block-' . $colorScheme;
  $style_url = CS_CODE_BLOCKS_URI . 'dist/css/' . $colorScheme . '.css';

  wp_register_style(
    $style_name,
    $style_url,
    [],
    CS_CODE_BLOCKS_VERSION
  );

  wp_enqueue_style($style_name);
}

/**
 * Default styling for code blocks to limit CSS output
 */
function enqueue_default_styles() {
  wp_enqueue_style(MAIN_SCRIPT_NAME);
}
