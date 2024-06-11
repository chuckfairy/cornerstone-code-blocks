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

// @TODO
function enqueue_language(string $language) {

}

function enqueue_color_scheme(string $colorScheme) {
  $style_name = 'cs-code-block-' . $colorScheme;
  $style_url = CS_CODE_BLOCKS_URI . 'dist/css/' . $colorScheme . '.css';

  wp_register_style(
    $style_name,
    $style_url,
    [],
    CS_CODE_BLOCKS_URI
  );

  wp_enqueue_style($style_name);
}
