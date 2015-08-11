<div class="cta_global text-center">
    <?php echo get_field('cta_global', 'option'); ?>
</div>
<footer class="content-info" role="contentinfo">
	<div class="container">
		<p class="logo"><?php _e('Newbox', 'sage'); ?></p>
		<?php
			wp_nav_menu(['menu' => 'Footer Menu', 'menu_class' => 'menu list-inline']);
		?>
	</div>
</footer>
