<?php

/**
 * Code block element
 */

namespace Cornerstone\CodeBlocks\Element;

use function Cornerstone\CodeBlocks\Enqueue\enqueue;
use function Cornerstone\CodeBlocks\Enqueue\enqueue_color_scheme;
use function Cornerstone\CodeBlocks\Enqueue\enqueue_default_styles;
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
    'white_space' => cs_value('inherit'),

    'width' => cs_value( '100%' ),
    'max_width' => cs_value( 'none' ),
    'min_width' => cs_value( '0px' ),

    'height' => cs_value( 'auto' ),
    'max_height' => cs_value( 'none' ),
    'min_height' => cs_value( '0px' ),

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
  // Omega / Customize tab values
  'omega',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Render element data

function render( $data ) {
  // <pre> tag top level element attributes
  $pre_atts = [
    'class' => implode(' ', $data['classes']) . ' cs-code-block',
    'data-code-block' => true,
  ];

  // ID set from the customize tab
  if (!empty($data['id'])) {
    $pre_atts['id'] = $data['id'];
  }

  // Custom attributes merging
  if (!empty($data['custom_atts'])) {
    $pre_atts = array_merge($pre_atts, json_decode($data['custom_atts'], true));
  }

  // Preview attributes
  if (!empty($data['_builder_atts'])) {
    $pre_atts = array_merge($pre_atts, $data['_builder_atts']);
  }

  // Apply effects from Effects tab
  $pre_atts = cs_apply_effect( $pre_atts, $data );

  // Our attributes for the <code> element
  $atts = [
    'data-cs-code-block' => '',
    'class' => "cs-code-block-code cs-code-block-{$data['color_scheme']} hljs language-{$data['language']}",
  ];

  // Enqueue JS
  enqueue();

  // Enqueue Language JS
  enqueue_language($data['language']);

  // Enqueue color scheme
  enqueue_color_scheme($data['color_scheme']);

  // Default styling
  enqueue_default_styles();

  // Output <pre><code> output
  $output = cs_tag('pre', $pre_atts,
    cs_tag( 'code', $atts, htmlspecialchars($data['code']) ),
  );

  // Return rendered string
  return $output;
}


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
              'description' => __('The size of tabs used in the code editor. This does not change the size of spaces', 'cornerstone'),
              'min' => 0,
              'max' => 12,
              'steps' => 1,
            ]),

            // White Space / Word Wrapping
            [
              'key' => 'white_space',
              'label' => __('Line Wrap', 'cornerstone'),
              'type' => 'choose',
              'options' => [
                'choices' => [

                  [
                    'value' => 'inherit',
                    'label' => __('No', 'cornerstone'),
                  ],

                  [
                    'value' => 'pre-wrap',
                    'label' => __('Yes', 'cornerstone'),
                  ],

                ],
              ],
            ],

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

        [
          'type' => 'group',
          'group' => 'code-block:design',
          'controls' => [
            // Width
            cs_recall( 'control_mixin_width', [
              'key' => 'width',
            ]),

            // Min Width
            cs_recall( 'control_mixin_min_width', [
              'key' => 'min_width',
            ]),

            // Max Width
            cs_recall( 'control_mixin_max_width', [
              'key' => 'max_width',
            ]),

            // Height
            cs_recall( 'control_mixin_height', [
              'key' => 'height',
            ]),

            // Min Height
            cs_recall( 'control_mixin_min_height', [
              'key' => 'min_height',
            ]),

            // Max Height
            cs_recall( 'control_mixin_max_height', [
              'key' => 'max_height',
            ]),
          ],
        ],

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
  'tss' => [
    'modules' => [
      ['effects', [
        'args' => [
          // This is a hack because pre tags do not have transitions set
          // And 0ms would be registered as empty causing it to go to the default
          // which is 300ms
          'transition_base' => '0.5ms'
        ]
      ]],
    ],
  ],
  'options' => []
]);
