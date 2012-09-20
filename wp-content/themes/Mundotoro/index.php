<?php 
	get_header();

	$LaNoIdem = array();	
	$LbValorDesta = get_field('actidestacados', 'options');
	if($LbValorDesta == 1):
		$LnIdemDesta = get_field('selldestacado', 'options');
		
        $LaArgu = array(
			'posts_per_page' => 1,
			'post_type'		 => 'postfullmt',
			'p'		         => $LnIdemDesta->ID,
			'tax_query' 	 => array(
				array(
					'taxonomy' 	=> 'formataximt',
					'field' 	=> 'slug',
					'terms' 	=> 'destacadas'
				)
			)
		);
		
        $querypost = new WP_Query($LaArgu);
        if ($querypost->have_posts()) : while ($querypost->have_posts()) : $querypost->the_post();
			global $post;
			array_push($LaNoIdem, $post->ID);
        ?>
        <div class="titular_noticia">
        	<article>
				<?php getImagenMT($post->ID, array(330, 186), 2); ?>
                <span class="post_content">
                    <?php getTitulo($post->ID);?>
                    <?php getMetaDatosSub($post->ID);?>
                    <span class="post-content"><?php getPrevioNoticia($post->ID);?></span>
                </span>
                <div class="clearfix"></div>
            </article>
        </div>
        <?php
        endwhile; endif;
        wp_reset_postdata();
	endif;
?>
<div id="main" role="main">
<?php
	$LbLoMejor 		= get_field('actimejorhome', 'options');
	$LbLoMejorUbi 	= get_field('ubicacion_lo_mejor', 'options');
	
	$LbSliderAct	= get_field('activarsliderhome', 'options');
	$LbSliderUbi 	= get_field('ubislider', 'options');
	//print_r($LbSliderUbi);
?>
	<div id="banner"><?php getPublicidadBodyTop();?></div>
	<?php getSliderHome($LbSliderAct, $LbSliderUbi, 1);?>
    <?php getLomejorDonde($LbLoMejor, $LbLoMejorUbi, 1);?>
	<div id="content">
		<?php
            $LnCantidadHome = get_field('cantihome', 'options');
            if(!$LnCantidadHome){$LnCantidadHome = 10;}
			
            $LaArgu = array(
                'posts_per_page' => $LnCantidadHome,
                'post_type'		 => 'postfullmt',
                'meta_query' 	 => array(
                    array(
                        'key' 		=> 'homepub',
                        'value' 	=> '1'
                    )
                )
            );
			
			$LnIndex 	= -1;
            $LnCantidad = 0;
			
            $querypost = new WP_Query($LaArgu);
            if ($querypost->have_posts()) : while ($querypost->have_posts()) : $querypost->the_post();
				global $post;
				
	            array_push($LaNoIdem, $post->ID);
				$LnCantidad++;
				
				$LnDonde = get_field('posicion');
				
				$LsClass 		= '';
				$LnDimenciones	= array(330, 186);
				$LnSizeImg		= 2;
				if($LnDonde == 1 or $LnDonde == 3){
					$LsClass = 'homeleft';
				}else if($LnDonde == 2 or $LnDonde == 4){
					$LsClass = 'homeright';
				}
				
				if($LnDonde == 3 or $LnDonde == 4 or $LnDonde == 5){
					echo '<div class="clearfix"></div>';
				}
				
				if($LnDonde == 5){
					$LnDimenciones	= array(670, 377);
					$LnSizeImg = 3;
				}
				
				echo '<article class="'. $LsClass .'">';
						$LoRelacion = get_field('sellpubli');
						$LbPubli	= false;
						$LoRel		= null;
						$LnLugar	= get_field('ubipublipubli');
						
						if($LoRelacion){
							$LbPubli = true;
							foreach($LoRelacion as $relacion):
								$LoRel = $relacion;
							endforeach;
						}
						
						getPublicPublicacion($LoRel, 0, $LnLugar, $LbPubli);
						getImagenMT($post->ID, $LnDimenciones, $LnSizeImg);
				echo '	<span class="post_content">';
							getTitulo($post->ID);
							getMetaDatosSub($post->ID);
							getPublicPublicacion($LoRel, 1, $LnLugar, $LbPubli);
				echo '		<span class="post-content">';
								getPrevioNoticia($post->ID);
				echo '		</span>';
							getPublicPublicacion($LoRel, 2, $LnLugar, $LbPubli);
				echo '	</span>';
				echo '<span class="hr"></span>';
				echo '</article>';			
            endwhile; endif;
            wp_reset_postdata();
			
			$LnFalta = $LnCantidadHome - $LnCantidad;
			if($LnFalta > 0){
				$LaArgu = array(
					'posts_per_page' => $LnFalta,
					'post_type'		 => 'postfullmt',
					'post__not_in' 	 => $LaNoIdem
				);
				
				$querypost = new WP_Query($LaArgu);
				if ($querypost->have_posts()) : while ($querypost->have_posts()) : $querypost->the_post();
					global $post;
					
					$LnDonde = get_field('posicion');
					
					$LsClass 		= '';
					$LnDimenciones	= array(330, 186);
					$LnSizeImg		= 2;
					if($LnDonde == 1 or $LnDonde == 3){
						$LsClass = 'homeleft';
					}else if($LnDonde == 2 or $LnDonde == 4){
						$LsClass = 'homeright';
					}else{
						$LsClass = 'homeleft';
					}
					
					if($LnDonde == 3 or $LnDonde == 4 or $LnDonde == 5){
						echo '<div class="clearfix"></div>';
					}
					
					if($LnDonde == 5){
						$LnDimenciones	= array(670, 377);
						$LnSizeImg = 3;
					}
					
					echo '<article class="'. $LsClass .'">';
							getPublicPublicacion($LoRel, 0, $LnLugar, $LbPubli);
							getImagenMT($post->ID, $LnDimenciones, $LnSizeImg);
					echo '	<span class="post_content">';
								getTitulo($post->ID);
								getMetaDatosSub($post->ID);
								getPublicPublicacion($LoRel, 1, $LnLugar, $LbPubli);
					echo '		<span class="post-content">';
									getPrevioNoticia($post->ID);
					echo '		</span>';
								getPublicPublicacion($LoRel, 2, $LnLugar, $LbPubli);
					echo '	</span>';
					echo '<span class="hr"></span>';
					echo '</article>';			
				endwhile; endif;
				wp_reset_postdata();
			}
        ?>
    </div>
    <div class="clearfix"></div>
    <?php getLomejorDonde($LbLoMejor, $LbLoMejorUbi, 2);?>
    <div class="clearfix"></div>
    <?php getSliderHome($LbSliderAct, $LbSliderUbi, 2);?>
    <div class="clearfix"></div>
    <div id="banner"><?php getPublicidadBodyFooter();?></div>
    <div class="clearfix"></div>
</div>
<?php get_sidebar(); get_footer(); ?>