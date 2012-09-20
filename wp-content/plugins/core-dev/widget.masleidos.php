<?php
    /*
        Plugin Name: MundoToro - WIDGET Los mas leidos
        Description: Este WIDGET muestra unos 'tabs' con lo Más Leído y lo Más Comentado
        Version: 1.0
        Author: Abimael
        License: GPLv2 o posterior
    */

    add_action('widgets_init', create_function('', 'register_widget("MT_Widget_Most_Read");'));

    class MT_Widget_Most_Read extends WP_Widget {  

        function __construct() {  
            parent::__construct(false, 'MundoToro - M&aacute;s Leidos');  
        }  
    
        function update($new_instance, $old_instance){
            $instance = $old_instance;
            $instance['limit'] = strip_tags($new_instance['limit']);
            return $instance;
        }
    
        function form($instance){
            $instance = wp_parse_args((array) $instance, array('limit' => '10'));
            $LsLimit = strip_tags($instance['limit']);
            $LsIdemLimit = $this->get_field_id('limit');
            
            echo '
                <p>
                    <label for="'. $LsIdemLimit .'">Limite del Listado:</label>
                        <input class="widefat" id="'. $LsIdemLimit .'" name="'. $this->get_field_name('limit') .'" type="text" value="'. esc_attr($LsLimit) .'" />
                </p>';
    
        }
    
        function widget($args, $instance){
            $LsLimit = strip_tags($instance['limit']);
            
            echo '
            <span id="tabs-right" class="most-read">
                <ul class="tabs">
                    <li><a class="active" rel="most-read">M&aacute;s Le&iacute;dos</a></li>
                </ul>
                <span id="most-read" class="most-read-tab">
                    <ol>';
              
            $args = array('posts_per_page'=> $LsLimit, 'meta_key' => 'post_views_count', 'orderby' => 'meta_value_num', 'post_type'=> 'postfullmt' );
            $loop = new WP_Query( $args );
            
            while ($loop->have_posts()): $loop->the_post();
                echo '<li><a href="'. get_permalink() .'">' .get_the_title(). '</a></li>';
            endwhile; 
    
            echo'
                    </ol>
                    
                </span>
            </span>';
			//<a class="list-link" href="'.site_url().'/mas-leidos/">Ver lista completa &gt;</a>
        }
    }  