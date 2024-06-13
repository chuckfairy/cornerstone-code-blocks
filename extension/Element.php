<?php

namespace Cornerstone\CodeBlocks\Element;

use function Cornerstone\CodeBlocks\Enqueue\enqueue;
use function Cornerstone\CodeBlocks\Enqueue\enqueue_color_scheme;
use function Cornerstone\CodeBlocks\Enqueue\enqueue_language;

/**
 * Code block element
 */
$values = cs_compose_values(
  [
    'code' => cs_value( '', 'markup' ),
    'language' => cs_value( 'javascript', 'markup' ),
    'tab_size' => cs_value( 2, 'style' ),
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

  $pre_atts = [
    'class' => implode(' ', $data['classes']) . ' cs-code-block',
  ];

  $atts = [
    'data-cs-code-block' => '',
    'class' => "cs-code-block-{$data['color_scheme']} hljs language-{$data['language']}",
  ];

  if (!empty($data['_builder_atts'])) {
    $atts = array_merge($atts, $data['_builder_atts']);
  }

  // Enqueue JS
  enqueue();

  // Enqueue Language JS
  enqueue_language($data['language']);

  // Enqueue color scheme
  enqueue_color_scheme($data['color_scheme']);

  $output = cs_tag('pre', $pre_atts,
    cs_tag( 'code', $atts, htmlspecialchars($data['code']) ),
  );

  return $output;
}

// Preview integration
add_action('cs_before_preview_frame', function() {
  enqueue();
});



// Controls

function controls() {
  return cs_compose_controls(
    [
      'controls' => [
        // General
        [
          'type' => 'group',
          'group' => 'code-block:general',
          'label' => __('General', 'cornerstone'),
          'controls' => [

            // Language
            [
              'key' => 'language',
              'label' => __('Language', 'cornerstone'),
              'type' => 'select',
              'options' => [
                'choices' => 'dynamic:code_blocks_languages',
              ],
            ],

            // Color Scheme
            [
              'key' => 'color_scheme',
              'label' => __('Color Scheme', 'cornerstone'),
              'type' => 'select',
              'options' => [
                'choices' => 'dynamic:code_blocks_color_schemes',
              ],
            ],

            // Tab Size
            cs_partial_controls('range', [
              'key' => 'tab_size',
              'label' => __('Tab Size', 'cornerstone'),
              'min' => 0,
              'max' => 12,
              'steps' => 1,
            ]),

            // Code
            [
              'key' => 'code',
              'type' => 'code-editor',
              'options' => [
                'mode' => 'html',
                'expandable' => true,
                'height' => 8,
                'is_draggable' => false,
                'no_rich_text' => true,
                'button_label' => cs_recall( 'label_edit' ),
                'header_label' => __('Code', 'cornerstone'),
              ],
            ],
          ],
        ],

        // Design
        [
          'type' => 'group',
          'group' => 'code-block:design',
          'label' => cs_recall('label_padding'),
          'controls' => [
            // Padding
            [
              'key' => 'padding',
              'label' => cs_recall('label_padding'),
              'type' => 'text',
            ],
          ],
        ],
      ],
      'control_nav' => [
        'code-block' => cs_recall( 'label_primary_control_nav' ),
        'code-block:general' => cs_recall( 'label_general' ),
        'code-block:design' => cs_recall( 'label_design' ),
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
  'title' => __( 'Code Block', 'cornerstone' ),
  'values' => $values,
  'includes' => [ 'effects' ],
  'builder' => __NAMESPACE__ . '\controls',
  'render' => __NAMESPACE__ . '\render',
  'group' => 'content',
  'style' => function() {
    return file_get_contents(CS_CODE_BLOCKS_PATH . 'tss/code-blocks.tss');
  },
  'options' => []
] );
