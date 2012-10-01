<?php

    /*
        Plugin Name: MundoToro - Sistema de publicidad
        Plugin URI: http://www.informagestudios.com/
        Description: Sistema de publicidad del sistema.
        Version: 1.0
        Author: Ilich Jesus Mascorro Barrera 
        Author URI: http://www.informagestudios.com/
        License: GPLv2 o posterior
    */

    include_once('class.core.php');
    
    
    class CorePublicidad extends coreDevExtends{
        public function __construct(){            
            $this->crearPost(array('Publicidad', 'Publicidad'), 'Publicidad', 'postpublicimt', array('title'), array('tipostaximt'),false);
            $this->crearTaxi(array('Tipo', 'Tipos'), 'Tipos', 'tipostaximt', 'postpublicimt');
            
            $this->setFiltroTaxi('tipostaximt');
            $this->setMenuPrincipal('Publicidad', 7, 'television');
            
            $this->addCoreAcciones();
            $this->addCoreFiltros();
        }
        
        public function getColumnas($PaColumnas){
            $PaColumnas = array(
                'cb'            => '<input type="checkbox" />',
                'custom_id'     => 'ID',
                'title'         => 'Identificador',
                'tipo'          => 'Tipo',
                'formato'       => 'Formato',
                'medidas'       => 'Medidas',
                'clicks'        => 'Clicks',
                'date'          => 'Fecha'
            );
                        
            return $PaColumnas;
        }
        
        public function getSortColumnas(){
            return array(
                'custom_id'     => 'custom_id',
                'title'         => 'title',
                'tipo'          => 'tipo',
                'formato'       => 'formato',
                'medidas'       => 'medidas',
                'clicks'        => 'clicks',
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
                
                case 'tipo':
                    $LaTipo = array(1 => 'Integrado', 2 => 'Flotante', 3 => 'Popup');
                    echo $LaTipo[get_post_meta($post->ID, 'publitipo', true)];
                break;
                
                case 'formato':
                    $LaTipo = array(1 => 'Imagen', 2 => 'SWF', 3 => 'HTML5');
                    echo $LaTipo[get_post_meta($post->ID, 'publiformat', true)];
                break;
                
                case 'medidas':
                    $LaDonde = array(1 => 'medidasinter', 2 => 'medidasflota', 3 => 'medidaspop');
                    $LaTipo = array(
                        1   => array(
                            1 => 'Banner - 234 x 100',
                            2 => 'Banner - 250 x 100',
                            3 => 'Banner - 495 x 100',
                            4 => 'Banner - 500 x 100 (Izquierda)',
                            5 => 'Banner - 500 x 100 (Derecha)',
                            6 => 'Banner - 728 x 100',
                            7 => 'Banner - 750 x 100',
                            8 => 'Banner - 1000 x 100',
                            9 => 'Fondo'
                        ),
                        2   => array(
                            1 => 'Sidebar 300 x 250',
                            2 => '100% x 100',
                            3 => '100% x 50',
                            4 => '63% x 100',
                            5 => '50% x 100',
                            6 => '27% x 100'
                        ),
                        3   => array(
                            1 => 'Popup 400 x 400',
                            2 => 'Popup 800 x 600'  
                        )
                    );
                    echo $LaTipo[get_post_meta($post->ID, 'publitipo', true)][get_post_meta($post->ID, $LaDonde[get_post_meta($post->ID, 'publitipo', true)], true)];
                break;
                
                case 'clicks':
                    echo get_post_meta($post->ID, 'clicks', true);
                break;
            }
        }
    }
    
    add_action('init', 'CorePublicidadCall');
    function CorePublicidadCall(){
        new CorePublicidad();
    }
?>
