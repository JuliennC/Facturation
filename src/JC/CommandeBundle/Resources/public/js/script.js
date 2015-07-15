
/*
*	Fonction qui coche les checbox de la ville passée en paramettre
*/
 function metVille(ventilation, nomColl, idColl, repartition){

 	if(ventilation == "Mutualisee"){
        
        //On marque le checkbox
        
        //On recupere la ville selectionnee
		var checkbox = document.getElementById("jc_commandebundle_commande_villes_concernees_"+nomColl);
        //Dans les deux cas (mutualise et directe) on met check le checkbox
		checkbox.setAttribute('checked', 'checked');
        
	} else if(ventilation == "Directe"){
		
		//Si la commande �tait au parravant mutualis�e
		//Et qu'on la change en directe, si une erreur dans le form, alors repartition sera
		//La cl� de repartition de l'applicatoin (ce que l'on stock lorqu'une commande est mutualis�es)
		if($.isNumeric(repartition)){
			document.getElementById('input_repartition_'+nomColl).setAttribute('value',repartition);
			document.getElementById('jc_commandebundle_commande_repartition'+idColl).setAttribute('value',repartition);
		}
		
	} else {
		alerte ("Erreur de ventilation.. ");
	}
	
}



/*
*	Fonction qui remet les valeurs en commande directe
*	d'un precedent formulaire (avec fautes)
*/
function remetValeur(nomColl, idColl){
	console.log(' l : '+nomColl);
	document.getElementById('input_repartition_'+nomColl).setAttribute('value',$('#jc_commandebundle_commande_repartition'+idColl).val());
	
}




	/* 
	*	Fonction appelé lorsque l'utilisateur veut changer l'etat d'une commmande, 
	*	Elle envoie la requete et indique la réponse
	*/
function changementEtatCommande(idC, etatC){
	
	if(etatC == "Payee"){
		
		var data = 'id='+idC;
		
		//On appelle la route qui va mettre la commande � pay�e
		$.ajax({
				type: "get",
				url: Routing.generate('jc_commande_marque_payee'),
				data: data,
				success: function(json){	
	   				
	   				//On recharge la page
					location.reload();
	        }
	    });    
	
	
	} else {
		
		$(".hidden_etat").attr('value',etatC);

		$(".save").click();
		   
	}  
}
   


function setInfos(type, nom, adresse, complementAdresse, ville, codePostal, telephone){
    
    console.log(type);
    document.getElementById('jc_commandebundle_commande_nom'+type).value = nom;
    document.getElementById('jc_commandebundle_commande_adresse'+type).value = adresse;
    document.getElementById('jc_commandebundle_commande_complementAdresse'+type).value = complementAdresse;
    document.getElementById('jc_commandebundle_commande_ville'+type).value = ville;
    document.getElementById('jc_commandebundle_commande_codePostal'+type).value = codePostal;
    document.getElementById('jc_commandebundle_commande_telephone'+type).value = telephone;
    
    $("#bouton_close_modal_"+type).click();
}
   
   
   
   
  
/*Number.prototype.formatMoney = function(c, d, t){
	var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };*/


function calcul_TTC(id){
    
    var quantite = document.getElementById('jc_commandebundle_commande_listeLignesCommande_'+id+'_quantite').value;
    var prix_unitaire = document.getElementById('jc_commandebundle_commande_listeLignesCommande_'+id+'_prixUnitaire').value;

    var select = document.getElementById('jc_commandebundle_commande_listeLignesCommande_'+id+'_tva');
    var pourcentage = select.options[select.selectedIndex].text;
    var p = pourcentage.replace("%", "");

    var total = (quantite * prix_unitaire * (1 + (p/100))).toFixed(2);

    var label_total = document.getElementById('total_TTC_'+id);
    label_total.innerHTML = total+" €";
    
    document.getElementById('jc_commandebundle_commande_listeLignesCommande_'+id+'_totalTTC').value = total;
}  








function metEnPlaceVentilation(ventil){
	if(ventil.indexOf('Directe')>-1) { $('#boutonDirecte').click();}
	else if(ventil.indexOf('Mutualisee')>-1){ $('#boutonMutualisee').click();}
	else {alert("Erreur de ventilation.. '"+ventil+"'");}
}



/*
*	jQuery
*/
$(document).ready(function() {
   
   
    $("#ajouter_ligne_commande").on('click', function(){
      	
      	// Dans le contenu de l'attribut « data-prototype », on remplace :
	  	// - le texte "__name__label__" qu'il contient par le label du champ
	  	// - le texte "__name__" qu'il contient par le numéro du champ
	  	
	  	var tableL = $("#tbody_corps");
                //On fait -1 car il y a la ligne du bouton "ajouter"
	  	var index = (tableL.find('tr').length)-1;
	  	
	 

        // parcourt le template prototype
        //var newLigne = $("#jc_commandebundle_commande_lignesCommande").attr('data-prototype');
           
    
    
    var newLigne = 
						"<td>"+
							"<textarea id='jc_commandebundle_commande_listeLignesCommande___name___libelle' name='jc_commandebundle_commande[listeLignesCommande][__name__][libelle]' required='required' 											class='col-md-11 col-md-offset-1'> </textarea>"+ 
						"</td>"+
						
						"<td>"+
							"<textarea id='jc_commandebundle_commande_listeLignesCommande___name___commentaire' name='jc_commandebundle_commande[listeLignesCommande][__name__][commentaire]' 														class='col-md-11 col-md-offset-1'> </textarea>"+
						"</td>"+
						
						"<td>"+
							"<input type='text' id='jc_commandebundle_commande_listeLignesCommande___name___reference' name='jc_commandebundle_commande[listeLignesCommande][__name__][reference]' 										required='required'	class='col-md-11 col-md-offset-1'>"+
						"</td>"+
						
						"<td>"+ 
							"<input type='text' onkeyup='calcul_TTC(__name__);' id='jc_commandebundle_commande_listeLignesCommande___name___quantite' name='jc_commandebundle_commande[listeLignesCommande][__name__][quantite]' 										required='required' class='col-md-11 col-md-offset-1'>"+ 
						"</td>"+
						
						"<td>"+
							"<input type='text' onkeyup='calcul_TTC(__name__);'  id='jc_commandebundle_commande_listeLignesCommande___name___prixUnitaire' name='jc_commandebundle_commande[listeLignesCommande][__name__][prixUnitaire]' 												required='required' class='col-md-10 col-md-offset-1'> €"+
						"</td>"+
							
						"<td>"+
						 	"<select onchange='calcul_TTC(__name__);' id='jc_commandebundle_commande_listeLignesCommande___name___tva' name='jc_commandebundle_commande[listeLignesCommande][__name__][tva]' 															class='col-md-12 col-md-offset-0'>";
						 	
						 	//On va chercher les taux de TVA dans la base
						 	
						 	//	On dit à ajax d'être synchrone
						 	//	Inconvéniant --> Si la requête est lente, la nouvelle ligne mettra du temps à s'afficher
						 	//	Avantage --> On est sur qu'il y aura les bon % de TVA dans les choix
						 	$.ajaxSetup({async: false});
						 	
						 	$.ajax({
						        type: "get",
						        url: Routing.generate('jc_commande_get_tva'),
						        success: function(json){						
						   			
						   			if( json.length === 0) {
							   			alert("Une erreur s'est produite, veuillez réessayer");
										
										//On remet la valeur par défaut
										$.ajaxSetup({async: true});
								        
								        return false;


						   			} else {
							   			
							           $.each(json, function(index, value){

									   		newLigne += "<option value='"+value['id']+"'>"+value['pourcentage']+"%</option>"
							
										})
									
									
										newLigne += "</select>"+
													"</td>"+
													
													"<td>"+
														"<label class='col-md-11 col-md-offset-1' id='total_TTC___name__' value='0.00 �'></label>"+
													"</td>"+ 
                                                                                                
                                                                                                            "<input type='hidden' id='jc_commandebundle_commande_listeLignesCommande___name___totalTTC' name='jc_commandebundle_commande[listeLignesCommande][__name__][totalTTC]' value='0.00' />"
                                                                                                        ;
							      	
							      	
							     
							      	
								      	// remplace les "__name__" utilisés dans l'id 
								        // par un nombre unique 
								        newLigne = newLigne.replace(/__name__/g, index);
								        
								        // créer une nouvelle liste d'éléments et l'ajoute à notre liste
								        var newLi = jQuery('<tr></tr>').html(newLigne);
								        newLi.appendTo(tableL);
								        
								        //	On remet la valeur par défaut
										$.ajaxSetup({async: true});
										
								        return false;

									}
						        }
						    });    
						 	

						 	
						 	
						 	
						 	
						

  });
   



	/* 
	*	Fonction utilisé dans la création et la modification d'une commande, 
	*	Elle gère l'affichage des villes suivant le choix "mutualisée" ou "directe"
	*/
	$('#select-ventilation a').click(function(){

		if( $(this).attr("id") == 'boutonDirecte'){
			
			//On affiche les bouton en consequence
			$('#boutonDirecte').attr('class', 'btn btn-success col-md-4 col-md-offset-2');
			$('#boutonMutualisee').attr('class', 'btn noActive col-md-4');

			//On met l'attribut ventilation
			$(".hidden_ventilation").attr('value','Directe');						
			
			//On affiche les input
			$(".contientInput").show();
			
			//On cache les checkbox 
			$('.contientCheck').hide();
			

						
			//On cache et on affiche
			//$("#form_villes_mutualisees").hide();
			
		} else if( $(this).attr("id") == 'boutonMutualisee'){
			
			//On met les boutons en consequence
			$('#boutonDirecte').attr('class', 'btn noActive col-md-4 col-md-offset-2');
			$('#boutonMutualisee').attr('class', 'btn btn-success col-md-4');		
			
			//On met la valeur de ventilation
			$(".hidden_ventilation").attr('value','Mutualisee');
			
			//On chache les input
			$(".contientInput").hide();
			
			//On remet le checkbox visible
			$('.contientCheck').show();
			
			


		}

	});


	




	/*
	* Lorsque l'on clique sur un bouton d'une ville l'imput correspondant se focus, 
	*/
	$(".btn_input_repartition").on('click',function() {

		var input = $(this).attr('for');
		$('#'+input).focus();
	});





	$('.contientInput input').on('keyup',function(){
		
		//On recupere la ville concernee
		var villeConcernee = $(this).attr('for');
		
		//On met � jour le champs cache concerne
		var hidden = $('input[attr_nom_ville='+villeConcernee+']');

        //On sauvegarde la repartition
		hidden.attr('value', $(this).val());
		
		console.log(hidden);
	});
	
	

	

	/*
	* Lorsque l'on choisi une activite, 
	* la liste des applications devient la liste des applications 
	* en lien avec l'activite
	*/
	$(".choix_activite r").change(function() {

		var nomActivite = $( ".choix_activite option:selected").getNom();
		alert(nomActivite);
	
		var DATA = 'act=' + nomActivite;
	
		$.ajax({
	        type: "get",
	        url: "applicationPourActivite",
	        data: DATA,
	        success: function(json){
	
				$('.choix_application').find('option').remove();
	
	   			
	           $.each(json, function(index, value){
			   
			   		alert(value[0]);
				   	$(".choix_application").append('<option valuse="'+ value.nom+'">'+ value.nom+'</option>');
	
				})
	
	        }
	    });    

	}); 
	
	
});




