<?php

// Code Snippet Area Prefab
cs_register_prefab_element('interactive', 'code-block-area', [
  'title' => __('Code Block Area', 'cornerstone'),
  'type' => 'layout-div',
  'scope'  => [ 'all' ],
  'values' => [
    '_type' => 'layout-div',
    '_label' => 'Code Snippet Area',
    '_p_json' => json_encode([
      'header' => [
        'type' => 'group',
        'params' => [
          'title' => [
            'type' => 'text',
            'initial' => 'MyCode.js'
          ],
          'backgroundColor' => [
            'type' => 'color',
            'initial' => 'rgb(96, 96, 96)'
          ],
          'textColor' => [
            'type' => 'color-pair',
            'initial' => [
              'base' => 'rgb(255, 255, 255)',
              'alt' => 'rgba(255, 255, 255, .5)'
            ]
          ]
        ]
      ],
      'code' => [
        'type' => 'group',
        'params' => [
          'language' => [
            'type' => 'select',
            'initial' => 'javascript',
            'options' => 'dynamic:code_blocks_languages'
          ],
          'colorScheme' => [
            'type' => 'select',
            'initial' => 'tomorrow-night-bright',
            'options' => 'dynamic:code_blocks_color_schemes'
          ],
          'tabSize' => [
            'type' => 'dimension',
            'initial' => 2,
            'unitless' => true,
            'ranges' => [
              'unit' => [
                'min' => 1,
                'max' => 12,
                'steps' => 1
              ]
            ]
          ],
          'code' => [
            'type' => 'code',
            'expandable' => true,
            'initial' => 'console.log("test")',
            'height' => 4
          ]
        ]
      ],
      'setup' => [
        'type' => 'group',
        'params' => [
          'id' => [
            'type' => 'text',
            'initial' => '{{dc:random:uniqueid prefix="code-"}}'
          ]
        ]
      ]
    ], JSON_PRETTY_PRINT),
    'layout_div_border_color' => 'rgb(206, 206, 206)',
    'layout_div_border_color_alt' => 'rgb(206, 206, 206)',
    'layout_div_border_radius' => '0.5em',
    'layout_div_border_width' => '3px',
    'layout_div_overflow_x' => 'hidden',
    'layout_div_overflow_y' => 'hidden',
    '_modules' => [
      [
        '_type' => 'layout-div',
        '_bp_base' => '4_4',
        '_label' => 'Header',
        'layout_div_bg_color' => '{{dc:p:header.backgroundColor}}',
        'layout_div_flex_align' => 'center',
        'layout_div_flex_direction' => 'row',
        'layout_div_flex_justify' => 'space-between',
        'layout_div_flex_wrap' => false,
        'layout_div_flexbox' => true,
        'layout_div_height' => '4em',
        'layout_div_padding' => '1em',
        '_modules' => [
          [
            '_type' => 'text',
            '_bp_base' => '4_4',
            'text_content' => '{{dc:p:header.title}}',
            'text_text_color' => '{{dc:p:header.textColor.base}}',
          ],
          [
            '_type' => 'layout-div',
            '_bp_base' => '4_4',
            '_label' => 'Copy Area',
            'custom_atts' => '{"data-copy-element":"#{{dc:p:setup.id}}","data-copy-text-selector":"[data-copy-text-element]","data-copied-text":"Copied"}',
            'effects_provider' => true,
            'layout_div_box_shadow_dimensions' => '!0em 0em 0em 0em',
            'layout_div_flex_align' => 'center',
            'layout_div_flex_direction' => 'row',
            'layout_div_flex_gap' => '1em',
            'layout_div_flex_justify' => 'center',
            'layout_div_flexbox' => true,
            'layout_div_href' => 'javascript:void(0)',
            'layout_div_margin' => '!0px',
            'layout_div_padding' => '!0px',
            'layout_div_tag' => 'a',
            '_modules' => [
              [
                '_type' => 'text',
                '_bp_base' => '4_4',
                'custom_atts' => '{"data-copy-text-element":""}',
                'text_content' => 'Copy',
                'text_text_color' => '{{dc:p:header.textColor.base}}',
                'text_text_color_alt' => '{{dc:p:header.textColor.alt}}',
              ],
              [
                '_type' => 'button',
                '_bp_base' => '4_4',
                'anchor_bg_color' => 'transparent',
                'anchor_border_radius' => '!0.35em',
                'anchor_box_shadow_dimensions' => '!0em 0.15em 0.65em 0em',
                'anchor_graphic' => true,
                'anchor_graphic_icon' => 'copy',
                'anchor_graphic_icon_color' => '{{dc:p:header.textColor.base}}',
                'anchor_graphic_icon_color_alt' => '{{dc:p:header.textColor.alt}}',
                'anchor_text' => false,
              ]
            ]
          ]
        ]
      ],
      [
        '_type' => 'code-block',
        '_bp_base' => '4_4',
        'code' => '{{dc:p:code.code}}',
        'color_scheme' => '{{dc:p:code.colorScheme}}',
        'id' => '{{dc:p:setup.id}}',
        'language' => '{{dc:p:code.language}}',
        'tab_size' => '{{dc:p:code.tabSize}}',
      ]
    ]
  ],
]);
