<?php


// Dynamic Options API Global

cs_dynamic_content_register_dynamic_option('code_blocks_color_schemes', [
  'filter' => function() {
    $json = file_get_contents(CS_CODE_BLOCKS_PATH . 'dist/json/color-schemes.json');

    //pdebug(CS_CODE_BLOCKS_PATH . 'dist/json/color_schemes.json', $json);exit;
    $json = json_decode($json, true);

    // Return as control select choices
    return cs_array_as_choices($json);
  },
]);

cs_dynamic_content_register_dynamic_option('code_blocks_languages', [
  'filter' => function() {
    $json = file_get_contents(CS_CODE_BLOCKS_PATH . 'dist/json/languages.json');

    //pdebug(CS_CODE_BLOCKS_PATH . 'dist/json/color_schemes.json', $json);exit;
    $json = json_decode($json, true);

    // Return as control select choices
    return cs_array_as_choices($json);
  },
]);
