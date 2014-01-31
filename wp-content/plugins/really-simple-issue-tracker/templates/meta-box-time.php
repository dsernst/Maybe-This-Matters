<?php
global $post;
$original_estimate = get_post_meta($post->ID, 'original_estimate', true);
$time_spent = get_post_meta($post->ID, 'time_spent', true);

$original_estimate_minutes = ReallySimpleIssueTracker::convertEstimatedTimeStringToMinutes($original_estimate);
$time_remaining = $original_estimate_minutes - ReallySimpleIssueTracker::convertEstimatedTimeStringToMinutes($time_spent);
$time_remaining = $time_remaining < 0 ? 0 : $time_remaining;
$time_remaining = ReallySimpleIssueTracker::convertMinutesToEstimatedTimeString($time_remaining);
?>
<p class="howto"><?php _e('Enter time in hours and minutes.',ReallySimpleIssueTracker::HANDLE); ?></p>
<p>
    <label>
        <?php _e('Original estimate', ReallySimpleIssueTracker::HANDLE) ?>:
        <input type="text" name="original_estimate" size="8" placeholder="ex: 1h 30m" value="<?php echo $original_estimate != '' ? $original_estimate : '' ?>"/>
        <?php wp_nonce_field('nonce_original_estimate','nonce_original_estimate') ?>
    </label>
</p>
<p>
    <label>
        <?php _e('Time spent', ReallySimpleIssueTracker::HANDLE) ?>:
        <input type="text" name="time_spent" size="8" placeholder="ex: 45m" value="<?php echo $time_spent != '' ? $time_spent : '' ?>"/>
        <?php wp_nonce_field('nonce_time_spent','nonce_time_spent') ?>
    </label>
</p>
<p>
    <?php _e('Time remaining', ReallySimpleIssueTracker::HANDLE) ?>:
    <span id="time_remaining"><strong><?php echo $time_remaining ?></strong></span>
</p>