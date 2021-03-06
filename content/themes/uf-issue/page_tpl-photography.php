<?php
/**
 * Template Name: Photography Page template
 *
 * @package WordPress
 * @subpackage photography
 */

the_post();
$layout = Upfront_Output::get_layout(array('specificity' => 'single-page-photography'));

get_header();
echo $layout->apply_layout();
get_footer();