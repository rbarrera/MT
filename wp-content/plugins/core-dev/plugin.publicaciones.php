<?php

    /*
        Plugin Name: MundoToro - Sistema de publicaciones
        Plugin URI: http://www.informagestudios.com/
        Description: Sistema de publicaciones internas del sistema.
        Version: 1.0
        Author: Ilich Jesus Mascorro Barrera 
        Author URI: http://www.informagestudios.com/
        License: GPLv2 o posterior
    */

    include_once('class.core.php');
    
    
    class CorePublicacion extends coreDevExtends{
        public function __construct(){
            
            $this->crearPost(array('Publicacion', 'Publicaciones'), 'Publicaciones', 'postfullmt', 
                array('title', 'editor', 'comments', 'revisions', 'thumbnail'),
                array('secctaximt', 'tagstaximt', 'ganaderiataximt', 'torerotaximt', 'localidadtaximt', 'paistaximt', 'formataximt')
            );
            
            $this->crearTaxi(array('Seccion', 'Secciones'), 'Secciones', 'secctaximt', 'postfullmt', true, true);
            $this->crearTaxi(array('Tag', 'Tags'), 'Tags', 'tagstaximt', 'postfullmt', false);
            $this->crearTaxi(array('Ganaderia', 'Ganaderias'), 'Ganaderias', 'ganaderiataximt', 'postfullmt');
            $this->crearTaxi(array('Torero', 'Toreros'), 'Toreros', 'torerotaximt', 'postfullmt');
            $this->crearTaxi(array('Localidad', 'Localidades'), 'Localidades', 'localidadtaximt', 'postfullmt');
            $this->crearTaxi(array('Pais', 'Paises'), 'Paises', 'paistaximt', 'postfullmt');
            $this->crearTaxi(array('Forma', 'Formas'), 'Formas', 'formataximt', 'postfullmt');
            
            $this->setFiltroTaxi('secctaximt');
            
            $this->setMenuPrincipal('Publicaciones', 6, 'note');
            $this->addSubMenu('Secciones', 'secctaximt');
            $this->addSubMenu('Tags', 'tagstaximt');
            $this->addSubMenu('Ganaderias', 'ganaderiataximt');
            $this->addSubMenu('Toreros', 'torerotaximt');
            $this->addSubMenu('Localidades', 'localidadtaximt');
            $this->addSubMenu('Paises', 'paistaximt');
            
            $this->addCoreAcciones();
            $this->addCoreFiltros();
            
            //register_options_page('Opciones generales del theme');
            register_options_page('Opciones generales');
            register_options_page('Opciones publicidad');
            //register_options_page('Home');
        }
        
        public function getColumnas($PaColumnas){
            $PaColumnas = array(
                'cb'            => '<input type="checkbox" />',
                'custom_id'     => 'ID',
                'title'         => 'Publicación',
                'secciones'     => 'Secciones',
                'etique'        => 'Etiquetas',
                'vistas'        => 'Visitas',
                'date'          => 'Fecha',
                'comments'      => ''
            );
            
            return $PaColumnas;
        }
        
        public function getSortColumnas(){
            return array(
                'custom_id'     => 'custom_id',
                'vistas'        => 'vistas',
                'title'         => 'title',
                'secciones'     => 'secciones',
                'etique'        => 'etique',
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
                
                case 'secciones':
                    $this->getTaxi($post->ID, 'secctaximt');
                break;
                
                case 'etique':
                    $this->getTaxi($post->ID, 'tagstaximt');
                break;
                
                case 'vistas':
                    echo get_post_meta($post->ID, 'post_views_count', true);
                break;
            }
        }
        
        public function getEditor($initArray){
            $initArray['theme_advanced_buttons3'] = 'media';
            return $initArray;
        }
    }
    
    add_action('init', 'CorePublicacionCall');
    function CorePublicacionCall(){
        new CorePublicacion();
    }
?>