<?php
    /*
        Plugin Name: Core Desarrollo WP plugins
        Plugin URI: http://www.informagestudios.com/
        Description: Plugin para remodelar funciones internas del motor
        Version: 1.0
        Author: Ilich Jesus Mascorro Barrera 
        Author URI: http://www.informagestudios.com/
        License: GPLv2 o posterior
    */
    
    
    if(!defined('WP_CONTENT_URL'))  define('WP_CONTENT_URL',    get_option('siteurl') .'/wp-content');
    if(!defined('WP_CONTENT_DIR'))  define('WP_CONTENT_DIR',    ABSPATH .'wp-content');
    if(!defined('WP_PLUGIN_URL'))   define('WP_PLUGIN_URL',     WP_CONTENT_URL .'/plugins');
    if(!defined('WP_PLUGIN_DIR'))   define('WP_PLUGIN_DIR',     WP_CONTENT_DIR .'/plugins');
    if(!defined('WP_LANG_DIR'))     define('WP_LANG_DIR',       WP_CONTENT_DIR .'/languages');
    
    /* GLOBALES */
    $LbPersonCampos = true;
    
    
    
    /* PRE AJUSTES */
    if($LbPersonCampos){
        add_action('init', 'regCoreDev',  5, 0);
        function regCoreDev(){
            if(function_exists('register_field')) register_field('Location_field',      WP_PLUGIN_DIR .'/core-dev/addOns/location.php');
            if(function_exists('register_field')) register_field('Tax_field',           WP_PLUGIN_DIR .'/core-dev/addOns/acf-tax.php');
            if(function_exists('register_field')) register_field('Categories_field',    WP_PLUGIN_DIR .'/core-dev/addOns/categories.php');
        }
    }
        
    $LcDevCore;
    add_action('init', 'iniCoreDev');
    function iniCoreDev(){
        global $LcDevCore;
        $LcDevCore = new coreDev();        
    }
    
    add_action('widgets_init', 'QuitarWidgetDefault', 1);
    function QuitarWidgetDefault() {
    	unregister_widget('WP_Widget_Pages');
    	unregister_widget('WP_Widget_Calendar');
    	unregister_widget('WP_Widget_Archives');
    	unregister_widget('WP_Widget_Links');
    	unregister_widget('WP_Widget_Meta');
    	unregister_widget('WP_Widget_Search');
    	unregister_widget('WP_Widget_Text');
    	unregister_widget('WP_Widget_Recent_Posts');
    	unregister_widget('WP_Widget_Recent_Comments');
    	unregister_widget('WP_Widget_RSS');
    	unregister_widget('WP_Widget_Tag_Cloud');
        unregister_widget('WP_Nav_Menu_Widget');
        unregister_widget('WP_Widget_Categories');
    }
    
    
    class coreDev{
        
        private $CbDesarrollo       = true;
        private $CbAjustes          = true;
        
        
        public function __construct(){
            $this->ini();
            
            $this->addAcciones();
            $this->addFiltros();
        }
        
        private function ini(){
            if($this->CbAjustes){
                remove_action('wp_head', 'rsd_link');
                remove_action('wp_head', 'wp_generator');
                remove_action('wp_head', 'feed_links', 2);
                remove_action('wp_head', 'index_rel_link');
                remove_action('wp_head', 'wlwmanifest_link');
                remove_action('wp_head', 'feed_links_extra', 3);
                remove_action('wp_head', 'start_post_rel_link', 10, 0);
                remove_action('wp_head', 'parent_post_rel_link', 10, 0);
                remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
            }
        }
        
        private function addAcciones(){
            add_action('admin_init',        array(&$this, 'adminInit'));
            add_action('admin_head',        array(&$this, 'adminHead'));
            add_action('admin_menu',        array(&$this, 'adminMenu'));            
            add_action('wp_before_admin_bar_render',    array(&$this, 'adminBar'), 0);
        }
        
        public function addFiltros(){
            if($this->CbAjustes){
                add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;"));
                add_filter('screen_options_show_screen',        create_function('$a', "return false;"));
                add_filter('admin_footer_text',                 array(&$this, 'getTextFooterAdmin'));
            }
        }
        
        private function getStyleHeader(){
            if(!$this->CbDesarrollo){
                echo '
                    <style type="text/css">
                        #advanced-custom-fields{display:none;}
                        #core-desarrollo-wp-plugins{display:none;}
                        #toplevel_page_edit-post_type-acf, #post-types-order{display:none;}
                    </style>
                ';
            }
        }
        
        /* PUBLIC INTERNAS */
        public function getTextFooterAdmin(){
            echo 'Sistema administrativo del portal Mundo Toro';    
        }
        
        public function adminInit(){
            add_action('wp_dashboard_setup', array(&$this, 'escritorioInicio'));
            
            remove_action('admin_notices', 'update_nag', 3);
            remove_action('load-update-core.php', 'wp_update_plugins');
            
            wp_enqueue_style('admin-style-mt',  WP_PLUGIN_URL .'/core-dev/css/style.css');
            wp_enqueue_script('admin-js-mt',    WP_PLUGIN_URL .'/core-dev/js/index.js');
        }
        
        public function escritorioInicio(){
            global $wp_meta_boxes;
            
    		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
            //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
            unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
            unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
            unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
            //print_r($wp_meta_boxes['dashboard']);
        }
        
        public function adminHead(){
        	global $per_page;
            $this->getStyleHeader();
            $per_page = 200;
        }
        
        public function adminBar(){
            global $wp_admin_bar;
            
            $wp_admin_bar->remove_menu('wp-logo');
            $wp_admin_bar->remove_menu('comments');
            $wp_admin_bar->remove_menu('new-content');
            $wp_admin_bar->remove_menu('updates');
        }
        
        public function adminMenu(){
            remove_submenu_page('index.php', 'update-core.php');
            remove_menu_page('link-manager.php');
            remove_menu_page('edit.php');
            remove_menu_page('edit-comments.php');
            remove_menu_page('tools.php');
            //remove_menu_page('plugins.php');
        }
    }
?>
