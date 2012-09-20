<?php get_header();?>
<div id="main" role="main">
	<div id="single">
		<div id="single-new" style="position: relative;">
            <?php
				global $post;
				if(have_posts()) : while(have_posts()) : the_post();
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
					
					setPostViews($post->ID);
					echo '<script type="text/javascript">set_Cookie("'. $post_cookie .'", "True", 1 , "/", "", "");</script>';
					getPublicPublicacion($LoRel, 0, $LnLugar, $LbPubli);
					getImagenMT($post->ID, array(670, 377), 3);					
					getTitulo($post->ID);
					getMetaDatosSub($post->ID);
					getPublicPublicacion($LoRel, 1, $LnLugar, $LbPubli);
					getPublicPublicacion($LoRel, 3, $LnLugar, $LbPubli, true);
					echo '<div style="margin: 20px 0px;">';
					the_content();
					echo '</div>';
					getPublicPublicacion($LoRel, 2, $LnLugar, $LbPubli);
				endwhile; endif;
				comments_template( '', true );				
			?>
        </div>
    </div>
    <div class="HRconte"></div>
	<span class="share">
		<span class="icons">
        	<h3>Comparte:</h3> 
          	<span class='st_facebook_hcount' displayText='Facebook'></span>
            <span class='st_delicious_hcount' displayText='Delicious'></span>
            <span class='st_twitter_hcount' displayText='Tweet'></span>
            <span class='st_linkedin_hcount' displayText='LinkedIn'></span>
            <span class='st_myspace_hcount' displayText='MySpace'></span>
            <span class='st_googleplus_hcount' displayText='Google +'></span>
			
			<script type="text/javascript">var switchTo5x=true;</script>
			<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
			<script type="text/javascript">stLight.options({publisher: "3976b4d4-7ba4-4c5f-b8bb-f9feb4beb580"}); </script>
      	</span>
    </span>
</div>
<?php get_sidebar(); get_footer(); ?>