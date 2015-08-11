<?php if(is_singular()): ?>

    <?php
    if(get_field('title_override')) {
        $page_title = get_field('title_override');
    } else {
        $page_title = get_the_title();
    }
    ?>
    <?php if(get_field('hero_banner', get_queried_object_id())): ?>
        <style>
            .hero_banner{
                background-image: url("<?php echo get_field('hero_banner', get_queried_object_id()); ?>");
            }
        </style>

    <?php endif; ?>
<?php endif; ?>
<?php if(is_singular() || is_home()): ?>
<div class="hero_banner">
	<div class="container">
		<div class="row text-center">
            <?php if(is_singular('portfolio_item')) : ?>
			    <p class="hero-label"><?php _e('Project', 'sage'); ?></p>
            <?php endif; ?>
			<h1><?php echo $page_title ?></h1>
            <?php if(is_singular('portfolio_item')) : ?>
			<a target="_blank" rel="nofollow" class="btn btn-primary btn-sm" href="<?php echo get_field('portfolio_url', get_queried_object_id()); ?>"><?php _e('Visit Project Website', 'sage'); ?></a>
            <?php else : ?>
                <p class="lead"><?php echo get_field('page_slogan'); ?></p>
            <?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>
