<?php get_header();?>
<div id="main" role="main">
	<div id="single">
		<div id="single-new">
            <?php
				global $post;
				if(have_posts()) : while(have_posts()) : the_post();
					setPostViews($post->ID);
					getTitulo($post->ID);
					getMetaDatosSub($post->ID);
					the_content();
				endwhile; endif;				
			?>
        </div>
    </div>
    <div class="HRconte"></div>
</div>
<?php get_sidebar(); get_footer(); ?>