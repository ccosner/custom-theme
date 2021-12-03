<?php
/**
 * Footer
 */
?>
		</main>
		
		<footer class="site-footer">
			<div class="container-fluid">
				<?php if ( is_active_sidebar( 'footer' ) ) : dynamic_sidebar( 'footer' ); endif; ?>
				<div class="copyright">
					Copyright &copy; <script type="text/javascript">document.write(new Date().getFullYear());</script> Christopher Cosner. All rights reserved.
				</div>
			</div>
			
		</footer>
		
		<?php wp_footer(); ?>

	</body>

</html>