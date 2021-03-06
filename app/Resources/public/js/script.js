$(document).ready(function() 
 {

  //Pour empêcher les navigateurs de vouloir valider les forms (Symfony s'en occupe)
  $("form").attr("novalidate",true);


  // Pour afficher le modal de connection correctement
  $('#modalConnection').appendTo("body") 
	 
  //Fonction qui affiche un datepicker (avec la propriété readonly
  $(".datepicker_readonly").datepicker({
    dateFormat: 'dd/mm/yy', 
    firstDay:1,
	}).attr("readonly","readonly");
   
   
   
	//Fonction qui affiche un datepicker
  $(".datepicker").datepicker({
    dateFormat: 'dd/mm/yy', 
    firstDay:1,
	})
   
   
	 $('.popoverData').popover();
	 
	 
	//---------- Fonction lorsqu'on clique sur recherche de commande ----------
    $('#li_recherche_commande').click(function() 
    { 
	    //On change le placeholder
	    $("#form_objetRecherche").attr("placeholder", "Entrez le numero de la commande..");
		$("#form_objetRecherche").focus();
		$("#form_objetRecherche").attr("role","commande");
		
    });
    
    
    //---------- Fonction lorsqu'on clique sur recherche de facture ----------
    $('#li_recherche_facture').click(function() 
    { 
	    //On change le placeholder
	    $("#form_objetRecherche").attr("placeholder", "Entrez le numero de la facture..");
		$("#form_objetRecherche").focus();
		$("#form_objetRecherche").attr("role","facture");

    });

    
        
    
    //---------- Fonction lorsque la barre de recherche est selectionnee ----------
	  $('#form_objetRecherche').focusin(function() 
    { 
	    //On agrandit la barre
	    $("#form_objetRecherche").animate({
				
		   'width' : "+=100"
		});
	
    });



	    //---------- Fonction lorsque la barre de recherche est deselectionnee ----------
	  $('#form_objetRecherche').focusout(function() 
    { 
	    $("#form_objetRecherche").attr("placeholder", "Recherche..");
		$("#form_objetRecherche").attr("role","tout");
		
	    //On agrandit la barre
	    $("#form_objetRecherche").animate({
				
		   'width' : "-=100"
		});
	
    });




		//---------- Fonction pour filtrer les tables ----------
		
	$('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">Aucun resultat trouve..</td></tr>'));
        }
    });
  
    
 });
