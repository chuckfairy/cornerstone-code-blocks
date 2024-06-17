<?php

/**
 * Dynamic Options
 */


// Code blocks color cchemes
// dynamic:code_blocks_color_schemes
cs_dynamic_content_register_dynamic_option('code_blocks_color_schemes', [
  'filter' => function() {
    $json = file_get_contents(CS_CODE_BLOCKS_PATH . 'dist/json/color-schemes.json');

    $json = json_decode($json, true);

    // Alphabetize
    sort($json);

    // Return as control select choices
    return cs_array_as_choices($json);
  },
]);

// Code blocks languages
// dynamic:code_blocks_languages
cs_dynamic_content_register_dynamic_option('code_blocks_languages', [
  'filter' => function() {
    $json = file_get_contents(CS_CODE_BLOCKS_PATH . 'dist/json/languages.json');

    $json = json_decode($json, true);

    // Return as control select choices
    return cs_array_as_choices($json);
  },
]);
