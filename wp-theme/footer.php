		</div><!-- .main .shadow -->
			<div class="container bottom-blocks"><!-- Example row of columns -->
				<?php if ( is_active_sidebar( 'bottom-widget' ) ) : ?>
				<div id="bottom-widget" class="bottom-widget widget-area row fill" role="complementary">
					<?php dynamic_sidebar( 'bottom-widget' ); ?>
				</div><!-- #bottom-widget -->
				<?php endif; ?>
			</div>
		</div><!-- /container -->

		<div id="footer">
			<div class="container">
				<?php if ( is_active_sidebar( 'footer' ) ) : ?>
				<div id="footer-widget" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'footer' ); ?>
				</div><!-- #footer -->
				<?php endif; ?>
			</div>
		</div>

		<?php wp_footer(); ?>
		<script type="text/javascript">
			$( document ).ready( function() {
				var top_widget_height = $( '.top-widget' ).height();
				var bottom_widget_height = $( '.bottom-widget' ).height();
				var top_widgets = $( '.top-widget aside' );
				var bottom_widgets = $( '.bottom-widget aside' );
				$.each( top_widgets, function() {
					$( this ).height( top_widget_height );
				} );
				$.each( bottom_widgets, function() {
					$( this ).height( bottom_widget_height );
				} );
			} );
		</script>
	</body>
</html>
