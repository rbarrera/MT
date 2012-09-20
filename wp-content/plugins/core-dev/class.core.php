<?php
    class coreDevExtends{
        
        private $CsLabel            = '';
        private $CsNombre           = '';
        private $CsFiltroTaxi       = '';
        private $CaMenus            = array();
        private $CaSubMenus         = array();
        private $CaCampos           = array();
        private $CaMetaBox          = array();
        private $CbOrdenar          = true;
        
        public function __construct(){
            
        }
        
        public function crearPost($PaLabel, $PsMenu, $PsNombre, $PaSoporte, $PaTaxis = array()){
            $LsSingle   = strtolower($PaLabel[0]);
            $LsPlural   = strtolower($PaLabel[1]);
            $this->CsLabel = $PaLabel[1];
            
            $LaArgu     = array(
                'label'           => $PaLabel[1],
        		'description'     => '',
        		'public'          => true,
        		'show_ui'         => true,
        		'show_in_menu'    => false,
        		'capability_type' => 'post',
        		'hierarchical'    => false,
                'map_meta_cap'    => true,  
        		'rewrite'         => array('slug' => $LsSingle),
        		'query_var'       => true,
        		'menu_position'   => 6,
        		'supports'        => $PaSoporte,
        		'taxonomies'      => $PaTaxis,
        		'labels'          => array(
        			'name'               => ucfirst($LsPlural),
        			'singular_name'      => ucfirst($LsSingle),        			
        			'add_new'            => 'Agregar nueva',
        			'add_new_item'       => 'Agregar nueva '. $LsSingle .'',
        			'edit'               => 'Editar',
        			'edit_item'          => 'Editar '. $LsSingle .'',
        			'new_item'           => 'Nueva '. $LsSingle .'',
        			'view'               => 'Ver '. $LsSingle .'',
        			'view_item'          => 'Ver '. $LsSingle .'',
        			'search_items'       => 'Buscar '. $LsSingle .'',
        			'not_found'          => ''. $LsSingle .' no encontrada',
        			'not_found_in_trash' => ''. $LsSingle .' no encontrada en el basurero',
        			'parent'             => 'Padre de la '. $LsSingle .'',
                    
                    'menu_name'          => $PsMenu
        		)
            );
            
            $this->CsNombre = $PsNombre;
            register_post_type($PsNombre, $LaArgu);
        }
        
        public function crearTaxi($PaLabel, $PsMenu, $PsNombre, $PsPost, $PbCate = true, $PbShowMenu = false){
            $LsSingle = strtolower($PaLabel[0]);
            $LsPlural = strtolower($PaLabel[1]);
            
            register_taxonomy($PsNombre, $PsPost, 
                array(
                    'hierarchical'      => $PbCate,
                    'show_ui'           => true,
                    'show_in_nav_menus' => $PbShowMenu,
                    'show_tagcloud'     => false,
                    'query_var'         => false,
                    'rewrite'           => array('slug' => $LsSingle),
                    'label'             => ucfirst($LsPlural),
                    'singular_label'    => ucfirst($LsSingle),
                    'labels'            => array(
                        'search_items'                  => 'Buscar '. $LsPlural .'',
                        'popular_items'                 => ''. ucfirst($LsPlural) .' populares',
                        'all_items'                     => 'Todas las '. $LsPlural .'',
                        'parent_item'                   => ''. ucfirst($LsSingle) .' superior',
                        'parent_item_colon'             => ''. ucfirst($LsSingle) .' superior',
                        'edit_item'                     => 'Editar '. $LsSingle .'',
                        'update_item'                   => 'Actualizar '. $LsSingle .'',
                        'add_new_item'                  => 'Agregar nueva '. $LsSingle .'',
                        'new_item_name'                 => 'Nombre de la nueva '. $LsSingle .'',
                        'separate_items_with_commas'    => 'Separar con comas las '. $LsPlural .'',
                        'add_or_remove_items'           => 'Agregar o quitar un '. $LsSingle .'',
                        'choose_from_most_used'         => 'Elije entre las '. $LsPlural .' mas utilizadas',
                        
                        'menu_name'                     => $PsMenu
                    )
                )
            );
        }
        
        public function setOrdenarOff(){
            $this->CbOrdenar = false;
        }
        
        public function setFiltroTaxi($PsNombre){
            $this->CsFiltroTaxi = $PsNombre;
        }
        
        public function setMenuPrincipal($PsNombre, $PnLugar, $PsIcono = '', $PbTop = true){
            $this->CaMenus[0] = array($PsNombre, $PnLugar, $PsIcono, $PbTop);
        }
        
        public function addSubMenu($PsNombre, $PsTipo){
            $this->CaSubMenus[] = array($PsNombre, $PsTipo);
        }
        
        public function addCampos($PsNombre){
            $this->CaCampos[] = $PsNombre;
        }
        
        public function addCoreAcciones(){
            if(count($this->CaMetaBox) > 0) add_action('admin_init', array(&$this, 'renderMetabox'));
            if(count($this->CaMenus) > 0) add_action('admin_menu', array(&$this, 'adminMenu'));
            
            if(is_admin()){
                if(method_exists($this, 'getColumnas')) add_action('manage_edit-'. $this->CsNombre .'_columns', array(&$this, 'getColumnas'));
                if(!empty($this->CsFiltroTaxi)) add_action('restrict_manage_posts', array(&$this, 'getFilterTaxi'));                
                if(count($this->CaCampos) > 0) add_action('wp_insert_post', array(&$this, 'adminSave'), 10, 2);                   
            }
            
            if(count($this->CaMenus) > 0 and $this->CaMenus[0][3]) add_action('admin_bar_menu', array(&$this, 'adminBar'), 999);
            
            add_action('parse_request', array(&$this, 'addParceSerachID'));
        }
        
        public function addCoreFiltros(){
            if(method_exists($this, 'getEditColumnas')) add_filter('manage_'. $this->CsNombre .'_posts_custom_column', array(&$this, 'getEditColumnas'));
            if(method_exists($this, 'getSortColumnas')) add_filter('manage_edit-'. $this->CsNombre .'_sortable_columns', array(&$this, 'getSortColumnas'));
            if(method_exists($this, 'getEditor')) add_filter('tiny_mce_before_init', array(&$this, 'getEditor'));
            
            add_filter('get_search_query', array(&$this, 'showIDText'));
        }
        
        public function adminSave($post_id, $post = null){
            if($post->post_type == $this->CsNombre){
                foreach($this->CaCampos as $LsCampo){
                    $PsValor = @$_POST[$LsCampo];
                    if(!update_post_meta($post_id, $LsCampo, $PsValor)){
                        add_post_meta($post_id, $LsCampo, $PsValor);
                    }
                }
            }
        }
        
        public function addMetaBox($PsTitulo, $PsFuncion, $PsTipo = 'normal'){
            $this->CaMetaBox[] = array($PsTitulo, $PsFuncion, $PsTipo);
        }
        
        public function renderMetabox(){
            foreach($this->CaMetaBox as $LnIndex => $LaValor){
                add_meta_box('metabox_'. $LnIndex .'_'. $this->CsNombre, $LaValor[0], array(&$this, $LaValor[1]), $this->CsNombre, $LaValor[2], 'default');
            }
        }
        
        public function addParceSerachID($wp){
            global $typenow, $pagenow;
            
            if('edit.php' != $pagenow and !isset($wp->query_vars['s']) and $typenow != $this->CsNombre){
                return;
            }
            
            if(!is_numeric($wp->query_vars['s'] and $wp->query_vars['s'] < 1)){
                return;
            }
            
            $PnIdem = $wp->query_vars['s'];            
            unset($wp->query_vars['s']);
        }
        
        public function showIDText($query){
            global $typenow, $pagenow;
            
            if('edit.php' != $pagenow and $typenow != $this->CsNombre){
                return $query;
            }
            
            $s = get_query_var('s');
            if($s){return $query;}            
            $p = get_query_var('p');
            
            if($p){                
                return sprintf(" ID - %d ", $p);
            }
            
            return $query;
        }
        
        public function adminMenu(){
            $LsIcono = '';
            
            if(!empty($this->CaMenus[0][2])){
                $LsIcono = plugins_url('core-dev/imagenes/'. $this->CaMenus[0][2] .'.png');
            }
            
            add_menu_page($this->CaMenus[0][0], $this->CaMenus[0][0], 'administrator', 'edit.php?post_type='. $this->CsNombre .'', '', $LsIcono, $this->CaMenus[0][1]);
            foreach($this->CaSubMenus as $LaValor){                
                add_submenu_page('edit.php?post_type='. $this->CsNombre .'', $LaValor[0], $LaValor[0], 'administrator', 'edit-tags.php?taxonomy='. $LaValor[1] .'&post_type='. $this->CsNombre .'', '');
            }
        }
        
        public function adminBar(){
            global $wp_admin_bar;
            $wp_admin_bar->add_node(array(
                'id'        => 'padre_'. $this->CsNombre,
                'title'     => $this->CsLabel
            ));
            
            $wp_admin_bar->add_node(array(
                'id'        => 'nodo1_'. $this->CsNombre,
                'title'     => 'Agregar nuevo registro',
                'href'      => 'post-new.php?post_type='. $this->CsNombre,
                'parent'    => 'padre_'. $this->CsNombre
            ));
            
            if($this->CbOrdenar){
                $wp_admin_bar->add_node(array(
                    'id'        => 'nodo2_'. $this->CsNombre,
                    'title'     => 'Ordenar registros',
                    'href'      => 'edit.php?post_type='. $this->CsNombre .'&page=order-post-types-'. $this->CsNombre .'',
                    'parent'    => 'padre_'. $this->CsNombre
                ));
            }
            
            if(count($this->CaSubMenus) > 0){
                $wp_admin_bar->add_group(array(
                    'id'        => 'submenu_'. $this->CsNombre,
                    'parent'    => 'padre_'. $this->CsNombre,
                    'meta'      => array('class' => 'first-toolbar-group')
                ));
                
                foreach($this->CaSubMenus as $LnIndex => $LaValor){
                    $wp_admin_bar->add_node(array(
                        'id'        => 'nodo'. ($LnIndex + 3) .'_'. $this->CsNombre,
                        'title'     => $LaValor[0],
                        'href'      => 'edit-tags.php?taxonomy='. $LaValor[1] .'&post_type='. $this->CsNombre .'',
                        'parent'    => 'submenu_'. $this->CsNombre
                    ));
                }
            }
        }
        
        public function getFilterTaxi(){
            global $typenow;
            
            if($typenow == $this->CsNombre){
                $tax_obj = get_taxonomy($this->CsFiltroTaxi);
                wp_dropdown_categories( array(
                    'show_option_all'   => 'Todas las '. $tax_obj->label,
                    'taxonomy' 	        => $this->CsFiltroTaxi,
                    'name' 		        => $tax_obj->name,
                    'orderby' 	        => 'name',
                    'selected' 	        => $_GET[$this->CsFiltroTaxi],
                    'hierarchical' 	    => $tax_obj->hierarchical,
                    'show_count' 	    => true,
                    'hide_empty' 	    => false
                ));
            }
            
            if($typenow == $this->CsNombre and isset($_GET[$this->CsFiltroTaxi]) and $_GET[$this->CsFiltroTaxi] > 0){
                $LoTaxi = get_term_by('id', $_GET[$this->CsFiltroTaxi], $this->CsFiltroTaxi);
                $LaArgu = array(
                    'tax_query' => array(
                        array(
                            'taxonomy'  => $this->CsFiltroTaxi,
                            'field'     => 'slug',
                            'terms'     => $LoTaxi->slug,
                            'operator'  => 'IN'
                        )
                    )
                );
                query_posts($LaArgu);
            }
        }
        
        public function getTaxi($PnIdem, $PsTaxi){
            $LsOpciones = get_the_terms($PnIdem, $PsTaxi);
            if (!empty($LsOpciones)){
                $LaSalida = array();
                foreach ($LsOpciones as $LsOpcion){
                    $LaSalida[] = $LsOpcion->name;
                }
                echo join(', ', $LaSalida);
            }else{
                echo '- - - - -';
            }
        }
        
        public function getHTML($PsArchivo, $PaVariables = '', $PaValores = ''){
            $LsContenido = implode(file($PsArchivo));
            if($PaVariables != '' and $PaValores != ''){
                $LsContenido = str_replace($PaVariables, $PaValores, $LsContenido);
            }            
            $LsContenido = preg_replace("/({)([A-Z]*?)(})/", "", $LsContenido);                    
            return $LsContenido;
        }
    }
?>