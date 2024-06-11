<?php

namespace Cornerstone\CodeBlocks\Element;

use const Cornerstone\CodeBlocks\Enqueue\MAIN_SCRIPT_NAME;

/**
 * Code block element
 */
$values = cs_compose_values(
  [
    'code' => cs_value( '', 'markup' ),
    'language' => cs_value( 'javascript', 'markup' ),
    'color_scheme' => cs_value( 'tomorrow-night-bright', 'markup' ),
  ],
  'omega',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Render
// =============================================================================

function render( $data ) {

  $atts = [
    'data-cs-code-block' => '',
    'class' => "cs-code-block-{$data['color_scheme']} hljs language-{$data['language']}",
  ];

  if (!empty($data['_builder_atts'])) {
    $atts = array_merge($data['_builder_atts']);
  }

  wp_enqueue_script(MAIN_SCRIPT_NAME);

  $style_name = 'cs-code-block-' . $data['color_scheme'];
  $style_url = CS_CODE_BLOCKS_URI . 'dist/css/' . $data['color_scheme'] . '.css';
  pdebug($style_url);
  wp_register_style(
    $style_name,
    $style_url,
    [],
    CS_CODE_BLOCKS_URI
  );

  wp_enqueue_style($style_name);

  $output = cs_tag('pre', [],
    cs_tag( 'code', $atts, htmlspecialchars($data['code']) ),
  );

  return $output;
}



// Controls

function controls() {
  return cs_compose_controls(
    [
      'controls' => [
        // Language
        [
          'key' => 'language',
          'label' => __('Language', 'cornerstone'),
          'type' => 'text',
          'group' => 'code-block:general',
        ],

        // Code
        [
          'key' => 'code',
          'type' => 'code-editor',
          'group' => 'code-block:general',
        ],
      ],
      'control_nav' => [
        'code-block' => cs_recall( 'label_primary_control_nav' ),
        'code-block:general' => cs_recall( 'label_general' ),
      ],
    ],
    cs_partial_controls( 'effects' ),
    cs_partial_controls( 'omega', [
      'add_custom_atts' => true,
      'add_looper_provider' => true,
      'add_looper_consumer' => true
    ])
  );
}


// Register Element
// =============================================================================

cs_register_element( 'code-block', [
  'title'      => __( 'Code Block', 'cornerstone' ),
  'values'     => $values,
  'includes'   => [ 'effects' ],
  'builder'    => __NAMESPACE__ . '\controls',
  'render'     => __NAMESPACE__ . '\render',
  'group'      => 'content',
  'options'    => []
] );
