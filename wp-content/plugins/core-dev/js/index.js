	jQuery(document).ready(function(e){		
		jQuery("#secctaximtchecklist input[type='checkbox'], #ganaderiataximtchecklist input[type='checkbox'], #torerotaximtchecklist input[type='checkbox'], #localidadtaximtchecklist input[type='checkbox'], #paistaximtchecklist input[type='checkbox']").each(function(index, element) {
            var checado = jQuery(element).is(':checked');
			if(checado){
				var valor = jQuery(element).val();
				jQuery('.classChangeTax').each(function(index2, element2) {
                    var valor2 = jQuery(element2).val();
					if(valor2 == valor){jQuery(element2).attr('checked', checado); return;}
                });
			}
        });
		
		jQuery('.classChangeTax').change(function(e) {
			var valor 		= jQuery(e.currentTarget).val();
			var categoria	= jQuery(e.currentTarget).data('categoria');
			var checar		= jQuery(e.currentTarget).is(':checked');
			jQuery("#in-"+ categoria +"-"+ valor).attr('checked', checar);
		});
		
		jQuery("#acf-publitipo select").change(function(e) {
			var valor 		= jQuery(e.currentTarget).val();
			var checar 		= false;
			
			jQuery("#in-tipostaximt-17").attr('checked', checar);
			jQuery("#in-tipostaximt-18").attr('checked', checar);
			jQuery("#in-tipostaximt-19").attr('checked', checar);
			
			jQuery("#acf-medidasinter").hide();
			jQuery("#acf-medidasflota").hide();
			jQuery("#acf-medidaspop").hide();
			
			if(valor == 0){return;}				
			checar = true;
			
			if(valor == 1){
				jQuery("#in-tipostaximt-17").attr('checked', checar);
				jQuery("#acf-medidasinter").show();
			}else if(valor == 2){
				jQuery("#in-tipostaximt-18").attr('checked', checar);
				jQuery("#acf-medidasflota").show();
			}else if(valor == 3){
				jQuery("#in-tipostaximt-19").attr('checked', checar);
				jQuery("#acf-medidaspop").show();
			}
        }).trigger('change');
		
		jQuery("#acf-extras input[type='checkbox']").change(function(e) {
			var valor 		= jQuery(e.currentTarget).val();
			var checar		= jQuery(e.currentTarget).is(':checked');			
			jQuery("#in-formataximt-"+ valor).attr('checked', checar);
        });
		
		
		jQuery("#acf-publiformat input[type='radio']").change(function(e) {
            var valor 		= jQuery(e.currentTarget).val();
			jQuery("#acf-publiimagen").hide();
			jQuery("#acf-publiarchi").hide();
			if(valor == 1){
				jQuery("#acf-publiimagen").show();
			}else if(valor == 2 || valor == 3){
				jQuery("#acf-publiarchi").show();
			}
        });
		
		if(jQuery("#auto_draft").size() == 0 && jQuery("#post_type").val() == 'postpublicimt'){
			var valor 		= jQuery("#acf-publiformat input[type='radio']:checked").val();
			jQuery("#acf-publiimagen").hide();
			jQuery("#acf-publiarchi").hide();
			if(valor == 1){
				jQuery("#acf-publiimagen").show();
			}else if(valor == 2 || valor == 3){
				jQuery("#acf-publiarchi").show();
			}
		}
	});	
	