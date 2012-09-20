<?php

    /*
        Plugin Name: MundoToro - WIDGET Vídeos
        Description: Este WIDGET sirve para mostrar un video
        Version: 1.0
        Author: Abimael
        License: GPLv2 o posterior
    */

    add_action('widgets_init', create_function('', 'register_widget("MT_Widget_Video");'));

    class MT_Widget_Video extends WP_Widget {  

        function __construct(){
            parent::__construct(false, 'MundoToro - Video');  
        }

        function update($new_instance, $old_instance){
            $instance = $old_instance;
            
            $instance['uri']        = strip_tags($new_instance['uri']);
            $instance['desc']       = strip_tags($new_instance['desc']);
            $instance['title']      = strip_tags($new_instance['title']);
            $instance['titleh2']    = strip_tags($new_instance['titleh2']);
            $instance['source']     = strip_tags($new_instance['source']);
            return $instance;
        }
        
        function form($instance){

            $instance       = wp_parse_args((array) $instance, array('uri' => '', 'desc' => 'Descripcion'));
            
            $LsURI          = strip_tags($instance['uri']);
            $LsIdemURI      = $this->get_field_id('uri');
            $LsSource       = strip_tags($instance['source']);
            $LsIdemSource   = $this->get_field_id('source');
            $LsDesc         = strip_tags($instance['desc']);
            $LsIdemDesc     = $this->get_field_id('desc');
            $LsTitle        = strip_tags($instance['title']);
            $LsIdemTitle    = $this->get_field_id('title');
            $LsTitleH2      = strip_tags($instance['titleh2']);
            $LsIdemTitleH2  = $this->get_field_id('titleh2');
            
            $yt = $LsSource == 1 ? ' selected="selected" ' : '';
            $vm = $LsSource == 2 ? ' selected="selected" ' : '';
            $mt = $LsSource == 3 ? ' selected="selected" ' : '';

            echo '
                <p>
                    <label for="'. $LsIdemSource .'">Fuente del Video:</label>
                    <select class="widefat" id="'. $LsIdemSource .'" name="'. $this->get_field_name('source') .'">
                        <option '.$yt.' value="1">Youtube</option>
                        <option '.$vm.' value="2">Vimeo</option>
                        <option '.$mt.' value="3">Mundotoro.tv</option>
                    </select>
                    
                    <label for="'. $LsIdemURI .'">ID del Video:</label>
                    <input class="widefat" id="'. $LsIdemURI .'" name="'. $this->get_field_name('uri') .'" type="text" value="'. esc_attr($LsURI) .'" />
                    
                    <label for="'. $LsIdemDes .'">Título:</label>
                    <input class="widefat" id="'. $LsIdemTitleH2 .'" name="'. $this->get_field_name('titleh2') .'" type="text" value="'. esc_attr($LsTitleH2) .'" />
                    
                    <label for="'. $LsIdemDes .'">Descripción:</label>
                    <textarea class="widefat" id="'. $LsIdemDesc .'" name="'. $this->get_field_name('desc') .'" >'. esc_attr($LsDesc) .'</textarea>
                    
                    <label for="'. $LsIdemTitle .'">Leyenda:</label>
                    <input class="widefat" id="'. $LsIdemTitle .'" name="'. $this->get_field_name('title') .'" type="text" value="'. esc_attr($LsTitle) .'" />
                </p>
            ';

        }

        function widget($args, $instance) {  
            $video = '';

            switch ($instance['source']) {
                case 1:
                    $video = '<iframe allowtransparency="true" width="273" height="215" src="http://www.youtube.com/embed/'. $instance['uri'].'?rel=0&autoplay=0&wmode=transparent" frameborder="0" allowfullscreen></iframe>';
                break;   

                case 2:
                    $video = '<iframe allowtransparency="true" src="http://player.vimeo.com/video/'. $instance['uri'].'?title=0&amp;byline=0&amp;portrait=0&autoplay=0&wmode=transparent" width="273" height="215" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                break;

                case 3:
                    $video = '<iframe allowtransparency="true" width="273" scrolling="no" height="155" frameborder="0" src="http://player.qbrick.com/player.aspx?mcid='. $instance['uri'].'&amp;width=273&amp;height=155&amp;as=0&amp;fs=1&amp;rp=0&amp;cb=1&amp;il=1&amp;sp=1&amp;db=0&amp;ct=0&amp;mni=0&wmode=transparent" id="iframe_player">  You need a browser that can handle Iframes to be able to view this page.</iframe>';
                break;

            }

            echo '
                <span class="featured-video">
                    '.$video.'
                    <h2>'.$instance['titleh2'].'</h2>
                    <p>'.$instance['desc'].'</p>
                    <h3>'.$instance['title'].'</h3>
                </span>
            ';
        }  
    }  
