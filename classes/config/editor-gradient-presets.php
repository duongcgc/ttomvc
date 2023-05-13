<?php

/** 
 * Khai báo danh sách màu gradient cho editor
 */

// Editor color gradient.
$black     = '#000000';
$dark_gray = '#28303D';
$gray      = '#39414D';
$green     = '#D1E4DD';
$blue      = '#D1DFE4';
$purple    = '#D1D1E4';
$red       = '#E4D1D1';
$orange    = '#E4DAD1';
$yellow    = '#EEEADD';
$white     = '#FFFFFF';

$editor_gradient_presets = array(
    array(
        'name'     => esc_html__('Purple to yellow', 'twentytwentyone'),
        'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $yellow . ' 100%)',
        'slug'     => 'purple-to-yellow',
    ),
    array(
        'name'     => esc_html__('Yellow to purple', 'twentytwentyone'),
        'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $purple . ' 100%)',
        'slug'     => 'yellow-to-purple',
    ),
    array(
        'name'     => esc_html__('Green to yellow', 'twentytwentyone'),
        'gradient' => 'linear-gradient(160deg, ' . $green . ' 0%, ' . $yellow . ' 100%)',
        'slug'     => 'green-to-yellow',
    ),
    array(
        'name'     => esc_html__('Yellow to green', 'twentytwentyone'),
        'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $green . ' 100%)',
        'slug'     => 'yellow-to-green',
    ),
    array(
        'name'     => esc_html__('Red to yellow', 'twentytwentyone'),
        'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $yellow . ' 100%)',
        'slug'     => 'red-to-yellow',
    ),
    array(
        'name'     => esc_html__('Yellow to red', 'twentytwentyone'),
        'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $red . ' 100%)',
        'slug'     => 'yellow-to-red',
    ),
    array(
        'name'     => esc_html__('Purple to red', 'twentytwentyone'),
        'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $red . ' 100%)',
        'slug'     => 'purple-to-red',
    ),
    array(
        'name'     => esc_html__('Red to purple', 'twentytwentyone'),
        'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $purple . ' 100%)',
        'slug'     => 'red-to-purple',
    ),
);
