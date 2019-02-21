					<?php do_action( 'avada_after_main_content' ); ?>				
				</div>  <!-- fusion-row -->
			</div>  <!-- #main -->
			<?php
			do_action( 'avada_after_main_container' );
			
			global $social_icons;

			if ( strpos( Avada()->settings->get( 'footer_special_effects' ), 'footer_sticky' ) !== FALSE ) {
				echo '</div>';
			}

			// Get the correct page ID
			$c_pageID = Avada::c_pageID();

			// Only include the footer
			if ( ! is_page_template( 'blank.php' ) ) {

				$footer_parallax_class = '';
				if ( Avada()->settings->get( 'footer_special_effects' ) == 'footer_parallax_effect' ) {
					$footer_parallax_class = ' fusion-footer-parallax';
				}

				printf( '<div class="fusion-footer%s">', $footer_parallax_class );

					// Check if the footer widget area should be displayed
					if ( ( Avada()->settings->get( 'footer_widgets' ) && get_post_meta( $c_pageID, 'pyre_display_footer', true ) != 'no' ) ||
						 ( ! Avada()->settings->get( 'footer_widgets' ) && get_post_meta( $c_pageID, 'pyre_display_footer', true ) == 'yes' )
					) {
						$footer_widget_area_center_class = '';
						if ( Avada()->settings->get( 'footer_widgets_center_content' ) ) {
							$footer_widget_area_center_class = ' fusion-footer-widget-area-center';
						}

					?>
						<footer class="fusion-footer-widget-area fusion-widget-area<?php echo $footer_widget_area_center_class; ?>">
							<div class="fusion-row">
								<div class="fusion-columns fusion-columns-<?php echo Avada()->settings->get( 'footer_widgets_columns' ); ?> fusion-widget-area">

									<?php
									// Check the column width based on the amount of columns chosen in Theme Options
									$column_width = 12 / Avada()->settings->get( 'footer_widgets_columns' );
									if( Avada()->settings->get( 'footer_widgets_columns' ) == '5' ) {
										$column_width = 2;
									}

									// Render as many widget columns as have been chosen in Theme Options
									for ( $i = 1; $i < 7; $i++ ) {
										if ( Avada()->settings->get( 'footer_widgets_columns' ) >= $i ) {
											if ( Avada()->settings->get( 'footer_widgets_columns' ) == $i ) {
												echo sprintf( '<div class="fusion-column fusion-column-last col-lg-%s col-md-%s col-sm-%s">', $column_width, $column_width, $column_width );
											} else {
												echo sprintf( '<div class="fusion-column col-lg-%s col-md-%s col-sm-%s">', $column_width, $column_width, $column_width );
											}

												if ( function_exists( 'dynamic_sidebar' ) &&
													 dynamic_sidebar( 'avada-footer-widget-' . $i )
												) {
													// All is good, dynamic_sidebar() already called the rendering
												}
											echo '</div>';
										}
									}								
									?>

									<div class="fusion-clearfix"></div>
								</div> <!-- fusion-columns -->
							</div> <!-- fusion-row -->
						</footer> <!-- fusion-footer-widget-area -->
					<?php
					} // end footer wigets check

					// Check if the footer copyright area should be displayed
					if ( ( Avada()->settings->get( 'footer_copyright' ) && get_post_meta( $c_pageID, 'pyre_display_copyright', true ) != 'no' ) ||
						  ( ! Avada()->settings->get( 'footer_copyright' ) && get_post_meta( $c_pageID, 'pyre_display_copyright', true ) == 'yes' )
					) {

						$footer_copyright_center_class = '';
						if ( Avada()->settings->get( 'footer_copyright_center_content' ) ) {
							$footer_copyright_center_class = ' fusion-footer-copyright-center';
						}
					?>
						<footer id="footer" class="fusion-footer-copyright-area<?php echo $footer_copyright_center_class; ?>">
							<div class="fusion-row">
								<div class="fusion-copyright-content">

									<?php
									/**
									 * avada_footer_copyright_content hook
									 *
									 * @hooked avada_render_footer_copyright_notice - 10 (outputs the HTML for the Theme Options footer copyright text)
									 * @hooked avada_render_footer_social_icons - 15 (outputs the HTML for the footer social icons)
									 */
									do_action( 'avada_footer_copyright_content' );
									?>

								</div> <!-- fusion-fusion-copyright-content -->
							</div> <!-- fusion-row -->
						</footer> <!-- #footer -->
				<?php
				} // end footer copyright area check
				?>
				</div> <!-- fusion-footer -->
				<?php
			} // end is not blank page check
			?>
		</div> <!-- wrapper -->

		<?php
		// Check if boxed side header layout is used; if so close the #boxed-wrapper container
		if ( ( ( Avada()->settings->get( 'layout' ) == 'Boxed' && get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'default' ) || get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'boxed' ) &&
			 Avada()->settings->get( 'header_position' ) != 'Top'

		) {
		?>
			</div> <!-- #boxed-wrapper -->
		<?php
		}

		?>

		<a class="fusion-one-page-text-link fusion-page-load-link"></a>

		<!-- W3TC-include-js-head -->

		<?php
		wp_footer();

		// Echo the scripts added to the "before </body>" field in Theme Options
		echo Avada()->settings->get( 'space_body' );
		?>

		<!--[if lte IE 8]>
			<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/respond.js"></script>
		<![endif]-->
	</body>
</html>
