<?php
$issue_types = ReallySimpleIssueTracker_IssueType::getDefaultIssueTypes();
/* @var $type ReallySimpleIssueTracker_IssueType */
global $post;
$saved_type = get_post_meta($post->ID, 'issue_type', true);
?>

<label>
    <?php _e('Select type', ReallySimpleIssueTracker::HANDLE) ?>:
    <select name="issue_type">
        <?php foreach($issue_types as $type): ?>
            <option value="<?php echo $type->getId(); ?>" <?php echo $saved_type == $type->getId() ? 'selected="selected"' : '' ?>><?php echo $type->getName(); ?></option>
        <?php endforeach; ?>
    </select>
    <?php wp_nonce_field('nonce_issue_type','nonce_issue_type') ?>
</label>