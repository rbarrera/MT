<?php 
	get_header();
?>
<div id="main" role="main">
	<div id="content">
		<?php
			$LnIndex = 0;
			if (have_posts()): 
?>
		<header class="page-header">
            <?php if ( is_month() ) { ?>Archivo por mes | <?php echo ucfirst(get_the_time('F')); ?><?php } ?>
		</header>
<?php			
				rewind_posts();
				
				$LaArgu = array(
					'post_type'		 => 'postfullmt'
				);
			
				$querypost = new WP_Query($LaArgu);
				
				
				while ($querypost->have_posts()) : $querypost->the_post();
				global $post;
				$LnIndex++;
				
				$LnDonde = get_field('posicion');
				
				$LsClass 		= '';
				$LnDimenciones	= array(330, 186);
				$LnSizeImg		= 2;
				
				if($LnIndex == 1){
					$LsClass = 'homeleft';
				}else if($LnIndex == 2){
					$LsClass = 'homeright';
				}
				
				echo '<article class="'. $LsClass .'">';
						getImagenMT($post->ID, $LnDimenciones, $LnSizeImg);
				echo '	<span class="post_content">';
							getTitulo($post->ID);
							getMetaDatosSub($post->ID);
				echo '		<span class="post-content">';
								the_content('Leer mas...', true);
				echo '		</span>';
				echo '	</span>';
				echo '<span class="hr"></span>';
				echo '</article>';
				
				if($LnIndex == 2){
					$LnIndex = 0;
				}
							
			endwhile; 
			else:
?>
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
<?php
			endif;
        ?>
    </div>
    
</div>
<?php get_sidebar(); get_footer(); ?>