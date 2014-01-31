<?php

// Code from http://wordpress.stackexchange.com/questions/90505/how-to-enable-suggested-edits


// Update Title
'' !== wp_text_diff(
	$el['post_title'],
	$GLOBALS['post']->post_title
)
	AND $GLOBALS['post']->post_title = $el['post_title'];
// Update Content
'' !== wp_text_diff(
	$el['post_content'],
	$GLOBALS['post']->post_content
)
	AND $GLOBALS['post']->post_content = $el['post_content'];
// Update author
$GLOBALS['post']->post_author !== $el['post_author']
	AND $GLOBALS['post']->post_author = $el['post_author'];



<?php
// Add it for logged in users and guests:
add_action( 'comment_form_logged_in_after', 'wpse_proposed_edit_textarea' );
add_action( 'comment_form_after_fields', 'wpse_proposed_edit_textarea' );
function wpse_proposed_edit_textarea()
{
	?>
	<p class="comment-form-title">
		<label for="wpse_propsed_edit">
			<?php _e( 'Propose Edit', 'your_textdomain' ); ?>
		</label>
		<textarea name="wpse_propsed_edit" id="wpse_propsed_edit">
			<?php the_content(); ?>
		</textarea>
	</p>
	<input type="hidden" name="comment_approved" id="comment_approved" value="0" />
	<?php
}





function wpse_add_proposed_edits_admin_page()
{
	add_menu_page(
		'Proposed Edits',
		'Suggested Edits',
		'activate_plugins',
		'proposed_edits',
		'wpse_proposed_edits_page_cb'
	);
}
add_action( 'admin_menu', 'wpse_add_proposed_edits_admin_page' );

function wpse_proposed_edits_page_cb()
{
	$proposed_edits_table = new WP_Proposed_Edits_Table();
	$proposed_edits_table->prepare_items(); 
	$proposed_edits_table->display(); 
}

class WP_Proposed_Edits_Table extends WP_List_Table
{
	// Override List table default logic in here
}
