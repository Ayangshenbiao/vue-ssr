<?php
// Template Name: FAQs
get_header(); ?>

<div id="content" class="fusion-faqs" <?php Avada()->layout->add_style( 'content_style' ); ?>>
<?php
	// Get the content of the faq page itself
	while ( have_posts() ): the_post();

		ob_start();
		post_class();
		$post_classes = ob_get_clean();

		echo sprintf( '<div id="post-%s" %s>', get_the_ID(), $post_classes );
			// Get rich snippets of the faq page
			echo avada_render_rich_snippets_for_pages();

			// Get featured images of the faq page
			echo avada_featured_images_for_pages();

			// Render the content of the faq page
			echo '<div class="post-content">';
				the_content();
				avada_link_pages();
			echo '</div>';
		echo '</div>';
	endwhile;

	// Check if the post is password protected
	if ( ! post_password_required( $post->ID ) ) {

		// Get faq terms
		$faq_terms = get_terms( 'faq_category' );

		// Check if we should display filters
		if ( Avada()->settings->get( 'faq_filters' ) != 'no' &&
			 $faq_terms
		) {

			echo '<ul class="fusion-filters clearfix">';

				// Check if the "All" filter should be displayed
				if ( Avada()->settings->get( 'faq_filters' ) == 'yes' ) {
					echo sprintf( '<li class="fusion-filter fusion-filter-all fusion-active"><a data-filter="*" href="#">%s</a></li>', apply_filters( 'avada_faq_all_filter_name', __( 'All', 'Avada' ) ) );

					$first_filter = FALSE;
				} else {
					$first_filter = TRUE;
				}

				// Loop through the terms to setup all filters
				foreach ( $faq_terms as $faq_term ) {
					// If the "All" filter is disabled, set the first real filter as active
					if ( $first_filter ) {
						echo sprintf( '<li class="fusion-filter fusion-active"><a data-filter=".%s" href="#">%s</a></li>', urldecode( $faq_term->slug ), $faq_term->name );

						$first_filter = FALSE;
					} else {
						echo sprintf( '<li class="fusion-filter fusion-hidden"><a data-filter=".%s" href="#">%s</a></li>', urldecode( $faq_term->slug ), $faq_term->name );
					}
				}

			echo '</ul>';
		}
		?>
		<div class="fusion-faqs-wrapper">
			<div class="accordian fusion-accordian">
				<div class="panel-group" id="accordian-one">
				<?php
					$args = array(
						'post_type' => 'avada_faq',
						'posts_per_page' => -1
					);
					$faq_items = new WP_Query( $args );
					$count = 0;
					while ( $faq_items->have_posts() ): $faq_items->the_post();
						$count++;

						//Get all terms of the post and it as classes; needed for filtering
						$post_classes = '';
						$post_terms = get_the_terms( $post->ID, 'faq_category' );
						if ( $post_terms ) {
							foreach ( $post_terms as $post_term ) {
								$post_classes .= urldecode( $post_term->slug ) . ' ';
							}
						}
						?>

						<div class="fusion-panel panel-default fusion-faq-post <?php echo $post_classes; ?>">
							<?php // get the rich snippets for the post
							echo avada_render_rich_snippets_for_pages(); ?>
							<div class="panel-heading">
								<h4 class="panel-title toggle">
									<a data-toggle="collapse" class="collapsed" data-parent="#accordian-one" data-target="#collapse-<?php echo get_the_ID(); ?>" href="#collapse-<?php echo get_the_ID(); ?>">
										<div class="fusion-toggle-icon-wrapper">
											<i class="fa-fusion-box"></i>
										</div>
										<div class="fusion-toggle-heading"><?php echo get_the_title(); ?></div>
									</a>
								</h4>
							</div>
							<?php
							echo sprintf( '<div id="collapse-%s" class="panel-collapse collapse">', get_the_ID() );
								echo '<div class="panel-body toggle-content post-content">';
									// Render the featured image of the post
									if ( Avada()->settings->get( 'faq_featured_image' ) &&
										 has_post_thumbnail()
									) {

										$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

										if ( $featured_image[0] ) {
											echo '<div class="flexslider post-slideshow">';
												echo '<ul class="slides">';
													echo '<li>';
														echo sprintf( '<a href="%s" data-rel="iLightbox[gallery]" data-title="%s" data-caption="%s">%s</a>',
																	  $featured_image[0], get_post_field( 'post_title', get_post_thumbnail_id() ), get_post_field( 'post_excerpt', get_post_thumbnail_id() ), get_the_post_thumbnail( get_the_ID(), 'blog-large' ) );
													echo '</li>';
												echo '</ul>';
											echo '</div>';
										}
									}
									// Render the post content
									the_content();
									?>
								</div>
							</div>
						</div>
					<?php endwhile; // loop through faq_items ?>
				</div>
			</div>
		</div>
	<?php
	} // password check
echo '</div>';
wp_reset_query();
do_action( 'fusion_after_content' );
?>
<?php get_footer();

// Omit closing PHP tag to avoid "Headers already sent" issues.
