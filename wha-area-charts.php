<?php/** * Plugin Name:       WHA Area Charts * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area. * Version:           1.0.0 * Author:            WHA * Author URI:        http://webhelpagency.com/ * License:           GPL-2.0+ * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt * Text Domain:       areachart * Domain Path:       /languages * * WHA Area chart is free software: you can redistribute it and/or modify * it under the terms of the GNU General Public License as published by * the Free Software Foundation, either version 2 of the License, or * any later version. * * WHA Area chart is distributed in the hope that it will be useful, * but WITHOUT ANY WARRANTY; without even the implied warranty of * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the * GNU General Public License for more details. * * You should have received a copy of the GNU General Public License * along with WHA Area chart. If not, see http://www.gnu.org/licenses/gpl-2.0.txt. */if (!defined('ABSPATH')) {    exit; // Exit if accessed directly}// If this file is called directly, abort.if (!defined('WPINC')) {    die;}define('WHAAC_VERSION', '1.0.0');function whaac_activation(){    global $post;    do_action('whaac_activation');}register_activation_hook(__FILE__, 'whaac_activation');function whaac_deactivation(){    do_action('whaac_deactivation');}register_deactivation_hook(__FILE__, 'whaac_deactivation');add_action('admin_enqueue_scripts', 'whaac_admin_scripts');function whaac_admin_scripts($hook_suffix){    global $post;    if (is_a($post, 'WP_Post') && $post->post_type === 'wha_areachart') {        wp_enqueue_style('wha-areachart-style-admin', plugins_url('res/admin/areachart-admin.css', __FILE__));        wp_enqueue_style('areachart-awesome-css', plugins_url('res/admin/font-awesome/css/font-awesome.min.css', __FILE__));        wp_enqueue_script('chart-min-js', plugins_url('res/admin/Chart.min.js', __FILE__), false, '1.0', true);        wp_enqueue_script('utils-js', plugins_url('res/admin/utils.js', __FILE__), false, '1.0', true);        wp_enqueue_script('charts-settings', plugins_url('res/admin/boundaries-charts-settings.js', __FILE__), false, '1.0', true);        wp_enqueue_script('jscolor', plugins_url('res/admin/jscolor.js', __FILE__), false, '1.0', true);        wp_enqueue_script('areachart-admin', plugins_url('res/admin/areachart-admin.js', __FILE__), false, '1.0', true);        wp_localize_script('charts-settings', 'areacharts_vars_admin', array(            'whaac_boundaries_dataname' => get_post_meta($post->ID, 'whaac_boundaries_dataname', true),            'whaac_boundaries_color' => get_post_meta($post->ID, 'whaac_boundaries_color', true),            'whaac_boundaries_appearance' => get_post_meta($post->ID, 'whaac_boundaries_appearance', true),            'whaac_boundaries_fill' => get_post_meta($post->ID, 'whaac_boundaries_fill', true),            'whaac_boundaries_data' => get_post_meta($post->ID, 'whaac_boundaries_data', true),            'whaac_boundaries_x_labels' => get_post_meta($post->ID, 'whaac_boundaries_x_labels', true),            'whaac_boundaries_y_labels' => get_post_meta($post->ID, 'whaac_boundaries_y_labels', true),            'whaac_implode_data' => get_post_meta($post->ID, 'whaac_implode_data', true),            'whaac_grid_lines' => get_post_meta($post->ID, 'whaac_grid_lines', true),            'whaac_default_implode_data' => [array(                'key' => '1',                'value' => 'val 1'            ), array(                'key' => '2',                'value' => 'val 2'            ), array(                'key' => '3',                'value' => 'val 3'            ), array(                'key' => '-4',                'value' => 'val -4'            ), array(                'key' => '5',                'value' => 'val 5'            ), array(                'key' => '6',                'value' => 'val 6'            )], // default data, if fields empty            'whaac_default_x_labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], // default data, if fields empty            'whaac_default_data' => ['1', '2', '3', '-4', '5', '6'], // default data, if fields empty        ));    }}add_action('wp_enqueue_scripts', 'whaac_scripts');function whaac_scripts() //register scripts and style{    global $post;    wp_enqueue_media();    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'game-areachart')) { //include scripts/style only on pages with shortcode        wp_enqueue_style('wha-charts-style', plugins_url('res/styles.css', __FILE__));;        wp_enqueue_script('wha-utils-script', plugins_url('res/utils.js', __FILE__), true, true, true);        wp_enqueue_script('wha-chart-script', plugins_url('res/Chart.min.js', __FILE__), true, true, true);        wp_enqueue_script('wha-areachart', plugins_url('res/areachart.js', __FILE__), true, true, true);    }}add_action('init', 'whaac_register_post_type');function whaac_register_post_type() // create post type{    $labels = array(        'name' => __('Area Charts', 'areacharts'),        'menu_name' => __('Area Chart', 'areacharts'),        'singular_name' => __('Area Chart', 'areacharts'),        'name_admin_bar' => _x('Area Chart', 'name admin bar', 'areacharts'),        'all_items' => __('All Charts', 'areacharts'),        'search_items' => __('Search  Area Chart', 'areacharts'),        'add_new' => _x('Add New', 'areacharts'),        'add_new_item' => __('Add New Area Chart', 'areacharts'),        'new_item' => __('New  Area Chart', 'areacharts'),        'view_item' => __('View  Area Chart', 'areacharts'),        'edit_item' => __('Edit  Area Chart', 'areacharts'),        'not_found' => __('No Chart Found.', 'areacharts'),        'not_found_in_trash' => __('Area Charts not found in Trash.', 'areacharts'),        'parent_item_colon' => __('Parent Area Chart', 'areacharts'),    );    $args = array(        'labels' => $labels,        'description' => __('Holds the Area Chart and their data.', 'areacharts'),        'menu_position' => 5,        'menu_icon' => 'dashicons-chart-area',        'public' => true,        'publicly_queryable' => false,        'show_ui' => true,        'show_in_menu' => true,        'query_var' => true,        'capability_type' => 'post',        'has_archive' => true,        'hierarchical' => false,        'supports' => array('title'),    );    register_post_type('wha_areachart', $args);}add_filter('the_content', 'whaac_create_page');function whaac_create_page($content) // create plugin page{    global $post;    if ('wha_areachart' !== $post->post_type) {        return $content;    }    if (!is_single()) {        return $content;    }    $areachart_html = whaac_game_return(array('id' => $post->ID));    return $areachart_html . $content;}function whaac_game_return($atts){    if (!isset($atts['id'])) {        return false;    }    $id = $atts['id'];    wp_localize_script('wha-areachart', 'my_ajax_object', array(        'ajax_url' => admin_url('admin-ajax.php'),        'whaac_boundaries_dataname' => get_post_meta($id, 'whaac_boundaries_dataname', true),        'whaac_boundaries_color' => get_post_meta($id, 'whaac_boundaries_color', true),        'whaac_boundaries_appearance' => get_post_meta($id, 'whaac_boundaries_appearance', true),        'whaac_boundaries_fill' => get_post_meta($id, 'whaac_boundaries_fill', true),        'whaac_boundaries_data' => get_post_meta($id, 'whaac_boundaries_data', true),        'whaac_boundaries_x_labels' => get_post_meta($id, 'whaac_boundaries_x_labels', true),        'whaac_boundaries_y_labels' => get_post_meta($id, 'whaac_boundaries_y_labels', true),        'whaac_implode_data' => get_post_meta($id, 'whaac_implode_data', true),        'whaac_grid_lines' => get_post_meta($id, 'whaac_grid_lines', true),    ));    $html = '<div class="wrapper col-2"><canvas width="500" height="256" id="boundaries"></canvas></div>';    $error = '<h2 style="color: #2196F3;">Sorry, but this chart does not exist.</h2>';    if (!empty(get_post_meta($id, 'whaac_boundaries_data', true)) && !empty(get_post_meta($id, 'whaac_implode_data', true))) {        return $html;    } else {        return $error;    }}add_shortcode('game-areachart', 'whaac_game_return');add_action('add_meta_boxes', 'whaac_custom_box_shortcode', 1);function whaac_custom_box_shortcode() //add shortcode box{    $screens = array('wha_areachart');    add_meta_box(' whaac_sectionid_shortcode', 'Shortcode:', 'whaac_meta_box_shortcode_callback', $screens, 'advanced', 'high');}function whaac_meta_box_shortcode_callback($post, $meta) //create shortcode{    wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');    echo '<div class="wha-tooltip" style="cursor: pointer; width: max-content">          <span class="wha-shortcode">[game-areachart id="' . $post->ID . '" ]</span>          <textarea class="js-copytextarea" >[game-areachart id="' . $post->ID . '" ]</textarea>          <span class="wha-tooltiptext">Copied!</span>          </div>';}add_action('add_meta_boxes', 'whaac_options_box', 1);function whaac_options_box() // Add Areachart option box{    $screens = array('wha_areachart');    add_meta_box('whaac_sectionid_options_box', __('Area Charts:', 'wha_areacharts'), 'whaac_meta_box_callback', $screens, 'advanced', 'high');}function whaac_meta_box_callback($post, $meta) // Call Areachart option fields and save{    define('PLUGIN_DIR', dirname(__FILE__) . '/');    /* Start Preview */    include "res/admin/area_types/boundaries.php"; // get boundaries area chart}// Saving individual optionsadd_action('save_post', 'whaac_save_postdata');function whaac_save_postdata($post_id) // Save Postdata function{    if (!wp_verify_nonce($_POST['myplugin_noncename'], plugin_basename(__FILE__)))        return;    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)        return;    if (!current_user_can('edit_post', $post_id))        return;    if (isset($_POST['whaac_boundaries_dataname']) && !empty($_POST['whaac_boundaries_dataname'])) {        $whaac_boundaries_dataname = preg_replace("([!@#ё%^&$*{}()/_+.,;:|\\\d+~`><?])", "", $_POST['whaac_boundaries_dataname']);  //Area Name    }    if (isset($_POST['whaac_boundaries_x_labels']) && !empty($_POST['whaac_boundaries_x_labels'])) {        $whaac_boundaries_x_labels = preg_replace("([!@#ё%^&$*{}()/_+.,;:|\\\d+~`><?])", "", $_POST['whaac_boundaries_x_labels']); // X Labels    }    if (isset($_POST['whaac_boundaries_y_labels']) && !empty($_POST['whaac_boundaries_y_labels'])) {        $whaac_boundaries_y_labels = preg_replace("([!@#ё%^&$*{}()/.,_+;:|\\\d+~`><?])", "", $_POST['whaac_boundaries_y_labels']); // Y Labels    }    if (isset($_POST['whaac_boundaries_data']) && !empty($_POST['whaac_boundaries_data'])) {        $whaac_boundaries_data = preg_replace("([A-z!@#ё%^&$*{}()/_.,+;:|\\\d+~`><?])", "", $_POST['whaac_boundaries_data']); // Data Value    }    if (isset($_POST['whaac_boundaries_color']) && !empty($_POST['whaac_boundaries_color'])) {        $whaac_boundaries_color = preg_replace("([!@#%^ё&$*{}()/_.,+;:|\\\d+~`><?])", "", $_POST['whaac_boundaries_color']); // Area Color    }    if (isset($_POST['whaac_boundaries_appearance']) && !empty($_POST['whaac_boundaries_appearance'])) {        $whaac_boundaries_appearance = $_POST['whaac_boundaries_appearance']; // Area Appearance    }    if (isset($_POST['whaac_boundaries_fill']) && !empty($_POST['whaac_boundaries_fill'])) {        $whaac_boundaries_fill = $_POST['whaac_boundaries_fill']; // Area Fill    }    if (isset($_POST['whaac_boundaries_labels_check']) && !empty($_POST['whaac_boundaries_labels_check'])) {        $whaac_boundaries_labels_check = $_POST['whaac_boundaries_labels_check']; // Add Labels Checkbox value    }    if (isset($_POST['whaac_grid_lines']) && !empty($_POST['whaac_grid_lines'])) {        $whaac_grid_lines = $_POST['whaac_grid_lines']; // Add Labels Checkbox value    }    for ($i = 0; $i < count($whaac_boundaries_data); $i++) { // Sorting Data Value's        $data_arr = $whaac_boundaries_data[$i];        $data_array[] = $data_arr;    }    for ($i = 0; $i < count($whaac_boundaries_x_labels); $i++) { // Sorting X Labels        $x_labels_arr = $whaac_boundaries_x_labels[$i];        $x_labels_array[] = $x_labels_arr;    }    for ($i = 0; $i < count($whaac_boundaries_y_labels); $i++) { // Sorting Y Labels        $y_labels_arr = $whaac_boundaries_y_labels[$i];        $y_labels_array[] = $y_labels_arr;    }    if (!empty($data_array)) {  // Crate implode data from Data Value's and Y Labels        $i = 0;        $items = array();        foreach ($data_array as $item) {            $items[] = array(                'key' => $item,                'value' => $y_labels_array[$i]            );            $i++;        }        $whaac_implode_data = $items;    }    $json_data = json_encode($data_array, JSON_UNESCAPED_UNICODE);    $json_x_labels = json_encode($x_labels_array, JSON_UNESCAPED_UNICODE);    $json_y_labels = json_encode($y_labels_array, JSON_UNESCAPED_UNICODE);    update_post_meta($post_id, 'whaac_boundaries_dataname', $whaac_boundaries_dataname);    update_post_meta($post_id, 'whaac_boundaries_fill', $whaac_boundaries_fill);    update_post_meta($post_id, 'whaac_boundaries_color', $whaac_boundaries_color);    update_post_meta($post_id, 'whaac_boundaries_appearance', $whaac_boundaries_appearance);    update_post_meta($post_id, 'whaac_boundaries_data', $json_data);    update_post_meta($post_id, 'whaac_boundaries_x_labels', $json_x_labels);    update_post_meta($post_id, 'whaac_boundaries_y_labels', $json_y_labels);    update_post_meta($post_id, 'whaac_implode_data', $whaac_implode_data);    update_post_meta($post_id, 'whaac_boundaries_labels_check', $whaac_boundaries_labels_check);    update_post_meta($post_id, 'whaac_grid_lines', $whaac_grid_lines);}function whaac_sidebar_meta_box(){    add_meta_box(        'whaac_sidebar',        __('&nbsp;', 'myplugin_textdomain'),        'whaac_sidebar_meta_box_callback',        'wha_areachart',        'side'    );}add_action('add_meta_boxes', 'whaac_sidebar_meta_box', 2);function whaac_sidebar_meta_box_callback($post, $meta) // Call Areachart option fields and save{    $item = '';    $item .= '<h1>Plugin Developed by</h1>';    $item .= '<div class="whaac_logo_wrap"><img src="' . plugins_url("res/admin/images/wha-logo.svg", __FILE__) . '" width="10px" alt="wha_logo"></div>';    $item .= '<h2><wha>WHA</wha> is team of  top-notch WordPress developers.</h2>';    $item .= '<h4>Our advantages:</h4>';    $item .= '              <ul class="whaac_sidebar_list">                <li><wha>—</wha> TOP 20 WordPress companies on Clutch;</li>                <li><wha>—</wha> More than 4 years of experience;</li>                <li><wha>—</wha> NDA for each project;</li>                <li><wha>—</wha> Dedicate project manager for each project;</li>                <li><wha>—</wha> Flexible working hours;</li>                <li><wha>—</wha> Friendly management;</li>                <li><wha>—</wha> Clear workflow;</li>                <li><wha>—</wha> Based in Europe, you can easily reach us via any airlines;</li>            </ul>';    $item .= '<h3>Looking for dedicated team?</h3>';    $item .= '  <a href="https://webhelpagency.com/say-hello/?title=wporg_free_consultation" class="btn btn-reverse btn-arrow"><span>Start a Project<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 36.1 25.8" enable-background="new 0 0 36.1 25.8" xml:space="preserve"><g><line fill="none" stroke="#FFFFFF" stroke-width="3" stroke-miterlimit="10" x1="0" y1="12.9" x2="34" y2="12.9"></line><polyline fill="none" stroke="#FFFFFF" stroke-width="3" stroke-miterlimit="10" points="22.2,1.1 34,12.9 22.2,24.7   "></polyline></g></svg></span></a>';    echo $item;}