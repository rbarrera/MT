<?php

    /*
        Plugin Name: MundoToro - WIDGET Publicidad
        Description: Este WIDGET muestra publicidad
        Version: 1.0
        Author: Abimael
        License: GPLv2 o posterior
    */
    
    add_action('widgets_init', create_function('', 'register_widget("MT_Widget_Ads");'));

    class MT_Widget_Ads extends WP_Widget {  
        function __construct(){
            parent::__construct('mt-widget-publicidad', 'MundoToro - Publicidad Lateral',
                array(
                    'description' => 'Cuadro para poner publicidad tipo Lateral'
                )
    		);
        }
        
        function widget($args, $instance) {  
            extract($args, EXTR_SKIP);
            
            if($instance['tipo'] == 1){
            	if(!empty($instance['img']) and !empty($instance['width']) and !empty($instance['height'])){
	            	$LsArchivo = '<img src="'. $instance['img'] .'" width="'. $instance['width'] .'" height="'. $instance['height'] .'"/>';
	            	if(empty($instance['uri'])){
		            	echo '<div style="width: '. $instance['width'] .'px;" class="'. $instance['class'] .'">'. $LsArchivo .'</div>';
		            }else{
		            	echo '<a href="'. $instance['uri'] .'" target="_blank"  class="'. $instance['class'] .'">'. $LsArchivo .'</a>';
		            }
	            }
            }else{
            	$LnIdemPubli = $instance['idem'];
            	if($LnIdemPubli and !empty($LnIdemPubli)){
            		$LnMedidas = get_field('medidasflota', $LnIdemPubli);
					$LnFormato = get_field('publiformat', $LnIdemPubli);
					
					if($LnFormato == 1){
						$LsArchivo = get_field('publiimagen', $LnIdemPubli);
					}else{
						$LsArchivo = get_field('publiarchi', $LnIdemPubli);
					}
					
					if($LnMedidas == 1 and $LsArchivo){
						$LsUrl 	   = get_field('publiurl', $LnIdemPubli);
						
						if($LnFormato == 1){
			            	$LsArchivo = '<img src="'. $LsArchivo .'" width="300"/>';	
			            }else{
			            	$LsArchivo = '<iframe allowtransparency="true" width="300" height="250" src="'. $LsArchivo .'"></iframe>';
			            }
			            
			            if(empty($LsUrl)){
			            	echo '<div class="" style="width: 300px;">'. $LsArchivo .'</div>';
			            }else{
			            	echo '<a data-idem="'. $LnIdemPubli .'" class="classVotoClick" href="'. $LsUrl .'" target="_blank" style="width: 300px;">'. $LsArchivo .'</a>';
			            }
					}
            	}
            }
        }
      
        function update($new_instance, $old_instance){
            $instance = $old_instance;
            
            $instance['idem']   = strip_tags($new_instance['idem']);
            $instance['tipo']   = strip_tags($new_instance['tipo']);
            $instance['uri']    = strip_tags($new_instance['uri']);
            $instance['img']    = strip_tags($new_instance['img']);
            $instance['width']  = strip_tags($new_instance['width']);
            $instance['height'] = strip_tags($new_instance['height']);
            $instance['class']  = strip_tags($new_instance['class']);
            
            return $instance;
        }
      
        function form($instance){
        	$instance       = wp_parse_args((array) $instance, array('idem' => 0, 'uri' => '', 'tipo' => '', 'img' => '', 'width' => '', 'height' => '', 'class' => ''));
        	
        	$LnIdem			= $instance['idem'];
        	$LsIdemID       = $this->get_field_id('idem');
        	
            $LsURI          = strip_tags($instance['uri']);
            $LsIdemURI      = $this->get_field_id('uri');
            
            $LsTIPO         = strip_tags($instance['tipo']);
            $LsIdemTIPO     = $this->get_field_id('tipo');
            
            $LsIMG          = strip_tags($instance['img']);
            $LsIdemIMG      = $this->get_field_id('img');
            
            $LsWidth        = strip_tags($instance['width']);
            $LsIdemWidth    = $this->get_field_id('width');
            
            $LsHeight       = strip_tags($instance['height']);
            $LsIdemHeight   = $this->get_field_id('height');
            
            $LsClass        = strip_tags($instance['class']);
            $LsIdemClass    = $this->get_field_id('class');
            
            $LsArguTaxi 	= array(
				array(
					'taxonomy' 	=> 'tipostaximt',
					'field' 	=> 'slug',
					'terms' 	=> 'flotante'
				)
			);
			
            $LaArgu = array(
                'post_type'  => 'postpublicimt',
                'tax_query'  => $LsArguTaxi,
                'meta_query' => array(
					array(
						'key' 		=> 'medidasflota',
						'value' 	=> 1,
						'type'		=> 'NUMERIC'
					)
				)
            );
            
            $LaSelect = '';
            $the_query = new WP_Query($LaArgu);
            while ($the_query->have_posts()) : $the_query->the_post();
            	global $post;
                $selected = $LnIdem == $post->ID ? 'selected="selected" ' : '';
                $LaSelect.= '<option value="'. $post->ID .'" '.$selected.'>'. get_the_title() .'</option>';
            endwhile;
            
            echo '
                <p>
                    <label for="'. $LsIdemTIPO .'" style="padding: 10px 0px 3px; display: block;">Tipo de publicidad</label>
                    <select id="'. $LsIdemTIPO .'" name="'. $this->get_field_name('tipo') .'" style="width: 224px;">
                        <option value="0" '. (($LsTIPO == 0) ? 'selected="selected"' : '') .'>Interma</option>
                        <option value="1" '. (($LsTIPO == 1) ? 'selected="selected"' : '') .'>Externa</option>
                    </select><br>
                    
                    <h3 style="margin-bottom: 0px;">Interna</h3>
                    <label for="'. $LsIdemID .'" style="padding: 10px 0px 3px; display: block;">Selecciona el Nombre de la publicidad</label>
                    <select id="'. $LsIdemID .'" name="'. $this->get_field_name('idem') .'" style="width: 224px;">
                    <option value="0">Seleccione una publicidad</option>'. $LaSelect .'</select><br>
                    
                    <div class="classwdexterna">
                    	<h3 style="margin-bottom: 0px;">Externa</h3>
	                    <label for="'. $LsIdemURI .'" style="padding: 10px 0px 3px; display: block;">Link:</label>
	                    <input class="widefat" id="'. $LsIdemURI .'" name="'. $this->get_field_name('uri') .'" type="text" value="'. esc_attr($LsURI) .'" />
	                    
	                    <label for="'. $LsIdemIMG .'" style="padding: 10px 0px 3px; display: block;">Imagen (URL):</label>
	                    <input class="widefat" id="'. $LsIdemIMG .'" name="'. $this->get_field_name('img') .'" type="text" value="'. esc_attr($LsIMG) .'" />
	                    
	                    <label for="'. $LsIdemWidth .'" style="padding: 10px 0px 3px; display: block;">Ancho de la imagen:</label>
	                    <input class="widefat" id="'. $LsIdemWidth .'" name="'. $this->get_field_name('width') .'" type="text" value="'. esc_attr($LsWidth) .'" />
	                    
	                    <label for="'. $LsIdemHeight .'" style="padding: 10px 0px 3px; display: block;">Alto de la imagen:</label>
	                    <input class="widefat" id="'. $LsIdemHeight .'" name="'. $this->get_field_name('height') .'" type="text" value="'. esc_attr($LsHeight) .'" />
	                    
	                    <label for="'. $LsIdemClass .'" style="padding: 10px 0px 3px; display: block;">Clase CSS:</label>
	                    <input class="widefat" id="'. $LsIdemClass .'" name="'. $this->get_field_name('class') .'" type="text" value="'. esc_attr($LsClass) .'" />
                    </div>
                </p>
            ';
            
            wp_reset_postdata();
        }
    }  
?>