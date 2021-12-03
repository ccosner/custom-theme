<?php

/**
 * The single project template file
 */
?>

<?php get_header(); ?>

<div class="post">
	<div class="container-fluid">
		<div class="content">
			<h1 class="page-title"><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>