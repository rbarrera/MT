<?php 
	get_header(); 
	
	$LcSeccion 		= get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
	$LsFormaCartel 	= array('festejos', 'carteles');
?>
<style>

</style>
<div id="main" role="main">
	<div id="content2">
		<div id="editorial">
        	<?php if(is_front_page()):?>
            	<h2 class="entry-title"><?php echo $LcSeccion->name;?></h2>
            <?php else:?>
            	<h1 class="entry-title"><?php echo $LcSeccion->name;?></h1>
            <?php endif;?>
            <?php
				if(!in_array($LcSeccion->slug, $LsFormaCartel)):
					if(have_posts()) : while(have_posts()) : the_post();
						$LsEntre = '';
						if($LcSeccion->slug == 'entrevistas'){
							$LsEntreVista = get_field('entrevistados');
							if($LsEntreVista){ $LsEntre = ' - Entrevistado: '. $LsEntreVista; }
						}
						
						if($LcSeccion->slug == 'cronicas'){
							$LsEntreVista = get_field('festejos');
							foreach($LsEntreVista as $post):
								 $LsEntre = ' - <a href="'. get_permalink($post->ID) .'">'. get_the_title($post->ID) .'</a>';
							endforeach;
						}
						
						echo '<div class="editorial-single">';
						echo '<div class="title"><a href="'. get_permalink() .'">'. get_the_date() .''. $LsEntre .'  -  '. get_the_title() .'</a></div>';
						echo '</div>';
					endwhile; endif;
				else:
					?>
					<div class="consulta">
<style>
.labeltd{
	font-weight: bold; font-size: 14px;
}

.inputtd{
	 width: 250px; 
	 height: 20px;	
}

td{
	padding: 5px;	
}

.seletd{
	width: 255px;	
}

/*
 * jQuery UI CSS Framework 1.8.18
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Theming/API
 */

/* Layout helpers
----------------------------------*/
.ui-helper-hidden { display: none; }
.ui-helper-hidden-accessible { position: absolute !important; clip: rect(1px 1px 1px 1px); clip: rect(1px,1px,1px,1px); }
.ui-helper-reset { margin: 0; padding: 0; border: 0; outline: 0; line-height: 1.3; text-decoration: none; font-size: 100%; list-style: none; }
.ui-helper-clearfix:before, .ui-helper-clearfix:after { content: ""; display: table; }
.ui-helper-clearfix:after { clear: both; }
.ui-helper-clearfix { zoom: 1; }
.ui-helper-zfix { width: 100%; height: 100%; top: 0; left: 0; position: absolute; opacity: 0; filter:Alpha(Opacity=0); }


/* Interaction Cues
----------------------------------*/
.ui-state-disabled { cursor: default !important; }


/* Icons
----------------------------------*/

/* states and images */
.ui-icon { display: block; text-indent: -99999px; overflow: hidden; background-repeat: no-repeat; }


/* Misc visuals
----------------------------------*/

/* Overlays */
.ui-widget-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }


/*
 * jQuery UI CSS Framework 1.8.18
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Theming/API
 *
 * To view and modify this theme, visit http://jqueryui.com/themeroller/?ffDefault=Arial,sans-serif&fwDefault=bold&fsDefault=1.1em&cornerRadius=6px&bgColorHeader=cc0000&bgTextureHeader=03_highlight_soft.png&bgImgOpacityHeader=15&borderColorHeader=e3a1a1&fcHeader=ffffff&iconColorHeader=ffffff&bgColorContent=ffffff&bgTextureContent=01_flat.png&bgImgOpacityContent=75&borderColorContent=eeeeee&fcContent=333333&iconColorContent=cc0000&bgColorDefault=eeeeee&bgTextureDefault=04_highlight_hard.png&bgImgOpacityDefault=100&borderColorDefault=d8dcdf&fcDefault=004276&iconColorDefault=cc0000&bgColorHover=f6f6f6&bgTextureHover=04_highlight_hard.png&bgImgOpacityHover=100&borderColorHover=cdd5da&fcHover=111111&iconColorHover=cc0000&bgColorActive=ffffff&bgTextureActive=01_flat.png&bgImgOpacityActive=65&borderColorActive=eeeeee&fcActive=cc0000&iconColorActive=cc0000&bgColorHighlight=fbf8ee&bgTextureHighlight=02_glass.png&bgImgOpacityHighlight=55&borderColorHighlight=fcd3a1&fcHighlight=444444&iconColorHighlight=004276&bgColorError=f3d8d8&bgTextureError=08_diagonals_thick.png&bgImgOpacityError=75&borderColorError=cc0000&fcError=2e2e2e&iconColorError=cc0000&bgColorOverlay=a6a6a6&bgTextureOverlay=09_dots_small.png&bgImgOpacityOverlay=65&opacityOverlay=40&bgColorShadow=333333&bgTextureShadow=01_flat.png&bgImgOpacityShadow=0&opacityShadow=10&thicknessShadow=8px&offsetTopShadow=-8px&offsetLeftShadow=-8px&cornerRadiusShadow=8px
 */


/* Component containers
----------------------------------*/
.ui-widget { font-family: Arial,sans-serif; font-size: 1.1em; }
.ui-widget .ui-widget { font-size: 1em; }
.ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button { font-family: Arial,sans-serif; font-size: 1em; }
.ui-widget-content { border: 1px solid #eeeeee; background: #ffffff url(<?php bloginfo('template_url'); ?>/imagenes/ui-bg_flat_75_ffffff_40x100.png) 50% 50% repeat-x; color: #333333; }
.ui-widget-content a { color: #333333; }
.ui-widget-header { border: 1px solid #e3a1a1; background: #cc0000 url(<?php bloginfo('template_url'); ?>/imagenes/ui-bg_highlight-soft_15_cc0000_1x100.png) 50% 50% repeat-x; color: #ffffff; font-weight: bold; }
.ui-widget-header a { color: #ffffff; }

/* Interaction states
----------------------------------*/
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { border: 1px solid #d8dcdf; background: #eeeeee url(<?php bloginfo('template_url'); ?>/imagenes/ui-bg_highlight-hard_100_eeeeee_1x100.png) 50% 50% repeat-x; font-weight: bold; color: #004276; }
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited { color: #004276; text-decoration: none; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { border: 1px solid #cdd5da; background: #f6f6f6 url(<?php bloginfo('template_url'); ?>/imagenes/ui-bg_highlight-hard_100_f6f6f6_1x100.png) 50% 50% repeat-x; font-weight: bold; color: #111111; }
.ui-state-hover a, .ui-state-hover a:hover { color: #111111; text-decoration: none; }
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active { border: 1px solid #eeeeee; background: #ffffff url(<?php bloginfo('template_url'); ?>/imagenes/ui-bg_flat_65_ffffff_40x100.png) 50% 50% repeat-x; font-weight: bold; color: #cc0000; }
.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited { color: #cc0000; text-decoration: none; }
.ui-widget :active { outline: none; }

/* Interaction Cues
----------------------------------*/
.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight  {border: 1px solid #fcd3a1; background: #fbf8ee url(<?php bloginfo('template_url'); ?>/imagenes/ui-bg_glass_55_fbf8ee_1x400.png) 50% 50% repeat-x; color: #444444; }
.ui-state-highlight a, .ui-widget-content .ui-state-highlight a,.ui-widget-header .ui-state-highlight a { color: #444444; }
.ui-state-error, .ui-widget-content .ui-state-error, .ui-widget-header .ui-state-error {border: 1px solid #cc0000; background: #f3d8d8 url(<?php bloginfo('template_url'); ?>/imagenes/ui-bg_diagonals-thick_75_f3d8d8_40x40.png) 50% 50% repeat; color: #2e2e2e; }
.ui-state-error a, .ui-widget-content .ui-state-error a, .ui-widget-header .ui-state-error a { color: #2e2e2e; }
.ui-state-error-text, .ui-widget-content .ui-state-error-text, .ui-widget-header .ui-state-error-text { color: #2e2e2e; }
.ui-priority-primary, .ui-widget-content .ui-priority-primary, .ui-widget-header .ui-priority-primary { font-weight: bold; }
.ui-priority-secondary, .ui-widget-content .ui-priority-secondary,  .ui-widget-header .ui-priority-secondary { opacity: .7; filter:Alpha(Opacity=70); font-weight: normal; }
.ui-state-disabled, .ui-widget-content .ui-state-disabled, .ui-widget-header .ui-state-disabled { opacity: .35; filter:Alpha(Opacity=35); background-image: none; }

/* Icons
----------------------------------*/

/* states and images */
.ui-icon { width: 16px; height: 16px; background-image: url(<?php bloginfo('template_url'); ?>/imagenes/ui-icons_cc0000_256x240.png); }
.ui-widget-content .ui-icon {background-image: url(<?php bloginfo('template_url'); ?>/imagenes/ui-icons_cc0000_256x240.png); }
.ui-widget-header .ui-icon {background-image: url(<?php bloginfo('template_url'); ?>/imagenes/ui-icons_ffffff_256x240.png); }
.ui-state-default .ui-icon { background-image: url(<?php bloginfo('template_url'); ?>/imagenes/ui-icons_cc0000_256x240.png); }
.ui-state-hover .ui-icon, .ui-state-focus .ui-icon {background-image: url(<?php bloginfo('template_url'); ?>/imagenes/ui-icons_cc0000_256x240.png); }
.ui-state-active .ui-icon {background-image: url(<?php bloginfo('template_url'); ?>/imagenes/ui-icons_cc0000_256x240.png); }
.ui-state-highlight .ui-icon {background-image: url(<?php bloginfo('template_url'); ?>/imagenes/ui-icons_004276_256x240.png); }
.ui-state-error .ui-icon, .ui-state-error-text .ui-icon {background-image: url(<?php bloginfo('template_url'); ?>/imagenes/ui-icons_cc0000_256x240.png); }

/* positioning */
.ui-icon-carat-1-n { background-position: 0 0; }
.ui-icon-carat-1-ne { background-position: -16px 0; }
.ui-icon-carat-1-e { background-position: -32px 0; }
.ui-icon-carat-1-se { background-position: -48px 0; }
.ui-icon-carat-1-s { background-position: -64px 0; }
.ui-icon-carat-1-sw { background-position: -80px 0; }
.ui-icon-carat-1-w { background-position: -96px 0; }
.ui-icon-carat-1-nw { background-position: -112px 0; }
.ui-icon-carat-2-n-s { background-position: -128px 0; }
.ui-icon-carat-2-e-w { background-position: -144px 0; }
.ui-icon-triangle-1-n { background-position: 0 -16px; }
.ui-icon-triangle-1-ne { background-position: -16px -16px; }
.ui-icon-triangle-1-e { background-position: -32px -16px; }
.ui-icon-triangle-1-se { background-position: -48px -16px; }
.ui-icon-triangle-1-s { background-position: -64px -16px; }
.ui-icon-triangle-1-sw { background-position: -80px -16px; }
.ui-icon-triangle-1-w { background-position: -96px -16px; }
.ui-icon-triangle-1-nw { background-position: -112px -16px; }
.ui-icon-triangle-2-n-s { background-position: -128px -16px; }
.ui-icon-triangle-2-e-w { background-position: -144px -16px; }
.ui-icon-arrow-1-n { background-position: 0 -32px; }
.ui-icon-arrow-1-ne { background-position: -16px -32px; }
.ui-icon-arrow-1-e { background-position: -32px -32px; }
.ui-icon-arrow-1-se { background-position: -48px -32px; }
.ui-icon-arrow-1-s { background-position: -64px -32px; }
.ui-icon-arrow-1-sw { background-position: -80px -32px; }
.ui-icon-arrow-1-w { background-position: -96px -32px; }
.ui-icon-arrow-1-nw { background-position: -112px -32px; }
.ui-icon-arrow-2-n-s { background-position: -128px -32px; }
.ui-icon-arrow-2-ne-sw { background-position: -144px -32px; }
.ui-icon-arrow-2-e-w { background-position: -160px -32px; }
.ui-icon-arrow-2-se-nw { background-position: -176px -32px; }
.ui-icon-arrowstop-1-n { background-position: -192px -32px; }
.ui-icon-arrowstop-1-e { background-position: -208px -32px; }
.ui-icon-arrowstop-1-s { background-position: -224px -32px; }
.ui-icon-arrowstop-1-w { background-position: -240px -32px; }
.ui-icon-arrowthick-1-n { background-position: 0 -48px; }
.ui-icon-arrowthick-1-ne { background-position: -16px -48px; }
.ui-icon-arrowthick-1-e { background-position: -32px -48px; }
.ui-icon-arrowthick-1-se { background-position: -48px -48px; }
.ui-icon-arrowthick-1-s { background-position: -64px -48px; }
.ui-icon-arrowthick-1-sw { background-position: -80px -48px; }
.ui-icon-arrowthick-1-w { background-position: -96px -48px; }
.ui-icon-arrowthick-1-nw { background-position: -112px -48px; }
.ui-icon-arrowthick-2-n-s { background-position: -128px -48px; }
.ui-icon-arrowthick-2-ne-sw { background-position: -144px -48px; }
.ui-icon-arrowthick-2-e-w { background-position: -160px -48px; }
.ui-icon-arrowthick-2-se-nw { background-position: -176px -48px; }
.ui-icon-arrowthickstop-1-n { background-position: -192px -48px; }
.ui-icon-arrowthickstop-1-e { background-position: -208px -48px; }
.ui-icon-arrowthickstop-1-s { background-position: -224px -48px; }
.ui-icon-arrowthickstop-1-w { background-position: -240px -48px; }
.ui-icon-arrowreturnthick-1-w { background-position: 0 -64px; }
.ui-icon-arrowreturnthick-1-n { background-position: -16px -64px; }
.ui-icon-arrowreturnthick-1-e { background-position: -32px -64px; }
.ui-icon-arrowreturnthick-1-s { background-position: -48px -64px; }
.ui-icon-arrowreturn-1-w { background-position: -64px -64px; }
.ui-icon-arrowreturn-1-n { background-position: -80px -64px; }
.ui-icon-arrowreturn-1-e { background-position: -96px -64px; }
.ui-icon-arrowreturn-1-s { background-position: -112px -64px; }
.ui-icon-arrowrefresh-1-w { background-position: -128px -64px; }
.ui-icon-arrowrefresh-1-n { background-position: -144px -64px; }
.ui-icon-arrowrefresh-1-e { background-position: -160px -64px; }
.ui-icon-arrowrefresh-1-s { background-position: -176px -64px; }
.ui-icon-arrow-4 { background-position: 0 -80px; }
.ui-icon-arrow-4-diag { background-position: -16px -80px; }
.ui-icon-extlink { background-position: -32px -80px; }
.ui-icon-newwin { background-position: -48px -80px; }
.ui-icon-refresh { background-position: -64px -80px; }
.ui-icon-shuffle { background-position: -80px -80px; }
.ui-icon-transfer-e-w { background-position: -96px -80px; }
.ui-icon-transferthick-e-w { background-position: -112px -80px; }
.ui-icon-folder-collapsed { background-position: 0 -96px; }
.ui-icon-folder-open { background-position: -16px -96px; }
.ui-icon-document { background-position: -32px -96px; }
.ui-icon-document-b { background-position: -48px -96px; }
.ui-icon-note { background-position: -64px -96px; }
.ui-icon-mail-closed { background-position: -80px -96px; }
.ui-icon-mail-open { background-position: -96px -96px; }
.ui-icon-suitcase { background-position: -112px -96px; }
.ui-icon-comment { background-position: -128px -96px; }
.ui-icon-person { background-position: -144px -96px; }
.ui-icon-print { background-position: -160px -96px; }
.ui-icon-trash { background-position: -176px -96px; }
.ui-icon-locked { background-position: -192px -96px; }
.ui-icon-unlocked { background-position: -208px -96px; }
.ui-icon-bookmark { background-position: -224px -96px; }
.ui-icon-tag { background-position: -240px -96px; }
.ui-icon-home { background-position: 0 -112px; }
.ui-icon-flag { background-position: -16px -112px; }
.ui-icon-calendar { background-position: -32px -112px; }
.ui-icon-cart { background-position: -48px -112px; }
.ui-icon-pencil { background-position: -64px -112px; }
.ui-icon-clock { background-position: -80px -112px; }
.ui-icon-disk { background-position: -96px -112px; }
.ui-icon-calculator { background-position: -112px -112px; }
.ui-icon-zoomin { background-position: -128px -112px; }
.ui-icon-zoomout { background-position: -144px -112px; }
.ui-icon-search { background-position: -160px -112px; }
.ui-icon-wrench { background-position: -176px -112px; }
.ui-icon-gear { background-position: -192px -112px; }
.ui-icon-heart { background-position: -208px -112px; }
.ui-icon-star { background-position: -224px -112px; }
.ui-icon-link { background-position: -240px -112px; }
.ui-icon-cancel { background-position: 0 -128px; }
.ui-icon-plus { background-position: -16px -128px; }
.ui-icon-plusthick { background-position: -32px -128px; }
.ui-icon-minus { background-position: -48px -128px; }
.ui-icon-minusthick { background-position: -64px -128px; }
.ui-icon-close { background-position: -80px -128px; }
.ui-icon-closethick { background-position: -96px -128px; }
.ui-icon-key { background-position: -112px -128px; }
.ui-icon-lightbulb { background-position: -128px -128px; }
.ui-icon-scissors { background-position: -144px -128px; }
.ui-icon-clipboard { background-position: -160px -128px; }
.ui-icon-copy { background-position: -176px -128px; }
.ui-icon-contact { background-position: -192px -128px; }
.ui-icon-image { background-position: -208px -128px; }
.ui-icon-video { background-position: -224px -128px; }
.ui-icon-script { background-position: -240px -128px; }
.ui-icon-alert { background-position: 0 -144px; }
.ui-icon-info { background-position: -16px -144px; }
.ui-icon-notice { background-position: -32px -144px; }
.ui-icon-help { background-position: -48px -144px; }
.ui-icon-check { background-position: -64px -144px; }
.ui-icon-bullet { background-position: -80px -144px; }
.ui-icon-radio-off { background-position: -96px -144px; }
.ui-icon-radio-on { background-position: -112px -144px; }
.ui-icon-pin-w { background-position: -128px -144px; }
.ui-icon-pin-s { background-position: -144px -144px; }
.ui-icon-play { background-position: 0 -160px; }
.ui-icon-pause { background-position: -16px -160px; }
.ui-icon-seek-next { background-position: -32px -160px; }
.ui-icon-seek-prev { background-position: -48px -160px; }
.ui-icon-seek-end { background-position: -64px -160px; }
.ui-icon-seek-start { background-position: -80px -160px; }
/* ui-icon-seek-first is deprecated, use ui-icon-seek-start instead */
.ui-icon-seek-first { background-position: -80px -160px; }
.ui-icon-stop { background-position: -96px -160px; }
.ui-icon-eject { background-position: -112px -160px; }
.ui-icon-volume-off { background-position: -128px -160px; }
.ui-icon-volume-on { background-position: -144px -160px; }
.ui-icon-power { background-position: 0 -176px; }
.ui-icon-signal-diag { background-position: -16px -176px; }
.ui-icon-signal { background-position: -32px -176px; }
.ui-icon-battery-0 { background-position: -48px -176px; }
.ui-icon-battery-1 { background-position: -64px -176px; }
.ui-icon-battery-2 { background-position: -80px -176px; }
.ui-icon-battery-3 { background-position: -96px -176px; }
.ui-icon-circle-plus { background-position: 0 -192px; }
.ui-icon-circle-minus { background-position: -16px -192px; }
.ui-icon-circle-close { background-position: -32px -192px; }
.ui-icon-circle-triangle-e { background-position: -48px -192px; }
.ui-icon-circle-triangle-s { background-position: -64px -192px; }
.ui-icon-circle-triangle-w { background-position: -80px -192px; }
.ui-icon-circle-triangle-n { background-position: -96px -192px; }
.ui-icon-circle-arrow-e { background-position: -112px -192px; }
.ui-icon-circle-arrow-s { background-position: -128px -192px; }
.ui-icon-circle-arrow-w { background-position: -144px -192px; }
.ui-icon-circle-arrow-n { background-position: -160px -192px; }
.ui-icon-circle-zoomin { background-position: -176px -192px; }
.ui-icon-circle-zoomout { background-position: -192px -192px; }
.ui-icon-circle-check { background-position: -208px -192px; }
.ui-icon-circlesmall-plus { background-position: 0 -208px; }
.ui-icon-circlesmall-minus { background-position: -16px -208px; }
.ui-icon-circlesmall-close { background-position: -32px -208px; }
.ui-icon-squaresmall-plus { background-position: -48px -208px; }
.ui-icon-squaresmall-minus { background-position: -64px -208px; }
.ui-icon-squaresmall-close { background-position: -80px -208px; }
.ui-icon-grip-dotted-vertical { background-position: 0 -224px; }
.ui-icon-grip-dotted-horizontal { background-position: -16px -224px; }
.ui-icon-grip-solid-vertical { background-position: -32px -224px; }
.ui-icon-grip-solid-horizontal { background-position: -48px -224px; }
.ui-icon-gripsmall-diagonal-se { background-position: -64px -224px; }
.ui-icon-grip-diagonal-se { background-position: -80px -224px; }


/* Misc visuals
----------------------------------*/

/* Corner radius */
.ui-corner-all, .ui-corner-top, .ui-corner-left, .ui-corner-tl { -moz-border-radius-topleft: 6px; -webkit-border-top-left-radius: 6px; -khtml-border-top-left-radius: 6px; border-top-left-radius: 6px; }
.ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr { -moz-border-radius-topright: 6px; -webkit-border-top-right-radius: 6px; -khtml-border-top-right-radius: 6px; border-top-right-radius: 6px; }
.ui-corner-all, .ui-corner-bottom, .ui-corner-left, .ui-corner-bl { -moz-border-radius-bottomleft: 6px; -webkit-border-bottom-left-radius: 6px; -khtml-border-bottom-left-radius: 6px; border-bottom-left-radius: 6px; }
.ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br { -moz-border-radius-bottomright: 6px; -webkit-border-bottom-right-radius: 6px; -khtml-border-bottom-right-radius: 6px; border-bottom-right-radius: 6px; }

/* Overlays */
.ui-widget-overlay { background: #a6a6a6 url(<?php bloginfo('template_url'); ?>/imagenes/ui-bg_dots-small_65_a6a6a6_2x2.png) 50% 50% repeat; opacity: .40;filter:Alpha(Opacity=40); }
.ui-widget-shadow { margin: -8px 0 0 -8px; padding: 8px; background: #333333 url(<?php bloginfo('template_url'); ?>/imagenes/ui-bg_flat_0_333333_40x100.png) 50% 50% repeat-x; opacity: .10;filter:Alpha(Opacity=10); -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px; }/*
 * jQuery UI Datepicker 1.8.18
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Datepicker#theming
 */
.ui-datepicker { width: 17em; padding: .2em .2em 0; display: none; }
.ui-datepicker .ui-datepicker-header { position:relative; padding:.2em 0; }
.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next { position:absolute; top: 2px; width: 1.8em; height: 1.8em; }
.ui-datepicker .ui-datepicker-prev-hover, .ui-datepicker .ui-datepicker-next-hover { top: 1px; }
.ui-datepicker .ui-datepicker-prev { left:2px; }
.ui-datepicker .ui-datepicker-next { right:2px; }
.ui-datepicker .ui-datepicker-prev-hover { left:1px; }
.ui-datepicker .ui-datepicker-next-hover { right:1px; }
.ui-datepicker .ui-datepicker-prev span, .ui-datepicker .ui-datepicker-next span { display: block; position: absolute; left: 50%; margin-left: -8px; top: 50%; margin-top: -8px;  }
.ui-datepicker .ui-datepicker-title { margin: 0 2.3em; line-height: 1.8em; text-align: center; }
.ui-datepicker .ui-datepicker-title select { font-size:1em; margin:1px 0; }
.ui-datepicker select.ui-datepicker-month-year {width: 100%;}
.ui-datepicker select.ui-datepicker-month, 
.ui-datepicker select.ui-datepicker-year { width: 49%;}
.ui-datepicker table {width: 100%; font-size: .9em; border-collapse: collapse; margin:0 0 .4em; }
.ui-datepicker th { padding: .7em .3em; text-align: center; font-weight: bold; border: 0;  }
.ui-datepicker td { border: 0; padding: 1px; }
.ui-datepicker td span, .ui-datepicker td a { display: block; padding: .2em; text-align: right; text-decoration: none; }
.ui-datepicker .ui-datepicker-buttonpane { background-image: none; margin: .7em 0 0 0; padding:0 .2em; border-left: 0; border-right: 0; border-bottom: 0; }
.ui-datepicker .ui-datepicker-buttonpane button { float: right; margin: .5em .2em .4em; cursor: pointer; padding: .2em .6em .3em .6em; width:auto; overflow:visible; }
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current { float:left; }

/* with multiple calendars */
.ui-datepicker.ui-datepicker-multi { width:auto; }
.ui-datepicker-multi .ui-datepicker-group { float:left; }
.ui-datepicker-multi .ui-datepicker-group table { width:95%; margin:0 auto .4em; }
.ui-datepicker-multi-2 .ui-datepicker-group { width:50%; }
.ui-datepicker-multi-3 .ui-datepicker-group { width:33.3%; }
.ui-datepicker-multi-4 .ui-datepicker-group { width:25%; }
.ui-datepicker-multi .ui-datepicker-group-last .ui-datepicker-header { border-left-width:0; }
.ui-datepicker-multi .ui-datepicker-group-middle .ui-datepicker-header { border-left-width:0; }
.ui-datepicker-multi .ui-datepicker-buttonpane { clear:left; }
.ui-datepicker-row-break { clear:both; width:100%; font-size:0em; }

/* RTL support */
.ui-datepicker-rtl { direction: rtl; }
.ui-datepicker-rtl .ui-datepicker-prev { right: 2px; left: auto; }
.ui-datepicker-rtl .ui-datepicker-next { left: 2px; right: auto; }
.ui-datepicker-rtl .ui-datepicker-prev:hover { right: 1px; left: auto; }
.ui-datepicker-rtl .ui-datepicker-next:hover { left: 1px; right: auto; }
.ui-datepicker-rtl .ui-datepicker-buttonpane { clear:right; }
.ui-datepicker-rtl .ui-datepicker-buttonpane button { float: left; }
.ui-datepicker-rtl .ui-datepicker-buttonpane button.ui-datepicker-current { float:right; }
.ui-datepicker-rtl .ui-datepicker-group { float:right; }
.ui-datepicker-rtl .ui-datepicker-group-last .ui-datepicker-header { border-right-width:0; border-left-width:1px; }
.ui-datepicker-rtl .ui-datepicker-group-middle .ui-datepicker-header { border-right-width:0; border-left-width:1px; }

/* IE6 IFRAME FIX (taken from datepicker 1.5.3 */
.ui-datepicker-cover {
    display: none; /*sorry for IE5*/
    display/**/: block; /*sorry for IE5*/
    position: absolute; /*must have*/
    z-index: -1; /*must have*/
    filter: mask(); /*must have*/
    top: -4px; /*must have*/
    left: -4px; /*must have*/
    width: 200px; /*must have*/
    height: 200px; /*must have*/
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script>
	jQuery(document).ready(function(e) {
		var DiasActi = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
		var DiasActiMini = ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"];
		var MesesActi = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
		
		jQuery("#txtinicio").datepicker({dateFormat: "dd/mm/yy", dayNamesMin : DiasActiMini, monthNames : MesesActi, dayNames : DiasActi });
		jQuery("#txtfinal").datepicker({dateFormat: "dd/mm/yy", dayNamesMin : DiasActiMini, monthNames : MesesActi, dayNames : DiasActi });
	});
</script>
<form action="" method="post">
<table width="100%" border="1">
  <tr>
    <td width="50%" class="labeltd">Fecha desde</td>
    <td class="labeltd">Fecha hasta</td>
  </tr>
  <tr>
    <td><input type="text" name="txtinicio" id="txtinicio" class="inputtd" readonly></td>
    <td><input type="text" name="txtfinal" id="txtfinal" class="inputtd" readonly></td>
  </tr>
  <tr>
    <td class="labeltd">Ganaderias</td>
    <td class="labeltd">Toreros</td>
  </tr>
  <tr>
    <td><select name="ganaderia" id="ganaderia" class="seletd"><?php getTaxiSelect('ganaderiataximt', 'Seleccione una ganaderia', 'No hay ninguna ganaderia');?></select></td>
    <td><select name="toreros" id="toreros" class="seletd"><?php getTaxiSelect('torerotaximt', 'Seleccione un torero', 'No hay ninguno torero');?></select></td>
  </tr>
  <tr>
    <td class="labeltd">Localidades</td>
    <td class="labeltd">Paises</td>
  </tr>
  <tr>
    <td><select name="localidad" id="localidad" class="seletd"><?php getTaxiSelect('localidadtaximt', 'Seleccione una localidad', 'No hay ninguna localidad');?></select></td>
    <td><select name="pais" id="pais" class="seletd"><?php getTaxiSelect('paistaximt', 'Seleccione un pais', 'No hay ninguno pais');?></select></td>
  </tr>
  <tr>
    <td><input type="submit" name="button" id="button" value="Buscar">
      <input type="reset" name="button2" id="button2" value="Restablecer"></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

					</div>
					<?php
					
					if((isset($_POST['txtinicio']) and !empty($_POST['txtinicio'])) or (isset($_POST['txtfinal']) and !empty($_POST['txtfinal'])) or (isset($_POST['ganaderia']) and $_POST['ganaderia'] != '0' ) or (isset($_POST['toreros']) and $_POST['toreros'] != '0' ) or (isset($_POST['localidad']) and $_POST['localidad'] != '0' ) or (isset($_POST['pais']) and $_POST['pais'] != '0' )){
						$LbPasarTaxi 	= false;
						$LsArguTaxi 	= array(
							'relation' => 'OR'
						);
						
						if((isset($_POST['ganaderia']) and $_POST['ganaderia'] != '0')){
							$LbPasarTaxi = true;
							array_push($LsArguTaxi, 
								array(
									'taxonomy' 	=> 'ganaderiataximt',
									'field' 	=> 'slug',
									'terms' 	=> $_POST['ganaderia']
								)
							);
						}
						
						if((isset($_POST['toreros']) and $_POST['toreros'] != '0')){
							$LbPasarTaxi = true;
							array_push($LsArguTaxi, 
								array(
									'taxonomy' 	=> 'torerotaximt',
									'field' 	=> 'slug',
									'terms' 	=> $_POST['toreros']
								)
							);
						}
						
						if((isset($_POST['pais']) and $_POST['pais'] != '0')){
							$LbPasarTaxi = true;
							array_push($LsArguTaxi, 
								array(
									'taxonomy' 	=> 'paistaximt',
									'field' 	=> 'slug',
									'terms' 	=> $_POST['pais']
								)
							);
						}
						
						if((isset($_POST['localidad']) and $_POST['localidad'] != '0')){
							$LbPasarTaxi = true;
							array_push($LsArguTaxi, 
								array(
									'taxonomy' 	=> 'localidadtaximt',
									'field' 	=> 'slug',
									'terms' 	=> $_POST['localidad']
								)
							);
						}
						
						$LaMeta = array();
						if((isset($_POST['txtinicio']) and !empty($_POST['txtinicio'])) and (isset($_POST['txtfinal']) and !empty($_POST['txtfinal']))){
							$LaMeta = array(
								'relation'		=> 'OR',
								array(
									'key' 		=> 'fechaini',
									'value' 	=> array($_POST['txtinicio'], $_POST['txtfinal']),
									'compare' 	=> 'BETWEEN',
									'type'		=> 'DATE'
								),
								array(
									'key' 		=> 'fechafin',
									'value' 	=> array($_POST['txtinicio'], $_POST['txtfinal']),
									'compare' 	=> 'BETWEEN',
									'type'		=> 'DATE'
								)
							);
						}
							
						
						$LaArgu = array(
							'post_type'		 => 'postfullmt',
							'tax_query' 	 => $LsArguTaxi,
							'meta_query' 	 => $LaMeta
						);
						
						global $wp_query;
						$args = array_merge($wp_query->query, $LaArgu);
						query_posts($args);
					}
					
					if(have_posts()) : while(have_posts()) : the_post();
						$LsFecha = get_field('fechaini');
						echo '<div class="cartel">';
						echo (!empty($LsFecha)) ? '<div class="fecha">'. $LsFecha .'</div>' : '';
						echo '<div class="title"><a href="'. get_permalink() .'">'. get_the_date() .' - Cartel: '. get_the_title() .'</a></div>';
						echo '</div>';
					endwhile; endif;
				endif;					
			?>
        </div>
    </div>
    <div class="HRconte"></div>
</div>
<?php get_sidebar(); get_footer(); ?>