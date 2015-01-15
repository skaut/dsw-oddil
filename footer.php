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
				<img src="<?php bloginfo('template_url'); ?>/img/junak-znak-cb-neg.png" />
				<p>&copy; Název střediska | Junák - svaz skautů a skautek ČR | <a href="http://www.skaut.cz/" title="Skaut.cz">www.skaut.cz</a> | <a href="/wp-admin/" title="Administrace">Administrace</a></p>
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

		<?php wp_enqueue_script("jquery"); ?>
		<?php wp_footer(); ?>
	</body>
</html>