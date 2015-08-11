<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;

$body_classes = '';
if(is_singular() && get_field('minimal')){
    $body_classes = 'minimal';
}
?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>
<body <?php body_class($body_classes); ?>>
<div class="body_wrap">
<!--[if lt IE 9]>
<div class="alert alert-warning">
	<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
</div>
<![endif]-->
<?php
do_action('get_header');
get_template_part('templates/header');
get_template_part('templates/page-hero');
?>
<div class="wrap container" role="document">
	<div class="content row">
		<main class="main" role="main">
			<?php include Wrapper\template_path(); ?>
		</main><!-- /.main -->
	</div><!-- /.content -->
</div><!-- /.wrap -->
<?php
do_action('get_footer');
get_template_part('templates/footer');
wp_footer();
?>
</div>
</body>
</html>
