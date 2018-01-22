<?php
/**
 * Drafts for Friends released posts list.
 *
 * Outputs HTML code to list all released posts in a table.
 *
 * @since      0.1.0
 *
 * @package    WordPress
 * @subpackage drafts-for-friends
 */
?>
<h2><?php _e( 'Current released posts', 'drafts-for-friends' ); ?></h2>

<table class="wp-list-table widefat">
    <thead>
    <tr>
        <th><?php _e( 'Post title', 'drafts-for-friends' ); ?></th>
        <th><?php _e( 'Link', 'drafts-for-friends' ); ?></th>
        <th><?php _e( 'Options', 'drafts-for-friends' ); ?></th>
    </tr>
    </thead>
    <tbody>
	<?php
	$query = new WP_Query( array(
		'post_type'      => 'post',
		'post_status'    => 'draft',
		'posts_per_page' => - 1,
		'meta_query'     => array(
			array(
				'key'     => 'dff_key',
				'compare' => 'EXISTS',
			),
		),
	) );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$link = get_post_permalink();
			$link = add_query_arg( array( 'dff_key' => get_post_field( 'dff_key' ) ), $link );
			?>
            <tr>
                <td><?php esc_html_e( get_the_title() ); ?></td>
                <td><?php
					printf(
						'<a href="%s" target="_blank">%s</a>',
						esc_url( $link ),
						esc_html( $link )
					);
					?></td>
                <td><?php // @todo: Add an option to delete a released post. ?></td>
            </tr>
			<?php
		}
	} else {
		?>
        <tr>
            <td colspan="3"><?php _e( 'No posts found.', 'drafts-for-friends' ); ?></td>
        </tr>
		<?php
	}

	?>
    </tbody>
</table>