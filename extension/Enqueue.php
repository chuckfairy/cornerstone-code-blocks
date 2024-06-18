<?php

namespace Cornerstone\CodeBlocks\Enqueue;

const MAIN_SCRIPT_NAME = 'cornerstone-code-blocks';

// Setup script registery
wp_register_script(
  MAIN_SCRIPT_NAME,
  CS_CODE_BLOCKS_URI . '/dist/js/cornerstone-code-blocks.js',
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
  static $hasAdded;

  if (!is_null($hasAdded)) {
    return;
  }

  $hasAdded = true;

  cornerstone('Styling')->addStyles(
    'cs-code-blocks-default-styling',
    file_get_contents(CS_CODE_BLOCKS_PATH . 'css/code-blocks.css')
  );
}
