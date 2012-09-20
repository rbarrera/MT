<?php

    /*
        Plugin Name: MundoToro - Sistema de Slider
        Plugin URI: http://www.informagestudios.com/
        Description: Sistema de imagenes Slider.
        Version: 1.0
        Author: Ilich Jesus Mascorro Barrera 
        Author URI: http://www.informagestudios.com/
        License: GPLv2 o posterior
    */

    include_once('class.core.php');
    
    
    class CoreSlide extends coreDevExtends{
        public function __construct(){            
            $this->crearPost(array('Slider', 'Slider'), 'Slider', 'postslidemt', array('title'));
            $this->setMenuPrincipal('Slider', 8, 'attach_image');
            
            $this->addCoreAcciones();
            $this->addCoreFiltros();
        }
        
        public function getColumnas($PaColumnas){
            $PaColumnas = array(
                'cb'            => '<input type="checkbox" />',
                'custom_id'     => 'ID',
                'title'         => 'Nombre del slider',
                'vistas'        => 'Vistas',
                'date'          => 'Fecha'
            );
                        
            return $PaColumnas;
        }
        
        public function getSortColumnas(){
            return array(
                'custom_id'     => 'custom_id',
                'title'         => 'title',
                'vistas'        => 'vistas',
                'date'          => 'date'
            );
        }
        
        public function getEditColumnas($PsColumnas){
            global $post;
            switch ($PsColumnas){
                case 'custom_id':
                    echo $post->ID;
                break;
                
                case 'title':
                    the_title();
                break;
                
                case 'vistas':
                    echo get_post_meta($post->ID, 'vistas', true);
                break;
            }
        }
    }
    
    add_action('init', 'CoreSlideCall');
    function CoreSlideCall(){
        new CoreSlide();
    }
?>