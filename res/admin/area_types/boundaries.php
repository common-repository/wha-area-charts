<?php
$whaac_boundaries_dataname = get_post_meta($post->ID, 'whaac_boundaries_dataname', true);
$whaac_boundaries_color = get_post_meta($post->ID, 'whaac_boundaries_color', true);
$whaac_boundaries_appearance = get_post_meta($post->ID, 'whaac_boundaries_appearance', true);
$whaac_boundaries_fill = get_post_meta($post->ID, 'whaac_boundaries_fill', true);
$whaac_boundaries_labels_check = get_post_meta($post->ID, 'whaac_boundaries_labels_check', true);
$whaac_boundaries_data = get_post_meta($post->ID, 'whaac_boundaries_data', true);
$whaac_boundaries_x_labels = get_post_meta($post->ID, 'whaac_boundaries_x_labels', true);
$whaac_grid_lines = get_post_meta($post->ID, 'whaac_grid_lines', true);
// // Default data's for first activation
$whaac_default_data = [array(
    'key' => '1',
    'value' => 'val 1'
), array(
    'key' => '2',
    'value' => 'val 2'
), array(
    'key' => '3',
    'value' => 'val 3'
), array(
    'key' => '-4',
    'value' => 'val -4'
), array(
    'key' => '5',
    'value' => 'val 5'
), array(
    'key' => '6',
    'value' => 'val 6'
)];
$whaac_default_x_labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];


$html = '';

$fail = '';

$fail .= '<h1>Sorry, but this chart does not exist.</h1><h4>Check your shortcode.</h4>';


$html .= '<div class="chart_preview">';
$html .= '<p>' . __('Preview:') . '</p>';
$html .= '<div class="wrapper col-2">';
$html .= '<canvas id="boundaries"></canvas>';
$html .= '</div>';

$html .= '<div class="toolbar">';
$html .= '<ul class="tabs-nav">';
$html .= '<li class=""><a href="#tab-1" rel="nofollow">' . __('Main:') . '</a></li>';
$html .= '<li class="tab-active"><a href="#tab-2" rel="nofollow">' . __('Settings') . '</a></li>';
$html .= '</ul>';

$html .= '<div class="tabs-stage">';
$html .= '<div id="tab-1" style="display: none;">';
$html .= '<div class="whaac_field boundaries_name">';
$html .= '<label><span>' . __('Name:') . ' </span><input type="text" name="whaac_boundaries_dataname" class="whaac_boundaries_dataname" value="' . (!empty($whaac_boundaries_dataname) ? "$whaac_boundaries_dataname" : "Area Name") . '"></label>';
$html .= '</div>';

$html .= '<form method="post" action="#">';
$html .= '<div class="whaac_flex">';

$html .= '<div style="padding-right: 25px; border-right: 1px solid #c6c9cd;">';
$html .= ' <label>' . __('X-Labels:') . ' </label>';
$html .= ' <fieldset id="x_boundaries_labels">';
$html .= '</fieldset>';
$html .= '<button id="add_boundaries_x_labels">' . __('Add:') . ' <i class="fa fa-plus"></i></button>';
$html .= '</div>';

$html .= '<div style="padding-left: 25px;">';
$html .= '<div style="display: flex;">';
$html .= '<label style="width: 162px;" class="whaac_y_val">' . __('Y-Values:') . ' </label>';
$html .= '<label style="width: 162px;" class="whaac_y_label">' . __('Y-Labels:') . ' </label>';
$html .= '</div>';
$html .= '<fieldset id="boundaries_data">';
$html .= '</fieldset>';

$html .= '<button id="add_boundaries_y_labels">' . __('Add Labels:') . ' <i class="fa fa-plus"></i></button>';
$html .= '<button id="add_boundaries_data">' . __('Add:') . ' <i class="fa fa-plus"></i></button>';

$html .= '<input type="checkbox" class="whaac_boundaries_labels_check" name="whaac_boundaries_labels_check" ' . ($whaac_boundaries_labels_check == "on" ? "checked" : "") . '>';
$html .= '<input type="checkbox" class="whaac_boundaries_labels_check" name="whaac_boundaries_labels_check" ' . ($whaac_boundaries_labels_check == "on" ? "checked" : "") . '>';

$html .= '</div>';
$html .= '</div>';
$html .= '</form>';
$html .= '</div>';

$html .= '<div id="tab-2" style="display: block;">';
$html .= ' <div>';
$html .= '<h3>' . __('Chart Color') . '</h3>';

$html .= '<input value="' . (!empty($whaac_boundaries_color) ? "$whaac_boundaries_color" : "") . '" name="whaac_boundaries_color" class="whaac_boundaries_color jscolor {width:243, height:150, position:\'right\',
                    borderColor:\'#FFF\', insetColor:\'#FFF\', backgroundColor:\'#666\'}">';

$html .= '</div>';

$html .= '<div>';
$html .= '<h3>' . __('Appearance') . '</h3>';
$html .= '<label style="padding-right: 15px"><input type="radio" value="0" class="whaac_boundaries_appearance" name="whaac_boundaries_appearance" ' . ($whaac_boundaries_appearance == "0" ? "checked" : "") . '>' . __('Acute') . '</label>';

if ($whaac_boundaries_appearance === '') {
    $html .= '<label style="padding-right: 15px"><input type="radio" value="0.4" class="whaac_boundaries_appearance" name="whaac_boundaries_appearance" checked>' . __('Smooth') . '</label>';
} else {
    $html .= '<label style="padding-right: 15px"><input type="radio" value="0.4" class="whaac_boundaries_appearance" name="whaac_boundaries_appearance" ' . ($whaac_boundaries_appearance == "0.4" ? "checked" : "") . '>' . __('Smooth') . '</label>';
}

$html .= '</div>';

$html .= '<div>';
$html .= '<h3>' . __('Fill') . '</h3>';
if ($whaac_boundaries_appearance === '') {
    $html .= '<label style="padding-right: 15px"><input type="radio" value="origin" class="whaac_boundaries_fill" name="whaac_boundaries_fill" checked >' . __('Origin') . '</label>';
} else {
    $html .= '<label style="padding-right: 15px"><input type="radio" value="origin" class="whaac_boundaries_fill" name="whaac_boundaries_fill" ' . ($whaac_boundaries_fill == "origin" ? "checked" : "") . '>' . __('Origin') . '</label>';
}
$html .= '<label style="padding-right: 15px"><input type="radio" value="start" class="whaac_boundaries_fill" name="whaac_boundaries_fill" ' . ($whaac_boundaries_fill == "start" ? "checked" : "") . '>' . __('Start') . '</label>';
$html .= '<label style="padding-right: 15px"><input type="radio" value="end" class="whaac_boundaries_fill" name="whaac_boundaries_fill" ' . ($whaac_boundaries_fill == "end" ? "checked" : "") . '>' . __('End') . '</label>';
$html .= '</div>';

$html .= '<div>';
$html .= '<h3>' . __('Grid Lines?') . '</h3>';
if ($whaac_grid_lines === '') {
    $html .= '<label>' . __('Show Grid Lines?') . ' &nbsp;&nbsp;<input type="checkbox" value="true" class="whaac_grid_lines" name="whaac_grid_lines" checked></label>';
} else {
    $html .= '<label>' . __('Show Grid Lines?') . ' &nbsp;&nbsp;<input type="checkbox" value="true" class="whaac_grid_lines" name="whaac_grid_lines" ' . ($whaac_grid_lines == 'true' ? "checked" : "") . '></label>';
}

$html .= '</div>';

$html .= '</div>';
$html .= '</div>';
$html .= '</div>';
$html .= '</div>';

$html .= '<input name="save" type="submit" class="button button-primary button-large" id="publish" value="Save">';

echo $html;