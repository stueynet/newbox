<?php while (have_posts()) : the_post(); ?>
	<article <?php post_class(); ?> style="margin-bottom: 8em">
		<div class="entry-content">
            <?php if(get_field('portfolio_gallery')): ?>
			<div class="row portfolio-gallery">
				<?php foreach(get_field('portfolio_gallery') as $image): ?>
					<div class="col-sm-3">
						<a href="<?php echo $image['url']; ?>">
							<img class="img-thumbnail img-responsive" src="<?php echo  $image['sizes']['portfolio-thumb']; ?>">
						</a>
					</div>
				<?php endforeach; ?>
			</div>
			<hr>
        <?php endif; ?>
			<div class="narrow readable text-center">
				<?php the_content(); ?>
                <hr>
                <div class="text-center">
                    <a target="_blank" rel="nofollow" href="<?php echo get_field('portfolio_url', get_queried_object_id()); ?>"><?php _e('Visit Project Website', 'sage'); ?></a>
                </div>
			</div>
			<hr>
			<div class="row text-center">
				<div class="col-sm-4">
					<small><?php next_post_link('<< %link'); ?></small>
				</div>
				<div class="col-sm-4">
					<p><?php _e('More projects', 'sage'); ?></p>
				</div>
				<div class="col-sm-4">
					<small><?php previous_post_link('%link >>'); ?></small>
				</div>
			</div>
		</div>
	</article>
<?php endwhile; ?>
