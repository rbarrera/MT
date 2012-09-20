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
			<h1 class="page-title" style="text-align: center; margin-bottom: 12px; font-size: 16px; font-weight: normal;"><?php printf('Resultado de la busqueda de: %s', '<span><strong style="font-weight: bold;">'. get_search_query() .'</strong></span>'); ?></h1>
		</header>
<?php
				while ( have_posts() ) : the_post();
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
<style>
#searchform{
	margin: 30px 0px 30px 20px;	
}

#searchform label {
	display: block; margin-bottom: 5px; font-size: 16px; text-transform: uppercase; font-weight: bold;	
}
</style>
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title" style="text-align: center; margin-bottom: 12px; font-size: 16px; font-weight: normal;"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p style="margin-bottom: 12px; text-align: justify;">Lo sentimos, pero no corresponde a sus criterios de búsqueda. Por favor, inténtelo de nuevo con algunas palabras clave diferentes.</p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
<?php
			endif;
        ?>
    </div>
    
</div>
<?php get_sidebar(); get_footer(); ?>