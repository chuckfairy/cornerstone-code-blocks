<?php

/**
 * Code block element
 */

namespace Cornerstone\CodeBlocks\Element;

use function Cornerstone\CodeBlocks\Enqueue\enqueue;
use function Cornerstone\CodeBlocks\Enqueue\enqueue_color_scheme;
use function Cornerstone\CodeBlocks\Enqueue\enqueue_language;

// Defaults
$language = apply_filters('cs_code_blocks_default_language', 'javascript');
$tabSize = apply_filters('cs_code_blocks_default_tab_size', 2);
$colorScheme = apply_filters('cs_code_blocks_default_tab_size', 'tomorrow-night-bright');


// Code block element values
$values = cs_compose_values(
  [
    'code' => cs_value(
      __('/* Should Old Acquaintance be forgot, and never brought to mind? */', 'cornerstone'),
      'markup'
    ),
    'language' => cs_value( $language, 'markup' ),
    'tab_size' => cs_value( $tabSize, 'style' ),
    'color_scheme' => cs_value( $colorScheme, 'markup' ),

    'width' => cs_value( '100%' ),
    'max_width' => cs_value( 'none' ),
    'margin' => cs_value( '!0em' ),
    'padding' => cs_value( '!0em' ),

    'border_width' => cs_value( '!0px' ),
    'border_style' => cs_value( 'solid' ),
    'border_color' => cs_value( 'transparent', 'style:color' ),
    'border_color_alt' => cs_value( '', 'style:color' ),
    'border_radius' => cs_value( '!0px' ),
    'box_shadow_dimensions' => cs_value( '!0px 0px 0px 0px' ),
    'box_shadow_color' => cs_value( 'transparent', 'style:color' ),
    'box_shadow_color_alt' => cs_value( '', 'style:color' ),

    'font_family' => cs_value( 'inherit', 'style:font-family' ),
    'font_weight' => cs_value( 'inherit', 'style:font-weight' ),
    'font_size' => cs_value( '1em' ),
    'line_height' => cs_value( 'inherit' ),
    'letter_spacing' => cs_value( '0em' ),
    'font_style' => cs_value( 'normal' ),

    'text_decoration' => cs_value( 'none' ),
    'text_transform' => cs_value( 'none' ),
    'text_shadow_dimensions' => cs_value( '!0px 0px 0px' ),
    'text_shadow_color' => cs_value( 'transparent', 'style:color' ),
    'text_shadow_color_alt' => cs_value( '', 'style:color' ),
  ],
  'omega',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Render element data

function render( $data ) {

  $pre_atts = [
    'class' => implode(' ', $data['classes']) . ' cs-code-block',
  ];

  $atts = [
    'data-cs-code-block' => '',
    'class' => "cs-code-block-code cs-code-block-{$data['color_scheme']} hljs language-{$data['language']}",
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
  $design_group = [
    'group' => 'code-block:design',
  ];

  //pdebug(cs_control( 'margin', '' ));exit;
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
                // @see extension/DynamicOptions.php
                'choices' => 'dynamic:code_blocks_languages',
              ],
            ],

            // Color Scheme
            [
              'key' => 'color_scheme',
              'label' => __('Color Scheme', 'cornerstone'),
              'type' => 'select',
              'options' => [
                // @see extension/DynamicOptions.php
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

        // Text Group
        cs_control( 'text-format', '', [
          'group' => 'code-block:text',
          'no_text_color' => true,
          'no_text_align' => true,
        ]),

        // Design Group
        cs_recall( 'control_mixin_width', [
          'key' => 'width',
          'group' => 'code-block:design',
        ]),

        // Margin
        cs_control( 'margin', '', $design_group ),

        // Padding
        cs_control( 'padding', '', $design_group ),

        // Border
        cs_control( 'border', '', $design_group ),

        // Border Radius
        cs_control( 'border-radius', '', $design_group ),

        // Box Shadow
        cs_control( 'box-shadow', '', $design_group ),
      ],
      'control_nav' => [
        'code-block' => cs_recall( 'label_primary_control_nav' ),
        'code-block:general' => cs_recall( 'label_general' ),
        'code-block:text' => cs_recall( 'label_text' ),
        'code-block:design' => cs_recall( 'label_design' ),
      ],
    ],

    // Effects Tab
    cs_partial_controls( 'effects' ),

    // Omega / Customize Tab
    cs_partial_controls( 'omega', [
      'add_custom_atts' => true,
      'add_looper_provider' => true,
      'add_looper_consumer' => true
    ])
  );
}


// Register Element

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
]);
