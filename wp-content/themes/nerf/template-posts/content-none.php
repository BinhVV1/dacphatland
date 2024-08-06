<?php
/**
 *
 * If no content, include the "No posts found" template.
 * @since 1.0
 * @version 1.0.0
 *
 */
?>
<article id="post-0" class="post no-results not-found">
	<div class="entry-content e-entry-content">
		<h2 class="title-no-results">
			<?php esc_html_e( 'Chưa có dữ liệu cho mục này', 'nerf' ) ?>
		</h2>
		<div><?php esc_html_e( 'Xin Quý khách vui lòng quay lại sau!', 'nerf' ); ?></div>
		<?php #get_search_form(); ?>
	</div>
	<!-- entry-content -->
</article><!-- /article -->