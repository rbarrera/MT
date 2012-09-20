			<div class="clearfix"></div>
			<?php 
				$LsCuentaTw = get_field('idtwihome', 'options');
				if($LsCuentaTw):
					$LnCantidad = get_field('canhometwi', 'options');
					if(!$LnCantidad){$LnCantidad = 5;}
					$tweet = get_tweets($LsCuentaTw, $LnCantidad);
					$LnCanFin = count($tweet);
					if($LnCantidad > $LnCanFin){$LnCantidad = $LnCanFin;}
			?>
            <script>
				var __HOTINTERVALTW__ = <?php $LnInterHot = get_field('timetwi', 'options'); if(!$LnInterHot){$LnInterHot = 60;} echo $LnInterHot;?>;
			</script>
            <div id="tweets">
                <span class="bird"></span>
                <div class="tttt">  
                    <div class="tweets">
                    <? for($a = 0; $a < $LnCantidad; $a++): ?>
                            <div class="itemtw"><?php echo $tweet[$a]->text;?></div>
                    <? endfor;?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <span class="pagination">
                    <? for($a = 0; $a < $LnCantidad; $a++): 
						$LsClass = '';
						if($a == 0){$LsClass = 'active';}
					?>
                    <span><a class="boton <?php echo $LsClass?>" rel="<?php echo ($a); ?>" ><?php echo ($a + 1); ?></a></span>
                    <? endfor;?>
                </span>
            </div>
			<?php endif;?>
			<div class="clearfix"></div>
            
            <div id="especiales">
				<span class="especiales">
					<h3>Especiales</h3>
					<?php
						wp_reset_postdata();
						for($a = 0; $a < 3; $a++):
							$LaArgu = array(
								'posts_per_page' => 100,
								'post_type'	 	 => 'posticonosmt',
								'meta_query' 	 => array(
									array(
										'key' 		=> 'posiicon',
										'value' 	=> ($a + 1)
									)
								)
							);
							
							$queryicon = new WP_Query($LaArgu);							
							$LsIconHTML = '';
							if ($queryicon->have_posts()) : while ( $queryicon->have_posts() ) : $queryicon->the_post();
								$attachment_id  = get_field('icono');
								$image          = wp_get_attachment_image_src($attachment_id, 'full');								
								$LsIconHTML.= '<div style="background-image: url('. $image[0] .');"><a href="'. get_field('urlicon') .'" target="_blank">'. get_the_title() .'</a></div>';
							endwhile;endif;
							
							echo '<div class="iconizq">'. $LsIconHTML .'</div>';
							wp_reset_postdata();
						endfor;
                    ?>
				</span>                
                <span class="calendario"><?php ucc_get_calendar('postfullmt') ?></span>
                <div class="clearfix"></div>
            </div>
            <div id="banner"><?php getPublicidadFooter();?></div>
            <footer>
            	<span>
					<?php wp_nav_menu(array('container' => 'div', 'theme_location' => 'footer_a', 'after' => '<span class="sepamenufooter">|</span>', 'menu_class' => 'menufooter')); ?>
                    <?php wp_nav_menu(array('container' => 'div', 'theme_location' => 'footer_b', 'after' => '<span class="sepamenufooter">|</span>', 'menu_class' => 'menufooter')); ?>
                    <?php wp_nav_menu(array('container' => 'div', 'theme_location' => 'footer_c', 'after' => '<span class="sepamenufooter">|</span>', 'menu_class' => 'menufooter')); ?>
                </span>
                <span>
					<?php wp_nav_menu(array('container' => 'div', 'theme_location' => 'footer_d', 'after' => '<span class="sepamenufooter">|</span>', 'menu_class' => 'menufooter')); ?>
                    <?php wp_nav_menu(array('container' => 'div', 'theme_location' => 'footer_e', 'after' => '<span class="sepamenufooter">|</span>', 'menu_class' => 'menufooter')); ?>
                </span>
                <span>
					<?php wp_nav_menu(array('container' => 'div', 'theme_location' => 'footer_f', 'after' => '<span class="sepamenufooter">|</span>', 'menu_class' => 'menufooter')); ?>
                </span>
                <span class="top-img"><a onclick="javascript: jQuery('html, body').animate({ scrollTop: 0 }, 'slow');" href="javascript: void(0)"></a></span>
                <small>
                	Copyright &copy; 2011. Taurocom, S.L. Todos los derechos reservados.<br/>
					CIF: B-86101045 | Registro Mercantil Madrid.  |  Tomo 28.271 folio 209 secci&oacute;n 8 hoja M509180<br/>
					Calle Altamirano, n 37 C.P. 28008 Madrid| Email: redaccion@mundotoro.com - Tel&eacute;fonos: 91 2961571
				</small>
                <span class="logo"><img src="<?php bloginfo('template_url'); ?>/imagenes/logo-footer.png" /></span>
            </footer>
		</div> <!-- CONTAINER -->
	</div> <!-- FONDO -->
    <form method="post" action="/" id="myclickpubli" target="_blank"></form>
        <script>
			jQuery(document).ready(function(e) {
                if(jQuery(".publipopup").size() > 0){
					if(__SESSIONPOP__ == 1 && __SESSIONACT__ == 0){
						mostrarpop();
					}else if(__SESSIONPOP__ == 2){
						mostrarpop();	
					}
				}
            });
			
			var tiempopop = null;
			function mostrarpop(){
				if(jQuery(".publipopup").size() == 0) return;
				jQuery("body").append('<div id="fondoover"></div>');
				jQuery("#fondoover").css({
					position	: 'absolute',
					zIndex		: 100,
					top			: '0px',
					left		: '0px',
					width		: '100%',
					height		: jQuery(document).height(),
					background	: '#000',
					opacity		: 0
				});
				
				jQuery("#fondoover").fadeTo(300, .7, jQuery.proxy(function(){
					jQuery('.publipopup').css('visibility', 'visible');
					tiempopop = setTimeout(function(){
						closepop();
					}, (__TIEMPOPOP__ * 1000));
				}, this));
			}
			
			function closepop(){
				if(jQuery(".publipopup").size() == 0) return;
				clearTimeout(tiempopop);
				jQuery('.publipopup').css('visibility', 'hidden');
				jQuery("#fondoover").fadeTo(300, 0, jQuery.proxy(function(){
					jQuery("#fondoover").remove();					
				}, this));
			}
		</script>
<?php
	$LbPopActivo = get_field('publivisi', 'options');
	$LoPublic = get_field('publicidadpop', 'options');
	if($LbPopActivo and $LoPublic){		
		$LnMedidas = get_field('medidaspop', $LoPublic->ID);
		$LnFormato = get_field('publiformat', $LoPublic->ID);
		$LsArchivo = '';
		$LaMedidaX = array(1 => 400, 2 => 800);
		$LaMedidaY = array(1 => 400, 2 => 600);
		$LnSession = 0;
		
		if(isset($_SESSION['popshow'])){
			$LnSession = 1;
		}
		
		$_SESSION['popshow'] = 1;
		
		echo '
			<script>
				var __MEDIDASX__   = '. $LaMedidaX[$LnMedidas] .';
				var __MEDIDASY__   = '. $LaMedidaY[$LnMedidas] .';
				var __TIEMPOPOP__  = '. get_field('publiduraccion', 'options') .';
				var __SESSIONPOP__ = '. get_field('publimostrar', 'options') .';
				var __SESSIONACT__ = '. $LnSession .';
			</script>
		';
		
		if($LnFormato == 1){
			$LsArchivo = get_field('publiimagen', $LoPublic->ID);
			$LsArchivo = '<img src="'. $LsArchivo .'" width="'. $LaMedidaX[$LnMedidas] .'" height="'. $LaMedidaY[$LnMedidas] .'"/>';			
		}else{
			$LsArchivo = get_field('publiarchi', $LoPublic->ID);
			$LsArchivo = '<iframe allowtransparency="true"  width="'. $LaMedidaX[$LnMedidas] .'" height="'. $LaMedidaY[$LnMedidas] .'" src="'. $LsArchivo .'"></iframe>';
		}
		
		echo '<div class="publipopup" style="width: '. $LaMedidaX[$LnMedidas] .'px; height: '. $LaMedidaY[$LnMedidas] .'px;"><a href="javascript: void(0);" class="btnclose" onClick="closepop()"></a>'. $LsArchivo .'</div>';
	}
?>
		<?php wp_footer(); ?>
	</body>
</html>