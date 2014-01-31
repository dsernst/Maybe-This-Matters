<?php
/**
 * Save post meta-boxes actions
 * ----------------------------
 */
// Meta-box: Assigned to
add_action('save_post','save_meta_box_assigned_to');
function save_meta_box_assigned_to($post_id) {
    if(count($_POST) > 0) {
        if(wp_verify_nonce($_POST['nonce_assigned_to'],'nonce_assigned_to') && isset($_POST['assigned_to']) && $_POST['assigned_to'] != '') {
            update_post_meta($post_id, 'assigned_to', $_POST['assigned_to']);
        } else {
            delete_post_meta($post_id, 'assigned_to');
        }
    }
}
// Meta-box: Priority
add_action('save_post','save_meta_box_priority');
function save_meta_box_priority($post_id) {
    if(count($_POST) > 0) {
        if(wp_verify_nonce($_POST['nonce_priority'],'nonce_priority') && isset($_POST['priority']) && $_POST['priority'] != '') {
            update_post_meta($post_id, 'priority', $_POST['priority']);
        } else {
            delete_post_meta($post_id, 'priority');
        }
    }
}
// Meta-box: Type
add_action('save_post','save_meta_box_type');
function save_meta_box_type($post_id) {
    if(count($_POST) > 0) {
        if(wp_verify_nonce($_POST['nonce_issue_type'],'nonce_issue_type') && isset($_POST['issue_type'])) {
            update_post_meta($post_id, 'issue_type', $_POST['issue_type']);
        } else {
            delete_post_meta($post_id, 'issue_type');
        }
    }
}
// Meta-box: Status
add_action('save_post','save_meta_box_status');
function save_meta_box_status($post_id) {
    if(count($_POST) > 0) {
        if(wp_verify_nonce($_POST['nonce_issue_status'],'nonce_issue_status') && isset($_POST['issue_status'])) {
            update_post_meta($post_id, 'issue_status', $_POST['issue_status']);
        } else {
            delete_post_meta($post_id, 'issue_status');
        }
    }
}

// Meta-box: Time
add_action('save_post','save_meta_box_time');
function save_meta_box_time($post_id) {
    if(count($_POST) > 0) {
        if(wp_verify_nonce($_POST['nonce_original_estimate'],'nonce_original_estimate') && isset($_POST['original_estimate'])) {
            update_post_meta($post_id, 'original_estimate', $_POST['original_estimate']);
        } else {
            delete_post_meta($post_id, 'original_estimate');
        }

        if(wp_verify_nonce($_POST['nonce_time_spent'],'nonce_time_spent') && isset($_POST['time_spent'])) {
            update_post_meta($post_id, 'time_spent', $_POST['time_spent']);
        } else {
            delete_post_meta($post_id, 'time_spent');
        }
    }
}