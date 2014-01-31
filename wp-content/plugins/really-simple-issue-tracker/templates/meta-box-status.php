<?php
$status_types = ReallySimpleIssueTracker_Status::getDefaultStatusTypes();
/* @var $type ReallySimpleIssueTracker_Status */
global $post;
$saved_status = get_post_meta($post->ID, 'issue_status', true);
?>

<label>
    <?php _e('Select status', ReallySimpleIssueTracker::HANDLE) ?>:
    <select name="issue_status">
        <?php foreach($status_types as $type): ?>
        <option value="<?php echo $type->getId(); ?>" <?php echo $saved_status == $type->getId() ? 'selected="selected"' : '' ?>><?php echo $type->getName(); ?></option>
        <?php endforeach; ?>
    </select>
    <?php wp_nonce_field('nonce_issue_status','nonce_issue_status') ?>
</label>