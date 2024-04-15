<?php

namespace Cornerstone\CodeBlocks\Element;

/**
 * Code block element
 */
$values = cs_compose_values(
  [
    'code' => cs_value( '', 'markup' ),
    'language' => cs_value( 'js', 'markup' ),
  ],
  'omega',
  'omega:custom-atts',
  'omega:looper-provider',
  'omega:looper-consumer'
);



// Render
// =============================================================================

function render( $data ) {

  return cs_tag('pre', [], [], [
    cs_tag( 'code', [ 'class' => 'x-tabs-list' ], $data['code'] ),
  ]);

}



// Controls

function controls() {

  return cs_compose_controls(
    [
      'controls' => [
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
  'builder'    => __NAMESPACE__ . '/controls',
  'render'     => __NAMESPACE__ . '/render',
  'group'      => 'content',
  'options'    => []
] );
