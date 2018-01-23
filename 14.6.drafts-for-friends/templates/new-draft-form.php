<?php
/**
 * Drafts for Friends form.
 *
 * Provides the HTML code for the form to add new draft posts to the released posts list.
 *
 * @since      0.1.0
 *
 * @package    WordPress
 * @subpackage drafts-for-friends
 */
?>
<h2><?php _e( 'Release new draft', 'drafts-for-friends' ); ?></h2>

<form method="post">
	<?php wp_nonce_field( 'dff_new_draft' ); ?>
    <input type="hidden" name="action" value="dff_new_draft"/>
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row">
                <label for="post_id"><?php _e( 'Select a new draft', 'drafts-for-friends' ); ?></label>
            </th>
            <td>
                <select id="post_id" name="post_id">
					<?php dff_draft_select_options(); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"></th>
            <td><?php submit_button( __( 'Create Link for this draft', 'drafts-for-friends' ) ); ?></td>
        </tr>
        </tbody>
    </table>
</form>
