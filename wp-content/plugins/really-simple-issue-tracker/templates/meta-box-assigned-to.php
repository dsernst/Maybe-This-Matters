<?php
$all_authors = get_users();
global $post;
$saved_assignee = get_post_meta($post->ID, 'assigned_to', true);
?>

<label>
    <?php _e('Assigned to', ReallySimpleIssueTracker::HANDLE) ?>:
    <select name="assigned_to">
        <option value="">
            -- <?php _e('Unassigned', ReallySimpleIssueTracker::HANDLE)?> --
        </option>
        <?php foreach($all_authors as $author): ?>
            <option value="<?php echo $author->ID ?>" <?php echo $saved_assignee == $author->ID ? 'selected="selected"' : '' ?>><?php echo $author->user_nicename ?></option>
        <?php endforeach; ?>
    </select>
    <?php wp_nonce_field('nonce_assigned_to','nonce_assigned_to') ?>
</label>
