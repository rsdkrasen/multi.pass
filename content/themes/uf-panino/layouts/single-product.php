<?php
$layout_version = '1.0.0';

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-header.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-header.php');

$main = upfront_create_region(
			array (
  'name' => 'main',
  'title' => 'Main Area',
  'type' => 'wide',
  'scope' => 'local',
  'container' => 'main',
  'position' => 10,
  'allow_sidebar' => true,
),
			array (
  'row' => 140,
  'background_type' => 'image',
  'background_color' => '#c5d0db',
  'version' => '1.0.0',
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
    )),
  )),
  'sub_regions' =>
  array (
    0 => false,
  ),
  'background_style' => 'tile',
  'background_position_y' => '50',
  'background_position_x' => '50',
  'background_image' => '{{upfront:style_url}}/images/single-product/orig_gray-pattern-bg.jpg',
  'background_image_ratio' => 2.2599999999999997868371792719699442386627197265625,
  'background_repeat' => 'repeat',
  'bg_padding_type' => 'varied',
  'top_bg_padding_slider' => 0,
  'top_bg_padding_num' => 0,
  'bottom_bg_padding_slider' => '90',
  'bottom_bg_padding_num' => '90',
  'bg_padding_slider' => 0,
  'bg_padding_num' => 0,
  'background_default' => 'hide',
  'origin_position_y' => '50',
  'origin_position_x' => '50',
  'background_size_percent' => '100',
  'use_background_size_percent' => '',
  'featured_fallback_background_color' => '#ffffff',
  'region_role' => 'main',
)
			);

$main->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1476983056588-1755 upfront-module-spacer',
  'id' => 'module-1476983056588-1755',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1476983056588-1667',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1476983056587-1917',
  'new_line' => true,
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
    ),
    'mobile' =>
    array (
      'col' => 4,
    ),
  ),
));

$main->add_element("PostData", array (
  'columns' => '16',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1467787537272-1394',
  'id' => 'module-1467787537272-1394',
  'options' =>
  array (
    'type' => 'PostDataModel',
    'view_class' => 'PostDataView',
    'has_settings' => 1,
    'class' => 'c24 upost-data-object upost-data-object-post_data',
    'id_slug' => 'post-data',
    'data_type' => 'post_data',
    'preset' => 'woo-product',
    'row' => 40,
    'type_parts' =>
    array (
      0 => 'date_posted',
      1 => 'title',
      2 => 'content',
    ),
    'date_posted_format' => 'F j, Y g:i a',
    'content' => 'content',
    'post-part-date_posted' => '<div class="upostdata-part date_posted">
	Posted on <span class="date">{{date}}</span></div>',
    'post-part-title' => '<div class="upostdata-part title">
	<h1>{{title}}</h1>
</div>
',
    'post-part-content' => '<div class="upostdata-part content">
	{{content}}
</div>',
    'element_id' => 'post-data-object-1467787537271-1215',
    'top_padding_num' => '90',
    'bottom_padding_num' => '0',
    'use_padding' => 'yes',
    'usingNewAppearance' => true,
    'static-date_posted-use-typography' => '',
    'static-date_posted-font-family' => '',
    'static-date_posted-weight' => '',
    'static-date_posted-fontstyle' => ' ',
    'static-date_posted-style' => '',
    'static-date_posted-font-size' => '',
    'static-date_posted-line-height' => '',
    'static-date_posted-font-color' => '',
    'static-title-use-typography' => '',
    'static-title-font-family' => '',
    'static-title-weight' => '',
    'static-title-fontstyle' => ' ',
    'static-title-style' => '',
    'static-title-font-size' => '',
    'static-title-line-height' => '',
    'static-title-font-color' => '',
    'preset_style' => '',
    'calculated_left_indent' => 0,
    'calculated_right_indent' => 0,
    'left_padding_num' => 15,
    'right_padding_num' => 15,
    'lock_padding' => '',
    'theme_preset' => 'true',
    'predefined_date_format' => '0',
    'top_padding_use' => 'yes',
    'top_padding_slider' => '90',
    'bottom_padding_use' => 'yes',
    'bottom_padding_slider' => '0',
    'anchor' => '',
    'current_preset' => 'woo-product',
    'theme_style' => '',
    'breakpoint_presets' =>
    (array)(array(
       'desktop' =>
      (array)(array(
         'preset' => 'woo-product',
      )),
       'tablet' =>
      (array)(array(
         'preset' => 'woo-product-mobile',
      )),
       'mobile' =>
      (array)(array(
         'preset' => 'woo-product-mobile',
      )),
    )),
    'breakpoint' =>
    (array)(array(
       'tablet' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
       'current_property' => 'use_padding',
       'mobile' =>
      (array)(array(
         'use_padding' => 'yes',
      )),
    )),
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 0,
  'hide' => 0,
  'toggle_hide' => 1,
  'wrapper_id' => 'wrapper-1467787553104-1347',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'clear' => true,
      'col' => 12,
      'order' => 1,
    ),
    'mobile' =>
    array (
      'clear' => true,
      'col' => 7,
      'order' => 1,
    ),
    'current_property' =>
    array (
      0 => 'order',
    ),
  ),
  'breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 12,
    ),
    'current_property' =>
    array (
      0 => 'col',
    ),
    'mobile' =>
    array (
      'col' => 7,
    ),
  ),
  'objects' =>
  array (
    0 =>
    array (
      'columns' => '16',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part part-content',
      'view_class' => 'PostDataPartView',
      'part_type' => 'content',
      'wrapper_id' => 'wrapper-1467787537270-1603',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1467787537271-1078',
      'padding_slider' => 15,
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
        ),
        'mobile' =>
        array (
          'col' => 7,
        ),
      ),
      'top_padding_num' => 15,
      'left_padding_num' => 15,
      'right_padding_num' => 15,
      'bottom_padding_num' => 15,
      'lock_padding' => '',
      'row' => 302,
      'current_preset' => 'default',
      'preset' => 'default',
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
        'current_property' =>
        array (
          0 => 'hide',
        ),
        'mobile' =>
        array (
          'col' => 7,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
      ),
    ),
    1 =>
    array (
      'columns' => '24',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'title',
      'wrapper_id' => 'wrapper-1476983486597-1559',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1476983486598-1031',
      'padding_slider' => '15',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => '',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
        ),
        'mobile' =>
        array (
          'col' => 7,
        ),
      ),
      'current_preset' => 'default',
      'preset' => 'default',
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
        'current_property' =>
        array (
          0 => 'hide',
        ),
        'mobile' =>
        array (
          'col' => 7,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
      ),
    ),
    2 =>
    array (
      'columns' => '24',
      'margin_left' => '0',
      'margin_right' => '0',
      'margin_top' => '0',
      'margin_bottom' => '0',
      'class' => 'upfront-post-data-part',
      'view_class' => 'PostDataPartView',
      'part_type' => 'date_posted',
      'wrapper_id' => 'wrapper-1476983698428-1983',
      'type' => 'PostDataPartModel',
      'id_slug' => 'post-data-part',
      'element_id' => 'post-data-part-object-1476983698428-1907',
      'padding_slider' => '15',
      'top_padding_num' => '15',
      'left_padding_num' => '15',
      'right_padding_num' => '15',
      'bottom_padding_num' => '15',
      'lock_padding' => '',
      'use_padding' => 'yes',
      'wrapper_breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
        ),
        'mobile' =>
        array (
          'col' => 7,
        ),
      ),
      'current_preset' => 'default',
      'preset' => 'default',
      'new_line' => true,
      'breakpoint' =>
      array (
        'tablet' =>
        array (
          'col' => 12,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
        'current_property' =>
        array (
          0 => 'hide',
        ),
        'mobile' =>
        array (
          'col' => 7,
          'use_padding' => 'yes',
          'hide' => 0,
        ),
      ),
    ),
  ),
));

$main->add_element("Uspacer", array (
  'columns' => '4',
  'margin_left' => '0',
  'margin_right' => '0',
  'margin_top' => '0',
  'margin_bottom' => '0',
  'class' => 'module-1476983058736-1192 upfront-module-spacer',
  'id' => 'module-1476983058736-1192',
  'options' =>
  array (
    'type' => 'UspacerModel',
    'view_class' => 'UspacerView',
    'class' => 'c24 upfront-object-spacer',
    'has_settings' => 0,
    'id_slug' => 'uspacer',
    'element_id' => 'spacer-object-1476983058736-1170',
    'current_preset' => 'default',
    'preset' => 'default',
  ),
  'row' => 6,
  'sticky' => false,
  'default_hide' => 1,
  'hide' => 0,
  'toggle_hide' => 0,
  'wrapper_id' => 'wrapper-1476983058735-1153',
  'wrapper_breakpoint' =>
  array (
    'tablet' =>
    array (
      'col' => 4,
    ),
    'mobile' =>
    array (
      'col' => 4,
    ),
  ),
));

$regions->add($main);

if (file_exists(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php')) include(get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'global-regions' . DIRECTORY_SEPARATOR . 'main-footer.php');
