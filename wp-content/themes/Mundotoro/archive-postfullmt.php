<?php get_header();?>
<div id="main" role="main">
	<div id="content">
		<div id="editorial">
        	<?php if(is_front_page()):?>
            	<h2 class="entry-title">Todas las publicaciones</h2>
            <?php else:?>
            	<h1 class="entry-title">Todas las publicaciones</h1>
            <?php endif;?>
            <?php
				if(have_posts()) : while(have_posts()) : the_post();
					echo '<div class="editorial-single">';
					echo '<div class="title"><a href="'. get_permalink() .'">'. get_the_title() .'</a></div>';
					echo '</div>';
				endwhile; endif;				
			?>
        </div>
    </div>
</div>
<?php get_sidebar(); get_footer(); ?>