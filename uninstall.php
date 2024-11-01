<?php

// if uninstall.php is not called by WordPress, die

if( ! defined('WP_UNINSTALL_PLUGIN') )

    exit;

foreach ( wp_load_alloptions() as $option => $value ) {
    if ( strpos( $option, 'whaac_' ) === 0 ) {
        delete_option( $option );
    }
}

global $wpdb;
$cptName = 'wha_areachart';
$tablePostMeta = $wpdb->prefix . 'postmeta';
$tablePosts = $wpdb->prefix . 'posts';

$postDeleteQuery = "DELETE FROM $tablePosts WHERE post_type='$cptName'";

$postMetaDeleteQuery = "DELETE FROM $tablePostMeta".
    " WHERE post_id IN".
    " (SELECT id FROM $tablePosts WHERE post_type='$cptName'";

$wpdb->query("DELETE FROM $tablePostMeta WHERE meta_key = 'whaac_boundaries_dataname'");
$wpdb->query("DELETE FROM $tablePostMeta WHERE meta_key = 'whaac_boundaries_fill'");
$wpdb->query("DELETE FROM $tablePostMeta WHERE meta_key = 'whaac_boundaries_color'");
$wpdb->query("DELETE FROM $tablePostMeta WHERE meta_key = 'whaac_boundaries_appearance'");
$wpdb->query("DELETE FROM $tablePostMeta WHERE meta_key = 'whaac_boundaries_data'");
$wpdb->query("DELETE FROM $tablePostMeta WHERE meta_key = 'whaac_boundaries_x_labels'");
$wpdb->query("DELETE FROM $tablePostMeta WHERE meta_key = 'whaac_boundaries_y_labels'");
$wpdb->query("DELETE FROM $tablePostMeta WHERE meta_key = 'whaac_implode_data'");
$wpdb->query("DELETE FROM $tablePostMeta WHERE meta_key = 'whaac_boundaries_labels_check'");
$wpdb->query("DELETE FROM $tablePostMeta WHERE meta_key = 'whaac_grid_lines'");

$wpdb->query($postMetaDeleteQuery);
$wpdb->query($postDeleteQuery);