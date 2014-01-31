<?php
global $post;
$saved_priority = get_post_meta($post->ID, 'priority', true);
?>
<label>
    <?php _e('Priority', ReallySimpleIssueTracker::HANDLE) ?>:
    <select name="priority">
        <option value="0">
            -- <?php _e('Select priority', ReallySimpleIssueTracker::HANDLE)?> --
        </option>
        <?php for($i=1;$i<=10;$i++): ?>
            <option value="<?php echo $i ?>" <?php echo $saved_priority == $i ? 'selected="selected"' : '' ?>>
                <?php echo $i ?>
                <?php echo $i == 1 ? ' ('.__('highest',ReallySimpleIssueTracker::HANDLE).')' : ''; ?>
                <?php echo $i == 10 ? ' ('.__('lowest',ReallySimpleIssueTracker::HANDLE).')' : ''; ?>
            </option>
        <?php endfor; ?>
    </select>
    <?php wp_nonce_field('nonce_priority', 'nonce_priority'); ?>
</label>