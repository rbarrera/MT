<?php

    /**
     * FrontEnd Declarations
     */
    add_action('after_setup_theme', 'propiedades_themes');
    function propiedades_themes(){
        wp_enqueue_script('jquery');
        wp_register_script('jqueryui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js');
        
        add_editor_style();
        
        add_theme_support('post-thumbnails');
        add_theme_support('automatic-feed-links');
        
        register_nav_menus(array(
            'canales'       => 'Canales',
            'secciones_a'   => 'Secciones A',
            'secciones_b'   => 'Secciones B',
            'footer_a'      => 'Footer A',
            'footer_b'      => 'Footer B',
            'footer_c'      => 'Footer C',
            'footer_d'      => 'Footer D',
            'footer_e'      => 'Footer E',
            'footer_f'      => 'Footer F'
        ));
        
        add_image_size('post-thumb-1', 220, 0, true);
        add_image_size('post-thumb-2', 330, 0, true);
        add_image_size('post-thumb-2-p', 415, 0, true);
        add_image_size('post-thumb-2-p-r', 248, 0, true);
        add_image_size('post-thumb-3', 670, 0, false);
        add_image_size('BOTTOM-thumb', 110, 92, true);
        add_image_size('latest-news-thumb', 63, 60, true);
        add_image_size('the-best-thumb', 110, 92, true);
        add_image_size('single-img', 670, 0, true);
    }
    
    
    add_action('widgets_init', 'mt_slider_registre');
    function mt_slider_registre(){
        register_sidebar(array('name' => 'LATERAL', 'id' => 'primario'));
    }
    
    function getImagenMT($PnIdem, $PnMedidas = array(), $LnIndex = 1){
		getImagenMTPost($PnIdem, $PnMedidas, 'post-thumb-'. $LnIndex);
    }
    
    function getImagenMTPost($PnIdem, $PnMedidas = array(), $PsThumbel){
        $LbRemplazo = get_field('remplacevideo', $PnIdem);
        $LnPosicion = get_field('ubisubtitulo', $PnIdem);
        $LsSubTitul = get_field('subtitulo', $PnIdem);
        
        if(!empty($LsSubTitul) and $LnPosicion == 1){
            echo '<span class="post-subtitle">'. $LsSubTitul .'</span>';
        }
        
        if($LbRemplazo == 2):
			$LsTube  = get_field('idtube', $PnIdem);
            $LsFrame = get_field('urliframe', $PnIdem);
			if(!empty($LsTube)):
                echo '<span class="post-img">';
				echo '<iframe allowtransparency="true" width="'. $PnMedidas[0] .'" height="'. $PnMedidas[1] .'" src="http://www.youtube.com/embed/'. $LsTube .'?rel=0&autoplay=0&wmode=transparent" frameborder="0" allowfullscreen></iframe>';
                echo '</span>';
			elseif(!empty($LsFrame)):
				echo '<span class="post-img">';
				echo '<iframe allowtransparency="true" width="'. $PnMedidas[0] .'" scrolling="no" height="'. $PnMedidas[1] .'" frameborder="0" src="http://player.qbrick.com/player.aspx?mcid='. $LsFrame .'&amp;width='. $PnMedidas[0] .'&amp;height='. $PnMedidas[1] .'&amp;as=0&amp;fs=1&amp;rp=0&amp;cb=1&amp;il=1&amp;sp=1&amp;db=0&amp;ct=0&amp;mni=0&wmode=transparent" id="iframe_player">  You need a browser that can handle Iframes to be able to view this page.</iframe>';
                echo '</span>';
			endif;
		else:
			if(has_post_thumbnail($PnIdem)):
				echo '<span class="post-img"><a href="'. get_permalink($PnIdem) .'">';
				echo get_the_post_thumbnail($PnIdem, $PsThumbel);
				echo '</a></span>';
			endif;
		endif;
    }
    
    function getSliderHome($PnActivo, $PnDonde, $PnLugar){
    	if($PnActivo == 1 and $PnDonde == $PnLugar){
    		$rows = get_field('gruposhome', 'options');
    		if($rows[0]){
    			//print_r($rows[0]);
    			$LaArgu = array(
					'posts_per_page' => 1,
					'post_type'		 => 'postslidemt',
					'p'		         => $rows[0]['imagenesgrupo']->ID
				);
				
				$querypost = new WP_Query($LaArgu);
				if ($querypost->have_posts()) : 
					echo '
						<script language="javascript">
							var __TIEMPOSLIDER__ = '. $rows[0]['timeimggrupo'] .';
							var __TIEMPOESPERA__ = '. $rows[0]['timegrupo'] .';
						</script>
					';
				
					while ($querypost->have_posts()) : $querypost->the_post();
						echo '
						<div class="theme-default" style="margin: 0px 0px 10px;">
							<div id="slider" class="nivoSlider">';
							$images = get_field('gruposlide');
							if($images):
								foreach( $images as $image ):
									echo '<img width="680px" src="'. $image['url'] .'" />';
								endforeach;
							endif;
						echo '</div></div>';
					endwhile; 
				
				endif;
				wp_reset_postdata();
    		}
    	}
    }
    
    function getLomejorDonde($PnActivo, $PnDonde, $PnLugar){
    	if($PnActivo == 1 and $PnDonde == $PnLugar){
			$LaArgu = array(
				'posts_per_page' => get_field('cantidadmejorhome', 'options'),
				'post_type'		 => 'postfullmt',
				'tax_query' 	 => array(
					array(
						'taxonomy' 	=> 'formataximt',
						'field' 	=> 'slug',
						'terms' 	=> 'mejor'
					)
				)
			);
			
			$querypost = new WP_Query($LaArgu);
			if ($querypost->have_posts()) : 
				echo '
				<div id="tbest" style="margin: 0px 0px 10px;">
					<h3>lo mejor</h3>
					<ul id="carousel" class="mycarousel jcarousel-skin-tango">
				';
			
				while ($querypost->have_posts()) : $querypost->the_post();
					global $post;
					$LbRemplazo = get_field('remplacevideo');
					
					
					echo '<li id="item">';
	
					if($LbRemplazo == 2):
						$LsTube  = get_field('idtube');
			            $LsFrame = get_field('urliframe');
						if(!empty($LsTube)):
			                echo '<span class="post-img">';
							echo '<iframe allowtransparency="true" width="110" height="62" src="http://www.youtube.com/embed/'. $LsTube .'?rel=0&autoplay=0&wmode=transparent" frameborder="0" allowfullscreen></iframe>';
			                echo '</span>';
						elseif(!empty($LsFrame)):
							echo '<span class="post-img">';
							echo '<iframe allowtransparency="true" width="110" scrolling="no" height="62" frameborder="0" src="http://player.qbrick.com/player.aspx?mcid='. $LsFrame .'&amp;width=110&amp;height=62&amp;as=0&amp;fs=1&amp;rp=0&amp;cb=1&amp;il=1&amp;sp=1&amp;db=0&amp;ct=0&amp;mni=0&wmode=transparent" id="iframe_player">  You need a browser that can handle Iframes to be able to view this page.</iframe>';
			                echo '</span>';
						endif;
					else:
						if(has_post_thumbnail()):
							echo '<a href="'. get_permalink() .'">';
							echo get_the_post_thumbnail($post->ID, 'the-best-thumb');
							echo '</a>';
						endif;
					endif;
					
					echo 		'
							<a href="'. get_permalink($post->ID) .'"><span class="title">'. get_the_title() .'</span></a>
						</li>
					';
				endwhile; 
				echo '</ul></div>';
			endif;
    	}
    }
    
    function getPrevioNoticia($PnIdem){
    	$LsPrevio = get_field('textopreviopubli', $PnIdem);
    	$LbPrevio = true;
    	
    	if($LsPrevio){
    		$LsPrevio = trim($LsPrevio);
    		if(!empty($LsPrevio)){
    			$LbPrevio = false;
				echo $LsPrevio;
				echo '<br>';
				echo '<br>';
				echo '<br>';
				echo '<a href="'. get_permalink($PnIdem) .'">Leer mas...</a>'; 
    		}
    	}
    	
    	if($LbPrevio){
    		echo '<br>';
    		echo '<br>';
    		the_content('Leer mas...', true);
    	}
    }
    
    function getTitulo($PnIdem){
        $LnPosicion = get_field('ubisubtitulo', $PnIdem);
        $LsSubTitul = get_field('subtitulo', $PnIdem);
        
        if(!empty($LsSubTitul) and $LnPosicion == 2){
            echo '<span class="post-subtitle">'. $LsSubTitul .'</span>';
        }
        
        echo '<span class="post-title"><a href="'. get_permalink($PnIdem) .'">'. get_the_title($PnIdem) .'</a></span>';
    }
    
    function getMetaDatosSub($PnIdem){
        $LaSubTitul = get_field('iconos', $PnIdem);
        
        if($LaSubTitul){
        	echo '<span class="meta-data">';
	        foreach($LaSubTitul as $LnIndex => $LnValor){
	            if($LnValor == 1 and comments_open($PnIdem)){
	                echo '<span class="comments"><a href="'. get_comments_link($PnIdem) .'">';
	                comments_number('Comentarios (0)','Comentarios (1)','Comentarios (%)');
	                echo '</a></span>';
	            }else if($LnValor == 2){
	                echo '<span class="video"><a href="'. get_permalink($PnIdem) .'">Video</a></span>';
	            }else if($LnValor == 3){
	                echo '<span class="gallery"><a href="'. get_permalink($PnIdem) .'">Foto</a></span>';
	            }
	        }
	        echo '</span>';
        }
        
        echo '<span class="date">'. get_the_date('d/m/Y - H:i') .'</span>';
    }
    
    function getTaxiSelect($PsTaxi, $PsDefault, $PsNone){
    	$LoLocalidades = get_terms($PsTaxi, array('hide_empty' => 0));
    	$LsListaLocalidad = '<option value="0">'. $PsDefault .'</option>';
    	if($LoLocalidades){
			foreach($LoLocalidades as $LoLocalidad){
				$LsListaLocalidad.= '<option value="'. $LoLocalidad->slug .'">'. $LoLocalidad->name .'</option>';
			}
		}else{
			$LsListaLocalidad = '<option value="0">'. $PsNone .'</option>';
		}
		echo $LsListaLocalidad;
    }
    
    function get_tweets($PsCuenta, $PnCantidad){
        $format     = 'json';
        $cache      = dirname(__file__) . '/cache/twitter-json.txt';
        $data       = @file_get_contents('http://api.twitter.com/1/statuses/user_timeline/' .
        $PsCuenta . '.json?count='. $PnCantidad .'&include_rts=true&include_entities=true');
        
        if (!$data){
            $cachefile = fopen($cache, 'r');
            $tweet = fread($cachefile, filesize($cache));
            $tweet = json_decode($tweet);
            fclose($cachefile);
        }else{
            $cachefile = fopen($cache, 'wb');
            fwrite($cachefile, utf8_encode($data));
            fclose($cachefile);
            $tweet = json_decode($data);
        }
        
        return $tweet;
    }
    
    function getPublicidadTop(){
    	$LbFondoPubli 	  = get_field('visibilidadtop',   'options');
		$LoFondoPubli01   = get_field('publicidadtop01',  'options');
		$LoFondoPubli02   = get_field('publicidadtop02',  'options');
		$LoFondoDimencion = get_field('publitopposicion', 'options');
		
		if($LbFondoPubli and $LoFondoPubli01 and $LoFondoDimencion == 1){
			getPublicidadBloque($LoFondoPubli01);
		}else if($LbFondoPubli and $LoFondoPubli01 and $LoFondoPubli02 and $LoFondoDimencion == 2){
			getPublicidadBloque($LoFondoPubli01, 2);
			getPublicidadBloque($LoFondoPubli02, 2, 'right');
		}else if($LbFondoPubli and $LoFondoPubli01 and $LoFondoPubli02 and $LoFondoDimencion == 3){
			getPublicidadBloque($LoFondoPubli01, 3);
			getPublicidadBloque($LoFondoPubli02, 1, 'right');
		}else if($LbFondoPubli and $LoFondoPubli01 and $LoFondoPubli02 and $LoFondoDimencion == 4){
			getPublicidadBloque($LoFondoPubli01, 1);
			getPublicidadBloque($LoFondoPubli02, 3, 'right');
		}
		echo '<div class="clearfix"></div>';
    }
    
    function getPublicidadTopBar(){		
		$LbFondoPubli 	  = get_field('visiblidadtopbar',   'options');
		$LoFondoPubli01   = get_field('publicidadtopbar01',  'options');
		$LoFondoPubli02   = get_field('publicidadtopbar02',  'options');
		$LoFondoDimencion = get_field('publitopbarposicion', 'options');
		
		if($LbFondoPubli and $LoFondoPubli01 and $LoFondoDimencion == 1){
			getPublicidadBloque($LoFondoPubli01);
		}else if($LbFondoPubli and $LoFondoPubli01 and $LoFondoPubli02 and $LoFondoDimencion == 2){
			getPublicidadBloque($LoFondoPubli01, 2);
			getPublicidadBloque($LoFondoPubli02, 2, 'right');
		}else if($LbFondoPubli and $LoFondoPubli01 and $LoFondoPubli02 and $LoFondoDimencion == 3){
			getPublicidadBloque($LoFondoPubli01, 3);
			getPublicidadBloque($LoFondoPubli02, 1, 'right');
		}else if($LbFondoPubli and $LoFondoPubli01 and $LoFondoPubli02 and $LoFondoDimencion == 4){
			getPublicidadBloque($LoFondoPubli01, 1);
			getPublicidadBloque($LoFondoPubli02, 3, 'right');
		}
		echo '<div class="clearfix"></div>';
    }
    
    function getPublicidadBodyTop(){
    	$LbFondoPubli = get_field('visiblidadbodytop', 'options');
		$LoFondoPubli = get_field('publicidadbodytop',  'options');		
		if($LbFondoPubli and $LoFondoPubli){getPublicidad($LoFondoPubli, 6);}
    }
    
    function getPublicidadBodyFooter(){
    	$LbFondoPubli = get_field('visiblidadbodyfooter', 'options');
		$LoFondoPubli = get_field('publicidadbodyfooter',  'options');		
		if($LbFondoPubli and $LoFondoPubli){getPublicidad($LoFondoPubli, 6);}
    }
    
    function getPublicidadFooter(){		
		$LbFondoPubli 	  = get_field('visiblidadfooter',   'options');
		$LoFondoPubli01   = get_field('publicidadfooter01',  'options');
		$LoFondoPubli02   = get_field('publicidadfooter02',  'options');
		$LoFondoDimencion = get_field('publifooterposicion', 'options');
		
		if($LbFondoPubli and $LoFondoPubli01 and $LoFondoDimencion == 1){
			getPublicidadBloque($LoFondoPubli01);
		}else if($LbFondoPubli and $LoFondoPubli01 and $LoFondoPubli02 and $LoFondoDimencion == 2){
			getPublicidadBloque($LoFondoPubli01, 2);
			getPublicidadBloque($LoFondoPubli02, 2, 'right');
		}else if($LbFondoPubli and $LoFondoPubli01 and $LoFondoPubli02 and $LoFondoDimencion == 3){
			getPublicidadBloque($LoFondoPubli01, 3);
			getPublicidadBloque($LoFondoPubli02, 1, 'right');
		}else if($LbFondoPubli and $LoFondoPubli01 and $LoFondoPubli02 and $LoFondoDimencion == 4){
			getPublicidadBloque($LoFondoPubli01, 1);
			getPublicidadBloque($LoFondoPubli02, 3, 'right');
		}
		echo '<div class="clearfix"></div>';
    }
    
    function getPublicidadBloque($PoPubli, $PnMedida = 0, $PnLeft = 'left'){
    	$LnMedidas = get_field('medidasinter', $PoPubli->ID);
		$LnFormato = get_field('publiformat', $PoPubli->ID);
		
		if($LnFormato == 1){
			$LsArchivo = get_field('publiimagen', $PoPubli->ID);
		}else{
			$LsArchivo = get_field('publiarchi', $PoPubli->ID);
		}
		
		if($LnMedidas != 9 and $LsArchivo){
			$LsUrl 	   = get_field('publiurl', $PoPubli->ID);
			$LaMedidas = array(
                1 => array(234, 100, 0),
                2 => array(250, 100, 0),
                3 => array(495, 100, 0),
                4 => array(500, 100, 1),
                5 => array(500, 100, 2),
                6 => array(728, 100, 0),
                7 => array(750, 100, 0),
                8 => array(1000, 100, 0)
            );
            
            if($LnFormato == 1){
            	$LsArchivo = '<img src="'. $LsArchivo .'" width="'. $LaMedidas[$LnMedidas][0] .'" height="'. $LaMedidas[$LnMedidas][1] .'"/>';	
            }else{
            	$LsArchivo = '<iframe allowtransparency="true"  width="'. $LaMedidas[$LnMedidas][0] .'" height="'. $LaMedidas[$LnMedidas][1] .'" src="'. $LsArchivo .'"></iframe>';
            }
            
            $LsComodin = '';
            if($LnMedidas == 4){
            	$LsComodin = 'float: left;';
            }else if($LnMedidas == 5){
            	$LsComodin = 'float: right;';
            }
            
            $LnAncho = 1000;
            if($PnMedida == 1){
            	$LnAncho = 749;
            }else if($PnMedida == 2){
            	$LnAncho = 499;
            }else if($PnMedida == 3){
            	$LnAncho = 249;
            }
            
            if(empty($LsUrl)){
            	echo '<div style="float: '. $PnLeft .'; width: '. $LnAncho .'px; height: 100px; overflow: hidden;"><div class="contePubliGeneral" style="width: '. $LaMedidas[$LnMedidas][0] .'px; '. $LsComodin .'">'. $LsArchivo .'</div></div>';
            }else{
            	echo '<div style="float: '. $PnLeft .'; width: '. $LnAncho .'px; height: 100px; overflow: hidden;"><a data-idem="'. $PoPubli->ID .'" class="contePubliGeneral classVotoClick" href="'. $LsUrl .'" target="_blank" style="width: '. $LaMedidas[$LnMedidas][0] .'px; '. $LsComodin .'">'. $LsArchivo .'</a></div>';
            }
		}
    }
    
    function getPublicidad($PoPubli, $LnRestricc = 0){
    	$LnMedidas = get_field('medidasinter', $PoPubli->ID);
		$LnFormato = get_field('publiformat', $PoPubli->ID);
		
		if($LnFormato == 1){
			$LsArchivo = get_field('publiimagen', $PoPubli->ID);
		}else{
			$LsArchivo = get_field('publiarchi', $PoPubli->ID);
		}
		
		if($LnRestricc > 0 and $LnMedidas >= $LnRestricc){
			return;
		}
		
		if($LnMedidas != 9 and $LsArchivo){
			$LsUrl 	   = get_field('publiurl', $PoPubli->ID);
			$LaMedidas = array(
                1 => array(234, 100, 0),
                2 => array(250, 100, 0),
                3 => array(495, 100, 0),
                4 => array(500, 100, 1),
                5 => array(500, 100, 2),
                6 => array(728, 100, 0),
                7 => array(750, 100, 0),
                8 => array(1000, 100, 0)
            );
            
            if($LnFormato == 1){
            	$LsArchivo = '<img src="'. $LsArchivo .'" width="'. $LaMedidas[$LnMedidas][0] .'" height="'. $LaMedidas[$LnMedidas][1] .'"/>';	
            }else{
            	$LsArchivo = '<iframe allowtransparency="true"  width="'. $LaMedidas[$LnMedidas][0] .'" height="'. $LaMedidas[$LnMedidas][1] .'" src="'. $LsArchivo .'"></iframe>';
            }
            
            $LsComodin = '';
            if($LnMedidas == 4){
            	$LsComodin = 'float: left;';
            }else if($LnMedidas == 5){
            	$LsComodin = 'float: right;';
            }
            
            if($LnRestricc == -1){
            	$LsComodin.= ' margin-top: 10px;';
            }
            
            if(empty($LsUrl)){
            	echo '<div class="contePubliGeneral" style="width: '. $LaMedidas[$LnMedidas][0] .'px; '. $LsComodin .'">'. $LsArchivo .'</div>';
            }else{
            	echo '<a data-idem="'. $PoPubli->ID .'" class="contePubliGeneral classVotoClick" href="'. $LsUrl .'" target="_blank" style="width: '. $LaMedidas[$LnMedidas][0] .'px; '. $LsComodin .'">'. $LsArchivo .'</a>';
            }
		}
    }
    
    function getPublicPublicacion($PnIdem, $PnLugar, $PnDonde, $PbActivo, $LbValidoIzq = false, $PnMedidaFinal = 670){
    	if($PbActivo and $PnLugar == $PnDonde and $PnIdem){
    		$LnMedidas = get_field('medidasflota', $PnIdem->ID);
			$LnFormato = get_field('publiformat', $PnIdem->ID);
			
			if($LnFormato == 1){
				$LsArchivo = get_field('publiimagen', $PnIdem->ID);
			}else{
				$LsArchivo = get_field('publiarchi', $PnIdem->ID);
			}
			
			if($LnMedidas != 1 and $LsArchivo){
				$LsUrl 	   = get_field('publiurl', $PnIdem->ID);
				$LaMedidas = array(
	                2 => array(100, 100),
	                3 => array(100, 50),
	                4 => array(63, 100),
	                5 => array(50, 100),
	                6 => array(27, 100)
	            );
	            
	            $LnAncho = $PnMedidaFinal;
	            if($LaMedidas[$LnMedidas][0] == 100){
	            	$LnWidth = $LnAncho;	
	            }else{
	            	$LnActual = $LaMedidas[$LnMedidas][0] / 100;
	            	$LnWidth  = round($LnAncho * $LnActual);
	            }
	            
	            if($LnFormato == 1){
	            	$LsArchivo = '<img src="'. $LsArchivo .'" width="'. $LnWidth .'" height="'. $LaMedidas[$LnMedidas][1] .'"/>';	
	            }else{
	            	$LsArchivo = '<iframe allowtransparency="true"  width="'. $LnWidth .'" height="'. $LaMedidas[$LnMedidas][1] .'" src="'. $LsArchivo .'"></iframe>';
	            }
	            
	            $LsComodin = '';
	            if($PnLugar == 3 and $LbValidoIzq){
	            	$LsComodin = 'position: absolute; left: -'. ($LnWidth + 6).'px;';
	            }
	            
	            if(empty($LsUrl)){
	            	echo '<div class="contePubliFlotante" style="width: '. $LnWidth .'px; height: '. $LaMedidas[$LnMedidas][1] .'px; '. $LsComodin .'">'. $LsArchivo .'</div>';
	            }else{
	            	echo '<a data-idem="'. $PnIdem->ID .'" class="contePubliFlotante classVotoClick" href="'. $LsUrl .'" target="_blank" style="width: '. $LnWidth .'px; height: '. $LaMedidas[$LnMedidas][1] .'px; '. $LsComodin .'">'. $LsArchivo .'</a>';
	            }
			}
    	}
    }
    
    add_action("wp_ajax_my_click", "my_click");
    function my_click(){
    	$LnValor = get_post_meta($_POST['idem'], 'clicks', true);
    	
    	if(!$LnValor){
    		$LnValor = 0;
    	}
    	
    	$LnValor = $LnValor + 1;
    	if(!update_post_meta($_POST['idem'], 'clicks', $LnValor)){
            add_post_meta($_POST['idem'], 'clicks', $LnValor);
        }
        
        echo 'ok-vida';
        die();
    }
    
    function setPostViews($postID){
        global $post_cookie;
        $post_cookie = false;
        
        $id = 'new_' . md5($postID);
        
        if (!isset($_COOKIE[$id])){
            $count_key = 'post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            if ($count == ''){
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            }else{
                $count++;
                update_post_meta($postID, $count_key, $count);
            }
            $post_cookie = $id;
        }
    }
    
    function ucc_get_calendar($post_types = '', $initial = false, $echo = true, $month_interval = false)
    {
        global $wpdb, $m, $monthnum, $year, $wp_locale, $posts;
        if (empty($post_types) || !is_array($post_types))
        {
            $args = array('public' => true, '_builtin' => false);
            $output = 'names';
            $operator = 'and';
            $post_types = get_post_types($args, $output, $operator);
            $post_types = array_merge($post_types, array('post'));
        } else
        {
            $my_post_types = array();
            foreach ($post_types as $post_type)
            {
                if (post_type_exists($post_type)) $my_post_types[] = $post_type;
            }
            $post_types = $my_post_types;
        }
        $post_types_key = implode('', $post_types);
        $post_types = "'" . implode("' , '", $post_types) . "'";
        $cache = array();
        $key = md5($m . $monthnum . $year . $post_types_key);
        if (!is_array($cache)) $cache = array();
        // Quick check. If we have no posts at all, abort!
        if (!$posts)
        {
            $sql = "SELECT 1 as test FROM $wpdb->posts WHERE post_type IN ( $post_types ) AND post_status = 'publish' LIMIT 1";
            $gotsome = $wpdb->get_var($sql);
            if (!$gotsome)
            {
                $cache[$key] = '';
                wp_cache_set('get_calendar', $cache, 'calendar');
                return;
            }
        }
        if (isset($_GET['w'])) $w = '' . intval($_GET['w']);
        // week_begins = 0 stands for Sunday
        $week_begins = intval(get_option('start_of_week'));
        // Let's figure out when we are
        if (!empty($monthnum) && !empty($year))
        {
            $thismonth = '' . zeroise(intval($monthnum), 2);
            $thisyear = '' . intval($year);
        } elseif (!empty($w))
        {
            // We need to get the month from MySQL
            $thisyear = '' . intval(substr($m, 0, 4));
            $d = (($w - 1) * 7) + 6; //it seems MySQL's weeks disagree with PHP's
            $thismonth = $wpdb->get_var("SELECT DATE_FORMAT( ( DATE_ADD( '${thisyear}0101' , INTERVAL $d DAY ) ) , '%m' ) ");
        } elseif (!empty($m))
        {
            $thisyear = '' . intval(substr($m, 0, 4));
            if (strlen($m) < 6) $thismonth = '01';
            else  $thismonth = '' . zeroise(intval(substr($m, 4, 2)), 2);
        } else
        {
            $thisyear = gmdate('Y', current_time('timestamp'));
            $thismonth = gmdate('m', current_time('timestamp'));
            $thismonth = $month_interval ? $thismonth . $month_interval : $thismonth;
        }
        $unixmonth = mktime(0, 0, 0, $thismonth, 1, $thisyear);
        // Get the next and previous month and year with at least one post
        $previous = $wpdb->get_row("SELECT DISTINCT MONTH( post_date ) AS month , YEAR( post_date ) AS year
    FROM $wpdb->posts
    WHERE post_date < '$thisyear-$thismonth-01'
    AND post_type IN ( $post_types ) AND post_status = 'publish'
      ORDER BY post_date DESC
      LIMIT 1");
        $next = $wpdb->get_row("SELECT DISTINCT MONTH( post_date ) AS month, YEAR( post_date ) AS year
    FROM $wpdb->posts
    WHERE post_date > '$thisyear-$thismonth-01'
    AND MONTH( post_date ) != MONTH( '$thisyear-$thismonth-01' )
    AND post_type IN ( $post_types ) AND post_status = 'publish'
      ORDER  BY post_date ASC
      LIMIT 1");
        /* translators: Calendar caption: 1: month name, 2: 4-digit year */
        $calendar_caption = _x('%1$s %2$s', 'calendar caption');
        $calendar_output = '<table id="wp-calendar" summary="' . esc_attr__('Calendar') .
            '">
  <caption>' . sprintf($calendar_caption, $wp_locale->
            get_month($thismonth), date('Y', $unixmonth)) .
            '</caption>
  <thead>
  <tr>';
        $myweek = array();
        for ($wdcount = 0; $wdcount <= 6; $wdcount++)
        {
            $myweek[] = $wp_locale->get_weekday(($wdcount + $week_begins) % 7);
        }
        $dcount = 0;
        foreach ($myweek as $wd)
        {
            $day_name = (true == $initial) ? $wp_locale->get_weekday_initial($wd) : $wp_locale->
                get_weekday_abbrev($wd);
            $wd = esc_attr($wd);
            $calendar_output .= "\n\t\t<th scope=\"col\">";
            if ($dcount > 4)
            {
                $calendar_output .= "<span style='color:#990000;'>";
            }
            $calendar_output .= $day_name;
            if ($dcount > 4)
            {
                $calendar_output .= "</span>";
            }
            $calendar_output .= "</th>";
            $dcount++;
        }
        $calendar_output .= '
  </tr>
  </thead>
  <tfoot>
  <tr>';
        if ($previous)
        {
            $calendar_output .= "\n\t\t" . '<td colspan="3" id="prev"><a href="' .
                get_month_link($previous->year, $previous->month) . '" title="' . sprintf(__('View posts for %1$s %2$s'),
                $wp_locale->get_month($previous->month), date('Y', mktime(0, 0, 0, $previous->
                month, 1, $previous->year))) . '">&laquo; ' . $wp_locale->get_month_abbrev($wp_locale->
                get_month($previous->month)) . '</a></td>';
        } else
        {
            $calendar_output .= "\n\t\t" .
                '<td colspan="3" id="prev" class="pad">&nbsp;</td>';
        }
        $calendar_output .= "\n\t\t" . '<td class="pad">&nbsp;</td>';
        if ($next)
        {
            $calendar_output .= "\n\t\t" . '<td colspan="3" id="next"><a href="' .
                get_month_link($next->year, $next->month) . '" title="' . esc_attr(sprintf(__('View posts for %1$s %2$s'),
                $wp_locale->get_month($next->month), date('Y', mktime(0, 0, 0, $next->month, 1,
                $next->year)))) . '">' . $wp_locale->get_month_abbrev($wp_locale->get_month($next->
                month)) . ' &raquo;</a></td>';
        } else
        {
            $calendar_output .= "\n\t\t" .
                '<td colspan="3" id="next" class="pad">&nbsp;</td>';
        }
        $calendar_output .= '
  </tr>
  </tfoot>
  <tbody>
  <tr>';
        // Get days with posts
        $dayswithposts = $wpdb->get_results("SELECT DISTINCT DAYOFMONTH( post_date )
    FROM $wpdb->posts WHERE MONTH( post_date ) = '$thismonth'
    AND YEAR( post_date ) = '$thisyear'
    AND post_type IN ( $post_types ) AND post_status = 'publish'
    AND post_date < '" . current_time('mysql') . '\'', ARRAY_N);
        if ($dayswithposts)
        {
            foreach ((array )$dayswithposts as $daywith)
            {
                $daywithpost[] = $daywith[0];
            }
        } else
        {
            $daywithpost = array();
        }
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || stripos($_SERVER['HTTP_USER_AGENT'],
            'camino') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'safari') !== false) 
                $ak_title_separator = "\n";
        else  $ak_title_separator = ', ';
        $ak_titles_for_day = array();
        $ak_post_titles = $wpdb->get_results("SELECT ID, post_title, DAYOFMONTH( post_date ) as dom " .
            "FROM $wpdb->posts " . "WHERE YEAR( post_date ) = '$thisyear' " .
            "AND MONTH( post_date ) = '$thismonth' " . "AND post_date < '" . current_time('mysql') .
            "' " . "AND post_type IN ( $post_types ) AND post_status = 'publish'");
        if ($ak_post_titles)
        {
            foreach ((array )$ak_post_titles as $ak_post_title)
            {
                $post_title = esc_attr(apply_filters('the_title', $ak_post_title->post_title, $ak_post_title->
                    ID));
                if (empty($ak_titles_for_day['day_' . $ak_post_title->dom])) $ak_titles_for_day['day_' .
                        $ak_post_title->dom] = '';
                if (empty($ak_titles_for_day["$ak_post_title->dom"])) // first one
                         $ak_titles_for_day["$ak_post_title->dom"] = $post_title;
                else  $ak_titles_for_day["$ak_post_title->dom"] .= $ak_title_separator . $post_title;
            }
        }
        // See how much we should pad in the beginning
        $pad = calendar_week_mod(date('w', $unixmonth) - $week_begins);
        if (0 != $pad) $calendar_output .= "\n\t\t" . '<td colspan="' . esc_attr($pad) .
                '" class="pad">&nbsp;</td>';
        $daysinmonth = intval(date('t', $unixmonth));
        for ($day = 1; $day <= $daysinmonth; ++$day)
        {
            if (isset($newrow) && $newrow) $calendar_output .= "\n\t</tr>\n\t<tr>\n\t\t";
            $newrow = false;
            if ($day == gmdate('j', current_time('timestamp')) && $thismonth == gmdate('m',
                current_time('timestamp')) && $thisyear == gmdate('Y', current_time('timestamp'))) 
                    $calendar_output .= '<td id="today">';
            else  $calendar_output .= '<td>';
            if (in_array($day, $daywithpost)) // any posts today?
                     $calendar_output .= '<a href="' . get_day_link($thisyear, $thismonth, $day) . "\" title=\"" .
                    esc_attr($ak_titles_for_day[$day]) . "\">$day</a>";
            else  $calendar_output .= $day;
            $calendar_output .= '</td>';
            if (6 == calendar_week_mod(date('w', mktime(0, 0, 0, $thismonth, $day, $thisyear)) -
                $week_begins)) $newrow = true;
        }
        $pad = 7 - calendar_week_mod(date('w', mktime(0, 0, 0, $thismonth, $day, $thisyear)) -
            $week_begins);
        if ($pad != 0 && $pad != 7) $calendar_output .= "\n\t\t" .
                '<td class="pad" colspan="' . esc_attr($pad) . '">&nbsp;</td>';
        $calendar_output .= "\n\t</tr>\n\t</tbody>\n\t</table>";
        $cache[$key] = $calendar_output;
        wp_cache_set('get_calendar', $cache, 'calendar');
        remove_filter('get_calendar', 'ucc_get_calendar_filter');
        $output = apply_filters('get_calendar', $calendar_output);
        add_filter('get_calendar', 'ucc_get_calendar_filter');
        if ($echo) echo $output;
        else  return $output;
    }
    
	add_action('wp_logout', 'rt_logoutRedirect');
	function rt_logoutRedirect(){
        //wp_redirect(site_url().'/login/');
        exit();
	}

	function __my_registration_redirect(){
//    	wp_redirect(site_url().'/login/');
  }


/**
 * Agregar informacion extra al usuario
 */
add_filter( 'registration_redirect', '__my_registration_redirect' );
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

/**
 * Agrega las opciones al admin de WordPress
 */
function extra_user_profile_fields( $user ) { 
global $paises;
  echo '<h3>Informacion extra</h3>
        <table class="form-table">
        <tr>
          <th><label for="address">Direccion</label></th>
          <td>
            <textarea name="address" id="address">' .esc_attr( get_the_author_meta( 'address', $user->ID ) ). '</textarea><br />
            <span class="description">Por favor ingrese su direccion</span>
          </td>
        </tr>
        <tr>
          <th><label for="city">Ciudad</label></th>
          <td>
            <input type="text" name="city" id="city" value="'. esc_attr( get_the_author_meta( 'city', $user->ID ) ) .'" class="regular-text" /><br />
            <span class="description">Por favor ingrese su ciudad</span>
          </td>
        </tr>
        <tr>
          <th><label for="country">Pais</label></th>
          <td>
            <select name="country" id="country">
              '.getPaises(esc_attr( get_the_author_meta( 'country', $user->ID ) )) .'  
            </select>
            <br />
            <span class="description">Por favor eliga su pais.</span>
          </td>
        </tr>
        <tr>
          <th><label for="phone">Telefono</label></th>
          <td>
            <input type="text" name="phone" id="phone" value="'. esc_attr( get_the_author_meta( 'phone', $user->ID ) ) .'" class="regular-text" /><br />
            <span class="description">Por favor ingrese su telefono</span>
          </td>
        </tr>
    </table>';
}
/**
 * Guarda los datos extra del usuario
 */
function save_extra_user_profile_fields( $user_id ) {
  if ( !current_user_can( 'edit_user', $user_id ) ) { 
    return false; 
  }
  update_user_meta( $user_id, 'address', $_POST['address'] );
  update_user_meta( $user_id, 'city', $_POST['city'] );
  update_user_meta( $user_id, 'country', $_POST['country'] );
  update_user_meta( $user_id, 'phone', $_POST['phone'] );
}


// Agrega las opciones de usuario al hook de wordpress
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

/**
 * Regresa los paises como option's para un select
 * @param string $selected El pais que esta seleccionado
 * @return string
 */
function getPaises($selected = false){
  global $paises;
  $return = '';
  if( $selected == false || empty($selected))
    $return .= "<option>Seleccione uno</option>";
  foreach($paises as $pais){
    $is_selected = ($selected === $pais) ? "selected=\"selected\"" : '';
    $return .= "<option value=\"".$pais."\"".$is_selected.">".$pais."</option>";
  }
  return $return;
}

/**
 * Arreglo con los paises
 * @var Array
 */
$paises = array(
  'España', 'Argentina', 'México',
  'Afganistán' , 'Albania' , 'Alemania' , 'Andorra' , 'Angola' , 
  'Antigua y Barbuda' , 'Antillas Holandesas' , 'Arabia Saudí' , 
  'Argelia' ,'Armenia' , 'Aruba' , 'Australia' , 
  'Austria' , 'Azerbaiyán' , 'Bahamas' , 'Bahrein' , 'Bangladesh' , 
  'Barbados' , 'Bélgica' , 'Belice' , 'Benín' , 'Bermudas' , 'Bielorrusia' , 
  'Bolivia' , 'Botswana' , 'Bosnia' , 'Brasil' , 'Brunei' , 'Bulgaria' , 
  'BurkinaFaso' , 'Burundi' , 'Bután' , 'Cabo Verde' , 'Camboya' , 
  'Camerún' , 'Canadá' , 'Chad' , 'Chile' , 'China' , 'Chipre' , 'Colombia' , 
  'Comoras' , 'Congo' , 'Corea del Norte' , 'Corea del Sur' , 'Costa de Marfil' , 
  'Costa Rica' , 'Croacia' , 'Cuba' , 'Dinamarca' , 'Dominica' , 'Dubai' , 
  'Ecuador' , 'Egipto' , 'El Salvador' , 'Emiratos Árabes Unidos' , 'Eritrea' , 
  'Eslovaquia' , 'Eslovenia' ,'Estados Unidos de América' , 'Estonia' , 
  'Etiopía' , 'Fiyi' , 'Filipinas' , 'Finlandia' , 'Francia' , 'Gabón' , 'Gambia' , 
  'Georgia' , 'Ghana' , 'Grecia' , 'Guam' , 'Guatemala' , 'Guayana Francesa' , 
  'Guinea-Bissau' , 'Guinea Ecuatorial' , 'Guinea' , 'Guyana' , 'Granada' , 
  'Haití' , 'Honduras' , 'HongKong' , 'Hungría' , 'Holanda' , 'India' , 'Indonesia' , 
  'Irak' , 'Irán' , 'Irlanda' , 'Islandia' , 'Islas Caimán' , 'Islas Marshall' , 
  'Islas Pitcairn' , 'Islas Salomón' , 'Israel' , 'Italia' , 'Jamaica' , 'Japón' , 
  'Jordania' , 'Kazajstán' , 'Kenia' , 'Kirguistán' , 'Kiribati' , 'Kósovo' , 
  'Kuwait' , 'Laos' , 'Lesotho' , 'Letonia' , 'Líbano' , 'Liberia' , 'Libia' , 
  'Liechtenstein' , 'Lituania' , 'Luxemburgo' , 'Macedonia' , 'Madagascar' , 
  'Malasia' , 'Malawi' , 'Maldivas' , 'Malí' , 'Malta' , 'Marianas del Norte' , 
  'Marruecos' , 'Mauricio' , 'Mauritania' ,'Micronesia' , 'Mónaco' , 
  'Moldavia' , 'Mongolia' , 'Montenegro' , 'Mozambique' , 'Myanmar' , 'Namibia' , 
  'Nauru' , 'Nepal' , 'Nicaragua' , 'Níger' , 'Nigeria' , 'Noruega' , 'NuevaZelanda' , 
  'Omán' , 'OrdendeMalta' , 'Países Bajos' , 'Pakistán' , 'Palestina' , 'Palau' , 
  'Panamá' , 'Papúa Nueva Guinea' , 'Paraguay' , 'Perú' , 'Polonia' , 'Portugal' , 
  'Puerto Rico' , 'Qatar' , 'Reino Unido' , 'República Centro africana' , 
  'República Checa' , 'República del Congo' , 'República Democrática del Congo' , 
  'República Dominicana' , 'Ruanda' , 'Rumania' , 'Rusia' , 'Sáhara Occidental' , 
  'SaintKitts-Nevis' , 'Samoa Americana' , 'Samoa' , 'San Marino' , 'Santa Lucía' , 
  'Santo Tomé y Príncipe' , 'San Vicente y las Granadinas' , 'Senegal' , 'Serbia' , 
  'Seychelles' , 'SierraLeona' , 'Singapur' , 'Siria' , 'Somalia' , 'SriLanka' , 
  'Sudáfrica' , 'Sudán' , 'Suecia' , 'Suiza' , 'Suazilandia' , 'Tailandia' , 'Taiwán' , 
  'Tanzania' , 'Tayikistán' , 'Tíbet' , 'TimorOriental' , 'Togo' , 'Tonga' , 
  'Trinidad y Tobago' , 'Túnez' , 'Turkmenistán' , 'Turquía' , 'Tuvalu' , 'Ucrania' , 
  'Uganda' , 'Uruguay' , 'Uzbequistán' , 'Vanuatu' , 'Vaticano' , 'Venezuela' , 
  'Vietnam' , 'WallisyFutuna' , 'Yemen' , 'Yibuti' , 'Zambia' , 'Zaire' , 'Zimbabue'
);
