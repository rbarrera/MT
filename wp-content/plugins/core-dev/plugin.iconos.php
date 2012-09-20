<?php

    /*
        Plugin Name: MundoToro - Sistema de Iconos del footer
        Plugin URI: http://www.informagestudios.com/
        Description: Sistema de iconos del footer.
        Version: 1.0
        Author: Ilich Jesus Mascorro Barrera 
        Author URI: http://www.informagestudios.com/
        License: GPLv2 o posterior
    */

    include_once('class.core.php');
    
    
    class CoreIcono extends coreDevExtends{
        public function __construct(){            
            $this->crearPost(array('Icono', 'Iconos'), 'Iconos', 'posticonosmt', array('title'));
            $this->setMenuPrincipal('Iconos', 9, 'equalizer');
            
            $this->addCoreAcciones();
            $this->addCoreFiltros();
        }
        
        public function getColumnas($PaColumnas){
            $PaColumnas = array(
                'cb'            => '<input type="checkbox" />',
                'custom_id'     => 'ID',
                'icono'         => 'Icono',
                'title'         => 'Nombre del icono',
                'posicion'      => 'Posicion',
                'date'          => 'Fecha'
            );
                        
            return $PaColumnas;
        }
        
        public function getSortColumnas(){
            return array(
                'custom_id'     => 'custom_id',
                'title'         => 'title',
                'posicion'      => 'posicion',
                'date'          => 'date'
            );
        }
        
        public function getEditColumnas($PsColumnas){
            global $post;
            switch ($PsColumnas){
                case 'custom_id':
                    echo $post->ID;
                break;
                
                case 'icono':
                    $attachment_id  = get_field('icono');
                    $image          = wp_get_attachment_image_src($attachment_id, 'full');
                    echo '<img src="'. $image[0] .'" />';
                break;
                
                case 'title':
                    the_title();
                break;
                
                case 'posicion':
                    $LaTipo = array(1 => 'Izquierda', 2 => 'Medio', 3 => 'Derecha');
                    echo $LaTipo[get_post_meta($post->ID, 'posiicon', true)];
                break;
            }
        }
    }
    
    add_action('init', 'CoreIconoCall');
    function CoreIconoCall(){
        new CoreIcono();
    }
?>