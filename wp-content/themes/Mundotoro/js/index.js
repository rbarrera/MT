	/*INICIO*/

	function vacio(PoObj){ return PoObj == undefined || PoObj == null; }
	function definido(PsVariable, PoObj){return typeof((vacio(PoObj)) ? window[PsVariable] : PoObj[PsVariable]) != "undefined";}	
	function extender(PoObjPadre, PoObjHijo){if(definido('jQuery')) jQuery.extend(PoObjPadre, PoObjHijo);}
	
	jQuery.extend(Function.prototype,{
		pasar 		: function(PoObj, PaArgu){
			var self = this;
			return function(){return self.apply(PoObj, PaArgu || arguments);};
		},
		tiempo		: function(PnTiempo, PoObj, PaArgu){
			return setTimeout(this.pasar(PoObj, ((!vacio(PaArgu)) ? PaArgu : [])), PnTiempo);
		},
		intervalos 	: function(PnTiempo, PoObj, PaArgu){
			return setInterval(this.pasar(PoObj, ((!vacio(PaArgu)) ? PaArgu : [])), PnTiempo);
		}
	});
	
	function dia_semana (d1,d2,d3,d4,d5,d6,d7) {
		this[0]=d1;
		this[1]=d2;
		this[2]=d3;
		this[3]=d4;
		this[4]=d5;
		this[5]=d6;
		this[6]=d7;
	}
	
	function mes_ano (d1,d2,d3,d4,d5,d6,d7,d8,d9,d10,d11,d12) {
		this[0]=d1;
		this[1]=d2;
		this[2]=d3;
		this[3]=d4;
		this[4]=d5;
		this[5]=d6;
		this[6]=d7;
		this[7]=d8;
		this[8]=d9;
		this[9]=d10;
		this[10]=d11;
		this[11]=d12;
	}
	
	semana	= new dia_semana("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
	mes		= new mes_ano("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
	
	var today	= new Date;
	
	diahoy 		= today.getDay();
	fechahoy 	= today.getDate();
	meshoy 		= today.getMonth();
	horahoy 	= today.getHours();
	minutohoy 	= today.getMinutes();
	ano 		= today.getFullYear();
	
	function dia(){
		if (minutohoy<10) {minutohoy="0"+minutohoy}
		document.write (semana[diahoy]+', '+fechahoy);
		document.write (' de '+mes[meshoy]+' de '+ano+', '+horahoy+':'+minutohoy+'H');		
	}
	
	jQuery(document).ready(function(e) {
		
		jQuery(".classVotoClick").click(function(e) {
			e.preventDefault();
			
			var url  = jQuery(this).attr('href');
			var idem = jQuery(this).data('idem');
			
            jQuery.ajax({
				url	: "/wp-admin/admin-ajax.php",
				type: "POST",
				data: 'idem='+ idem +'&action=my_click',
				dataType: "html",
				success: function(html){
					jQuery("#myclickpubli").attr('action', url).submit();
				}
			});
        });
		
        var hots 		= jQuery("div.hotnewslist");
		var actual 		= 0;
		var siguiente	= 1;
		
		if(hots.size() > 0){
			hots.hide().css("opacity", 0).eq(actual).show().css("opacity", 1);
			if(hots.size() > 1){
				cambiohot.tiempo((__HOTINTERVAL__ * 1000));
			}
		}
		
		function cambiohot(){
			hots.eq(siguiente).show();
			hots.eq(actual).fadeTo((__HOTFX__ * 1000), 0);
			hots.eq(siguiente).fadeTo((__HOTFX__ * 1000), 1, function(){
				hots.eq(actual).hide();
				final();
			});
		}
		
		function final(){
			actual = siguiente;
			siguiente++;
			if(siguiente == hots.length) siguiente = 0;
			cambiohot.tiempo((__HOTINTERVAL__ * 1000));
		}
		
		var twidem;
		if(jQuery(".itemtw").size() > 1){
			jQuery('.pagination a').click(function(){
				cambiartw(Number(jQuery(this).attr('rel')));
			});			
			twidem = cambiotw.tiempo((__HOTINTERVALTW__ * 1000));
		}
		
		function cambiartw(n){
			clearTimeout(twidem);
			jQuery('.tttt .tweets').stop().animate({left:-800*(parseInt(n + 1)-1)});
			jQuery('.pagination a').removeClass('active').each(function(index, element) {
				var num = Number(jQuery(this).attr('rel'));
				if(n == num){jQuery(this).addClass('active');}
            });
			twidem = cambiotw.tiempo((__HOTINTERVALTW__ * 1000));
		}
		
		function cambiotw(){
			var num = Number(jQuery('.pagination a.active').attr('rel'));
			if(num == jQuery(".itemtw").length) num = 0;
			cambiartw(num);
		}
		
		jQuery(".menufooter").find('span.sepamenufooter:last').remove();
		
		jQuery("#searchform #s").keypress(function(e) {
            if(e.keyCode == 13){
				subirbuscar()
			}
        });
		
		jQuery('.mycarousel').jcarousel({});
		
		if(jQuery("#slider").size() > 0){
			jQuery('#slider').nivoSlider({
				slices: 15, // Cantidad de cortes de dicho efecto
				boxCols: 8,
				boxRows: 4,
				animSpeed: (__TIEMPOSLIDER__ * 1000), // Velocidad de la transición
				pauseTime: (__TIEMPOESPERA__ * 1000), // Tiempo de espera para mostrar otra transicion
				startSlide: 0, // Orden de imagen a mostar cuando se carga el slider (0=index)
				directionNav: true, // Permite true/false la navegación manual, usando los arrows
				directionNavHide: true, // Muestra los arrows sólo cuando el cursor esté sobre el slider.
				controlNav: true, // 1,2,3... Permite navegar usando los bullets de la parte inferior.
				keyboardNav: true, // Usa las flechas izquierda y derecha del teclado
				pauseOnHover: true, // Detener la transición cuando el cursor esté sobre el Slide
				manualAdvance: false, // Forzar a que sea sólo manualmente la transición
				captionOpacity: 0.8, // Opacidad del caption
				prevText: 'Prev',
				nextText: 'Next',
				randomStart: false, // Inicio de una transicion al azar
				beforeChange: function(){}, // Se ejecuta o activa antes de una transición
				afterChange: function(){}, // Se ejecuta o activa despues de una transición
				slideshowEnd: function(){}, // Se ejecuta o activa despues de que todas las imagenes hallan sido mostradas
				lastSlide: function(){}, // Se ejecuta o activa despues que la última imagen ha sido mostrada
				afterLoad: function(){} // Se ejecuta o activa cuando el slider ha sido cargado
			});
		}
    });
	
	function set_Cookie(name, value, expires, path, domain, secure){
		var today = new Date();
		today.setTime(today.getTime());
		
		if(expires){ }
				
		var expires_date = new Date(today.getTime() + 3600);
		
		document.cookie = name + "=" +escape(value) +
		((expires) ? ";expires=" + expires_date.toGMTString() : "") +
		((path) ? ";path=" + path : "") +
		((domain) ? ";domain=" + domain : "") +
		((secure) ? ";secure" : "");
	}
	
	function subirbuscar(){		
		jQuery("#searchform").submit();	
	}
	
	

	
	

	
	
	
	
	
	
	
	
	
	
	
	
	