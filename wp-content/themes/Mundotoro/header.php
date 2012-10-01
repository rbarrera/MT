<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
        <title>
			<?php
				global $page, $paged;
				 
				if (is_home()){ 	bloginfo('name'); echo '|'; bloginfo('description'); } 
				if (is_author()){ 	bloginfo('name'); echo '| Archivo por autor'; } 
				if (is_single()){ 	wp_title(''); 	  echo '|'; wp_title(''); } 
				if (is_page()){ 	wp_title(''); 	  echo '|'; wp_title(''); } 
				if (is_category()){ bloginfo('name'); echo '| Archivo por Categoria |'; single_cat_title(); } 
				if (is_month()){ 	bloginfo('name'); echo '| Archivo por Mes |'; the_time('F');  }
				if (is_search()){ 	bloginfo('name'); echo '| Resultados';  }
				if (is_tag()){ 		bloginfo('name'); echo '| Archivo por Tag |'; single_tag_title('', true);  }
				
				if($paged >= 2 || $page >= 2){
					echo ' | '. sprintf(__('Page %s', ''), max($paged, $page));
				}
			?>
		</title>
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
        <link rel="shortcut icon" href="<?php bloginfo('template_url') ?>/imagenes/favicon.png">
        <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <?php wp_head(); ?>
        <script src="<?php bloginfo('template_url'); ?>/js/index.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/jquery.jcarousel.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/jquery.nivo.slider.js"></script>
	</head>
	<body <?php body_class(); ?>>
<?php
	$LbFondoPubli = get_field('visibilidadfondo', 'options');
	$LoFondoPubli = get_field('publicidadfondo', 'options');	
	$LsStyleFondo = '';
	if($LbFondoPubli and $LoFondoPubli){
		$LnMedidas = get_field('medidasinter', $LoFondoPubli->ID);
		$LnFormato = get_field('publiformat', $LoFondoPubli->ID);
		$LsArchivo = get_field('publiimagen', $LoFondoPubli->ID);
		if($LnFormato == 1 and $LnMedidas == 9 and $LsArchivo){
			$LsStyleFondo = 'style="background-image: url('. $LsArchivo .');"';
		}
	}
?>
    <div class="publicfondo" <?php echo $LsStyleFondo;?>> <!-- FONDO -->
		<div id="container"> <!-- CONTAINER -->
    		<header>
            	<div id="banner"><?php getPublicidadTop();?></div>
                <div class="clearfix"></div>
            	<nav id="top-nav">
                	<?php wp_nav_menu(array('container' => false, 'items_wrap' => '<ul id="menu-top">%3$s</ul>', 'theme_location' => 'canales')); ?>
                    <span class="search-box">
                    	<?php 	if(!is_user_logged_in ()): ?>
                        <a href="<?php bloginfo('home'); ?>/login/">Acceso</a> 
                        <?php 
								else: 
                        			global $current_user;
									get_currentuserinfo();									
									echo '<span>Hola '. $current_user->display_name .'</span> ';
								endif;			
						?>
                        <form method="get" id="searchform" action="<?php bloginfo('home'); ?>"><a href="javascript: void(0)" onClick="subirbuscar()"></a><input type="text" size="18" placeholder="SEARCH..." name="s" id="s" value="<?php echo get_search_query() ?>" onKeyPress="" /></form>
                    </span>
                </nav>
                <div id="logo">
        			<a href="<?php bloginfo('wpurl')?>"><img src="<?php bloginfo('template_url'); ?>/imagenes/logo.png"></a>
        			<span class="horaheader"><script>dia();</script></span>
      			</div>
                <nav id="med-nav">
                    <?php wp_nav_menu(array('container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' => 'secciones_a')); ?>
                     <span class="social">
                     	<a class="icomt" href="javascript: void(0);" onClick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://www.mundotoro.com');" title="Mundotoro en mi pág. de inicio" alt="Mundotoro en mi pág. de inicio">mundotoro</a>
                        <a target="_blank" class="google" href="https://plus.google.com/u/0/100892942288938113454/posts" alt="Google Plus" title="Google Plus">google</a>
                        <a target="_blank" class="twitter" href="http://twitter.com/mundotorocom" alt="Twitter" title="Twitter">twitter</a>
                        <a target="_blank" class="facebook" href="http://facebook.com/mundotoro" alt="Facebook" title="Facebook">facebook</a>
                     </span>
                </nav>
                <nav id="sub-nav">
                	<?php wp_nav_menu(array('container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' => 'secciones_b')); ?>
                </nav>
                <?php 
				$LnValorHot = get_field('actihothome', 'options');
				if(!$LnValorHot){$LnValorHot = 2;}				
				if($LnValorHot == 1):				
					$LnCantiHot = get_field('hotnewshome', 'options');
					if(!$LnCantiHot){$LnCantiHot = 10;}
					
					$LaTaxi  = array('relation' => 'OR');
					array_push($LaTaxi, array(
						'taxonomy' 	=> 'formataximt',
						'field' 	=> 'slug',
						'terms'		=> 'ultima'
					));
					
					$LaArgu = array(
						'posts_per_page' => $LnCantiHot,
						'post_type'		 => 'postfullmt',
						'tax_query'		 => $LaTaxi
					);
				?>
                <style>
					nav#sub-nav{
						border-bottom-left-radius: 0;
						border-bottom-right-radius: 0;	
					}
				</style>
                <script>
					var __HOTINTERVAL__ = <?php $LnInterHot = get_field('hothomeintervalo', 'options'); if(!$LnInterHot){$LnInterHot = 10;} echo $LnInterHot;?>;
					var __HOTFX__ = <?php $LnInterHot = get_field('hothomefx', 'options'); if(!$LnInterHot){$LnInterHot = 1;} echo $LnInterHot;?>;
				</script>
                <?php
					$querypost = new WP_Query($LaArgu);
					echo '<div id="news-sticker">';
					if ($querypost->have_posts()) : while ( $querypost->have_posts() ) : $querypost->the_post();
						echo '<div class="hotnewslist"><span class="bullet"></span><b>&Uacute;ltima hora:</b> <a href="' .get_permalink() . '">';
						echo get_the_title();
						echo '</a><span class="bullet"></span></div>';
					endwhile; endif;
					echo '</div>';
					wp_reset_postdata();
				endif;				
				?>
                <div id="banner"><?php getPublicidadTopBar();?></div>
            </header>
    
    
