		</div><!-- .main .shadow -->
			<div class="container bottom-blocks"><!-- Example row of columns -->
				<?php if ( is_active_sidebar( 'footer-widget' ) ) : ?>
				<div id="footer-widget" class="footer-widget widget-area row fill" role="complementary">
					<?php dynamic_sidebar( 'footer-widget' ); ?>
				</div><!-- #footer-widget -->
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

		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "http://connect.facebook.net/cs_CZ/sdk.js#xfbml=1&appId=230812143598728&version=v2.0";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>

		<?php wp_footer(); ?>
	</body>
</html>
